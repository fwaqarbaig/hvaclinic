<?php

$strategyFile = 'C:/Users/Graphics/.gemini/antigravity/brain/aea7b2f9-d938-4f77-a6be-933d0039a0d1/UAE-GENERATOR-PORTACABIN-400-BLOG-STRATEGY.md';
if (! file_exists($strategyFile)) {
    echo "Strategy file not found at: $strategyFile\n";
    exit(1);
}

$content = file_get_contents($strategyFile);
$lines = explode("\n", $content);

$topics = [];
$currentCluster = '';

foreach ($lines as $line) {
    $line = trim($line);
    if (preg_match('/^### Cluster (\d+): (.*)/', $line, $m)) {
        $currentCluster = (int) $m[1];

        continue;
    }

    // Parse table rows: | # | Proposed Blog Title & Slug | Primary Search Keyword | Search Intent & UAE Context |
    if (preg_match('/^\|\s*(\d+)\s*\|\s*(.*?)\s*\(`(.*?)`\)\s*\|\s*(.*?)\s*\|\s*(.*?)\s*\|$/', $line, $m)) {
        $num = (int) $m[1];
        $title = trim($m[2]);
        $slug = trim($m[3]);
        $keyword = trim($m[4]);
        $intent = trim($m[5]);

        $topics[$num] = [
            'num' => $num,
            'cluster' => $currentCluster,
            'title' => $title,
            'slug' => $slug,
            'keyword' => $keyword,
            'intent' => $intent,
        ];
    }
}

echo 'Total topics parsed: '.count($topics)."\n";
echo "Clusters found:\n";
$byCluster = [];
foreach ($topics as $t) {
    $byCluster[$t['cluster']][] = $t;
}
foreach ($byCluster as $c => $arr) {
    echo "  Cluster $c: ".count($arr)." topics (First: #{$arr[0]['num']} '{$arr[0]['slug']}', Last: #{$arr[count($arr) - 1]['num']} '{$arr[count($arr) - 1]['slug']}')\n";
}
