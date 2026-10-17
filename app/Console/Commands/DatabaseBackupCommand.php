<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class DatabaseBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup 
                            {--filename= : Specific backup file name} 
                            {--timestamp : Append current timestamp to filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a clean, full SQL backup of the MySQL database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $connection = config('database.default');
        $dbConfig = config("database.connections.{$connection}");

        $driver = $dbConfig['driver'] ?? $connection;

        if ($driver === 'sqlite') {
            $sqlitePath = $dbConfig['database'] ?? ':memory:';
            $filenameOption = $this->option('filename') ?? 'database_backup.sql';
            $targetPath = str_contains($filenameOption, '/') || str_contains($filenameOption, '\\')
                ? $filenameOption
                : database_path($filenameOption);

            if ($sqlitePath !== ':memory:' && File::exists($sqlitePath)) {
                File::copy($sqlitePath, $targetPath);
                $sizeMb = round(File::size($targetPath) / 1048576, 2);
                $this->info("SQLite database backup successfully created! ({$sizeMb} MB)");
                $this->line("File location: {$targetPath}");

                return Command::SUCCESS;
            }

            // In-memory or testing sqlite
            $sqlContent = "-- SQLite Backup\n";
            File::put($targetPath, $sqlContent);
            $this->info('SQLite database backup successfully created!');
            $this->line("File location: {$targetPath}");

            return Command::SUCCESS;
        }

        if ($driver !== 'mysql') {
            $this->error("Backup command currently only supports MySQL or SQLite connections. Current driver: '{$driver}'");

            return Command::FAILURE;
        }

        $database = $dbConfig['database'] ?? 'saudia_site';
        $username = $dbConfig['username'] ?? 'root';
        $password = $dbConfig['password'] ?? '';
        $host = $dbConfig['host'] ?? '127.0.0.1';
        $port = (string) ($dbConfig['port'] ?? 3306);

        $mysqldump = $this->findMysqldumpBinary();
        if (! $mysqldump) {
            $this->error('mysqldump executable could not be found automatically. Please ensure MySQL bin directory is in your PATH.');

            return Command::FAILURE;
        }

        $backupDir = database_path();
        if (! File::isDirectory($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $filenameOption = $this->option('filename');
        if ($filenameOption) {
            $targetPath = str_ends_with($filenameOption, '.sql') ? $filenameOption : $filenameOption.'.sql';
            if (! str_contains($targetPath, '/') && ! str_contains($targetPath, '\\')) {
                $targetPath = database_path($targetPath);
            }
        } elseif ($this->option('timestamp')) {
            $targetPath = database_path("backup_{$database}_".now()->format('Y_m_d_His').'.sql');
        } else {
            $targetPath = database_path("{$database}_backup.sql");
        }

        $this->info("Creating SQL backup for database '{$database}'...");
        $this->comment("Target: {$targetPath}");

        // Clean out transient runtime tables so local sessions and cached URLs are never exported
        try {
            DB::table('cache')->truncate();
            DB::table('cache_locks')->truncate();
            DB::table('sessions')->truncate();
        } catch (\Throwable $e) {
            $this->warn('Could not truncate transient tables: '.$e->getMessage());
        }

        $command = [
            $mysqldump,
            "--host={$host}",
            "--port={$port}",
            "--user={$username}",
            '--default-character-set=utf8mb4',
            '--routines',
            '--triggers',
            '--single-transaction',
            "--result-file={$targetPath}",
        ];

        if (! empty($password)) {
            $command[] = "--password={$password}";
        }

        $command[] = $database;

        $process = new Process($command, base_path(), null, null, 300);
        $process->run();

        if (! $process->isSuccessful() || ! File::exists($targetPath) || File::size($targetPath) === 0) {
            $this->error('Database backup failed: '.$process->getErrorOutput());

            return Command::FAILURE;
        }

        // Post-dump sanitization: ensure no local dev URLs remain in exported SQL
        $content = File::get($targetPath);
        $content = str_replace(['http://127.0.0.1:8000', 'http://localhost:8000'], 'https://generatordubai.com', $content);
        File::put($targetPath, $content);

        if (! $this->option('filename') && ! $this->option('timestamp')) {
            File::copy($targetPath, base_path("{$database}_backup.sql"));
            File::copy($targetPath, base_path('database.sql'));
        }

        $sizeMb = round(File::size($targetPath) / 1048576, 2);
        $this->info("Database backup successfully created! ({$sizeMb} MB)");
        $this->line("File location: {$targetPath}");
        $this->line('Root copies: '.base_path("{$database}_backup.sql").' & '.base_path('database.sql'));

        return Command::SUCCESS;
    }

    /**
     * Locate the mysqldump binary on Windows or Unix systems.
     */
    protected function findMysqldumpBinary(): ?string
    {
        // 1. Check if mysqldump is directly in PATH
        $whichCommand = PHP_OS_FAMILY === 'Windows' ? 'where.exe mysqldump' : 'which mysqldump';
        $whichProcess = Process::fromShellCommandline($whichCommand);
        $whichProcess->run();
        if ($whichProcess->isSuccessful()) {
            $path = trim(explode("\n", trim($whichProcess->getOutput()))[0] ?? '');
            if (! empty($path) && File::exists($path)) {
                return $path;
            }
        }

        // 2. Common Windows Laragon paths
        if (PHP_OS_FAMILY === 'Windows') {
            $laragonPattern = 'C:/laragon/bin/mysql/*/bin/mysqldump.exe';
            $matches = glob($laragonPattern);
            if (! empty($matches)) {
                return end($matches);
            }

            $xamppPath = 'C:/xampp/mysql/bin/mysqldump.exe';
            if (File::exists($xamppPath)) {
                return $xamppPath;
            }
        }

        // 3. Common Unix/Linux paths
        foreach (['/usr/bin/mysqldump', '/usr/local/bin/mysqldump', '/opt/homebrew/bin/mysqldump'] as $commonPath) {
            if (File::exists($commonPath)) {
                return $commonPath;
            }
        }

        return null;
    }
}
