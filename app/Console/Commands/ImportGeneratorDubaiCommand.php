<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportGeneratorDubaiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:import-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Generator Dubai pages, categories, services, fleet models, and menus from generatordubai.com data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $jsonPath = storage_path('generatordubai_full_data.json');
        if (! file_exists($jsonPath)) {
            $this->error("Data file not found at: {$jsonPath}");

            return Command::FAILURE;
        }

        $this->info("Loading data from: {$jsonPath}...");
        $data = json_decode(file_get_contents($jsonPath), true);
        if (! $data) {
            $this->error('Failed to decode JSON data.');

            return Command::FAILURE;
        }

        $homeProps = $data['home']['props'] ?? [];
        $site = $homeProps['site'] ?? [];
        $homepage = $homeProps['homepage'] ?? [];
        $adminUser = User::first() ?? User::create([
            'name' => 'Generator Dubai Admin',
            'email' => 'admin@generatordubai.com',
            'password' => bcrypt('password'),
        ]);

        $this->info('1. Cleaning old site data...');
        MenuItem::query()->delete();
        Product::query()->delete();
        Service::query()->delete();
        Category::query()->delete();
        Page::query()->delete();

        // -------------------------------------------------------------
        // 2. Import Categories
        // -------------------------------------------------------------
        $this->info('2. Importing Categories...');
        $rawCategories = $homeProps['categories'] ?? [];
        $categoryMap = [];

        foreach ($rawCategories as $cat) {
            $slug = $cat['slug'] ?? Str::slug($cat['title'] ?? '');
            $title = $cat['title'] ?? ucfirst(str_replace('-', ' ', $slug));
            $desc = $cat['description'] ?? ($cat['meta_description'] ?? '');

            $category = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $title,
                    'description' => $desc,
                ]
            );
            $categoryMap[$slug] = $category->id;
            $this->line("   - Category: {$title} ({$slug})");
        }

        // Additional Regional Categories
        $regions = [
            'dubai' => 'Dubai Generator Rental',
            'abu-dhabi' => 'Abu Dhabi & Mussafah Power Rental',
            'sharjah' => 'Sharjah & Hamriyah Depot',
            'ajman' => 'Ajman Industrial Power Support',
            'ras-al-khaimah' => 'Ras Al Khaimah Generator Rental',
            'fujairah' => 'Fujairah Port & Bunkering Power',
            'umm-al-quwain' => 'Umm Al Quwain Generator Rental',
            'oman' => 'Oman Cross-Border Power Hire',
        ];
        foreach ($regions as $rSlug => $rName) {
            if (! isset($categoryMap[$rSlug])) {
                $category = Category::updateOrCreate(
                    ['slug' => $rSlug],
                    [
                        'name' => $rName,
                        'description' => "Rapid 24/7 generator hire, heavy power deployment, and emergency maintenance across {$rName}.",
                    ]
                );
                $categoryMap[$rSlug] = $category->id;
            }
        }

        // -------------------------------------------------------------
        // 3. Import Services
        // -------------------------------------------------------------
        $this->info('3. Importing Services...');
        $servicesData = [
            [
                'title' => 'Turnkey Diesel Generator Rental',
                'slug' => 'rental-power',
                'tagline' => '50 kVA to 2500 kVA Soundproof & Heavy-Duty Power Fleet Across UAE',
                'hero_badge' => '24/7 Emergency Dispatch',
                'icon' => 'zap',
                'summary' => 'Turnkey diesel generator rental solutions from 50 kVA to 2500 kVA. Engineered for extreme UAE ambient temperatures exceeding 50°C, our sound-attenuated generators power construction sites, major infrastructure, events, and manufacturing plants with guaranteed 99.98% uptime.',
                'content' => '<p>Generator Dubai is the premier power rental provider in the United Arab Emirates, offering a comprehensive fleet of modern, low-emission, acoustically attenuated diesel generators from 50 kVA (40 kW) up to 2500 kVA (2000 kW).</p><p>Every deployment is load-bank tested and backed by certified electrical engineers, automatic transfer switches (ATS), external double-walled fuel tanks, and 24/7 on-site technical support across Dubai, Abu Dhabi, Sharjah, and Northern Emirates.</p>',
                'features' => [
                    'Tier-1 OEM engines: Cummins, Perkins, Caterpillar',
                    'Super-silent acoustic canopies under 65 dBA at 7 meters',
                    'Automatic Transfer Switches (ATS) with <10s changeover',
                    'High-ambient 55°C tropical radiators and dust filtration',
                    'Real-time electronic telemetry and remote fuel tracking',
                ],
                'benefits' => [
                    'Emergency mobilization within 60 to 120 minutes',
                    'Flexible terms: Daily, weekly, monthly, and multi-year lease',
                    'Choice between Dry Hire and full Turnkey Wet Hire with bulk diesel',
                    'Zero hidden charges with itemized engineering quotes',
                ],
                'order' => 1,
                'is_featured' => true,
                'featured_image' => '/storage/media/2026/09/1-y7ja6x.webp',
                'meta_title' => 'Turnkey Diesel Generator Rental UAE | 50-2500 kVA Power Hire',
                'meta_description' => 'Rent fuel-efficient silent diesel generators from 50 to 2500 kVA in Dubai, Abu Dhabi & Sharjah. 24/7 emergency dispatch and turnkey electrical setup.',
            ],
            [
                'title' => 'Synchronized Multi-Megawatt Power Plants',
                'slug' => 'power-plant',
                'tagline' => 'Modular Grid-Scale Power Generation up to 50 Megawatts',
                'hero_badge' => 'High-Capacity Engineering',
                'icon' => 'server',
                'summary' => 'High-capacity containerized power plants delivering continuous, transient-free electrical supply for national utility substations, refinery turnarounds, large-scale mining, and heavy industrial facilities.',
                'content' => '<p>Our Multi-Megawatt Power Plant solutions combine 20ft and 40ft ISO containerized Cummins and Caterpillar generator sets operating seamlessly in parallel via intelligent Deep Sea Electronics (DSE) load-sharing controllers.</p><p>We provide full substation integration, step-up transformers (from 400V up to 11kV/33kV), ring main units (RMU), high-voltage switchgear, and dedicated resident engineering teams managing round-the-clock power generation.</p>',
                'features' => [
                    'Intelligent automatic load-dependent start/stop synchronisation',
                    'High voltage step-up transformers (11kV / 22kV / 33kV)',
                    'Modular containerized packaging with integrated fire suppression',
                    'Bulk external fuel farms with automated transfer pumping',
                    'SCADA telemetry monitoring for harmonic distortion and load balancing',
                ],
                'benefits' => [
                    'Rapid deployment compared to permanent utility expansion',
                    'Scalable from 1 MW to 50 MW with zero operational interruption',
                    'Full compliance with DEWA, SEWA, and ADDC engineering guidelines',
                    'Complete turnkey EPC (Engineering, Procurement & Commissioning)',
                ],
                'order' => 2,
                'is_featured' => true,
                'featured_image' => '/storage/media/2026/10/5-5gbsbw.jpg',
                'meta_title' => 'Temporary Power Plants UAE | Multi-Megawatt Grid Power',
                'meta_description' => 'Modular synchronized temporary power plants up to 50MW for UAE utility substations, refineries, and mega infrastructure projects.',
            ],
            [
                'title' => 'Annual Maintenance Contracts (AMC)',
                'slug' => 'amc-generator',
                'tagline' => 'Preventative Maintenance & Guaranteed Emergency SLA for Standby Generators',
                'hero_badge' => 'Preventative Uptime',
                'icon' => 'shield-check',
                'summary' => 'Comprehensive Annual Maintenance Contracts (AMC) designed to safeguard permanent standby diesel generators in commercial towers, hospitals, data centers, and industrial facilities with guaranteed emergency response times.',
                'content' => '<p>A standby generator that fails during a municipal blackout is worse than having no generator at all. Generator Dubai provides comprehensive preventative maintenance agreements tailored to commercial facilities across the UAE.</p><p>Our AMC agreements include quarterly mechanical inspections, semi-annual lubricant and coolant fluid analysis, battery conductance testing, automatic transfer switch servicing, and annual resistive load-bank certification.</p>',
                'features' => [
                    'Guaranteed 1-hour emergency callout SLA for contract holders',
                    'Periodic 52-point mechanical and electrical diagnostic audit',
                    'Comprehensive oil, fuel, and coolant laboratory spectrometry',
                    'Controlled resistive load-bank testing up to 2000 kW',
                    'Direct supply of genuine OEM filters, belts, sensors, and fluids',
                ],
                'benefits' => [
                    'Eliminate catastrophic power failure during grid outages',
                    'Extend diesel engine operational lifespan by up to 40%',
                    'Comply with UAE Civil Defense safety and emergency power audits',
                    'Predictable annual maintenance budgeting with zero surprise costs',
                ],
                'order' => 3,
                'is_featured' => true,
                'featured_image' => '/storage/media/2026/10/02-xbimnj.jpg',
                'meta_title' => 'Generator AMC Contracts Dubai & UAE | Annual Maintenance Services',
                'meta_description' => 'Comprehensive Annual Maintenance Contracts (AMC) for commercial diesel generators across Dubai, Abu Dhabi and Sharjah. 24/7 SLA and load testing.',
            ],
            [
                'title' => '24/7 Generator Maintenance & Emergency Repair',
                'slug' => 'maintenance',
                'tagline' => 'Fast-Response On-Site Troubleshooting, Overhaul & Spare Parts',
                'hero_badge' => 'Rapid Mobile Service',
                'icon' => 'wrench',
                'summary' => 'Round-the-clock emergency generator repair and field maintenance for all major brands including Cummins, Perkins, Caterpillar, Kohler, Baudouin, and Volvo Penta.',
                'content' => '<p>When a generator breaks down, every minute of lost electrical power translates into financial and operational damage. Our mobile field-service workshops are equipped with advanced diagnostic scanning tools and emergency replacement components.</p><p>From AVR governor calibration, fuel injector rebuilds, and radiator recoring to full top-end engine overhauls, our certified diesel engineers restore your equipment to factory specifications rapidly.</p>',
                'features' => [
                    'Mobile service units carrying OEM diagnostic tools and genuine spares',
                    'Electronic controller programming (DSE, ComAp, Woodward)',
                    'Injection pump calibration and turbocharger overhaul',
                    'Alternator rewinding and automatic voltage regulator (AVR) replacement',
                    'Immediate emergency backup generator mobilization if required',
                ],
                'benefits' => [
                    'Available 24 hours a day, 365 days a year across all 7 Emirates',
                    'Certified diesel mechanics with over a decade of UAE experience',
                    'Transparent diagnostic reports and upfront pricing',
                    'Warranty on all replaced components and workmanship',
                ],
                'order' => 4,
                'is_featured' => true,
                'featured_image' => '/storage/media/2026/10/01-lptck9.jpg',
                'meta_title' => 'Generator Repair & Maintenance Dubai | 24/7 On-Site Mechanics',
                'meta_description' => 'Expert 24/7 on-site diesel generator repair and maintenance in Dubai and UAE. OEM parts, fuel system repair, and complete overhauls.',
            ],
            [
                'title' => 'Portacabin & Site Offices',
                'slug' => 'portacabin',
                'tagline' => 'Modular Insulated Site Cabins, Guard Houses & Ablution Units',
                'hero_badge' => 'Modular Infrastructure',
                'icon' => 'building',
                'summary' => 'High-specification insulated portable cabins, executive site offices, conference rooms, security guardhouses, and hygienic sanitary ablution blocks pre-wired for seamless generator hookup.',
                'content' => '<p>Generator Dubai supplies turn-key modular site infrastructure engineered to withstand harsh desert conditions. Our heavy-duty steel cabins feature polyurethane foam insulation, double-glazed windows, split air conditioning, and integrated electrical distribution panels.</p><p>Available for fast delivery and crane positioning on construction sites, security checkpoints, remote desert camps, and temporary industrial projects.</p>',
                'features' => [
                    'Sizes available: 10ft, 20ft, and 40ft modular configurations',
                    'High-density PU insulation with thermal acoustic dampening',
                    'Pre-wired with copper armored cabling, circuit breakers, and LED lighting',
                    'Split AC units, executive desks, and conference layouts available',
                    'Turnkey sanitary plumbing with waste storage tanks',
                ],
                'benefits' => [
                    'Instant plug-and-play connection to our rental generator fleet',
                    'Fast on-site delivery with flatbed boom cranes',
                    'Flexible monthly and project-duration lease terms',
                    'Cash buy-back and relocation services available upon project completion',
                ],
                'order' => 5,
                'is_featured' => true,
                'featured_image' => '/storage/media/2026/10/06-wx9o27.jpg',
                'meta_title' => 'Portacabin Rental Dubai & UAE | Modular Site Offices & Ablutions',
                'meta_description' => 'Rent and buy insulated portacabins, site offices, and ablution cabins across Dubai, Sharjah and UAE with instant generator power hookup.',
            ],
            [
                'title' => 'Turnkey Site Electrical & Distribution Packages',
                'slug' => 'we-offer',
                'tagline' => 'Complete Power Ecosystem: ATS, Bunded Tanks, Armored Cables & Distribution',
                'hero_badge' => 'Complete Ecosystem',
                'icon' => 'layers',
                'summary' => 'A generator is only as reliable as its electrical distribution network. We provide complete turnkey balance-of-plant accessories including ATS panels, synchronizing switchboards, bunded fuel farms, and rubberized IP66 distribution boards.',
                'content' => '<p>Eliminate project coordination headaches with our single-source turnkey electrical packages. We engineer, deliver, and commission the entire temporary electrical grid for your project site.</p><p>From high-amperage armored copper cables and automatic transfer switches to double-walled fuel storage tanks with scheduled ADNOC/ENOC bulk refueling, we take total ownership of your site power continuity.</p>',
                'features' => [
                    '4-Pole Automatic Transfer Switch (ATS) panels up to 3200A',
                    'Double-walled bunded fuel tanks from 1,000L to 20,000L capacity',
                    'Heavy-duty flexible HO7RN-F rubber copper cables with Cam-Lock connectors',
                    'Weatherproof IP66 site power distribution boxes with earth leakage breakers',
                    'Dedicated mobile diesel fuel delivery tankers on scheduled cycles',
                ],
                'benefits' => [
                    'Single accountable contractor for power generation and distribution',
                    'Fully compliant with municipal safety codes and civil defense regulations',
                    'Zero site downtime due to electrical overload or cable faults',
                    'Free electrical load profiling and on-site distribution diagram design',
                ],
                'order' => 6,
                'is_featured' => true,
                'featured_image' => '/storage/media/2026/10/04-be9wys.jpg',
                'meta_title' => 'Temporary Power Distribution UAE | Cables, ATS & Fuel Tanks',
                'meta_description' => 'Complete site power accessories: ATS panels, synchronising switchgear, armored cables, and external fuel storage across Dubai & UAE.',
            ],
            [
                'title' => 'New Diesel Generator Sales',
                'slug' => 'new-generators',
                'tagline' => 'Factory-New Generators from World-Class Engine Manufacturers',
                'hero_badge' => 'Tier-1 Manufacturers',
                'icon' => 'box',
                'summary' => 'Authorised sales of factory-new diesel generators from 20 kVA to 3000 kVA powered by genuine Cummins, Perkins, Caterpillar, Baudouin, and Volvo engines with full manufacturer warranty.',
                'content' => '<p>Looking to invest in permanent or prime power infrastructure? Generator Dubai provides genuine factory-new generators engineered with high-ambient tropical radiators and heavy-duty Stamford or Leroy-Somer alternators.</p><p>We provide complete pre-delivery load-bank certification, site delivery, acoustic canopy installation, exhaust ducting, and civil defense compliance documentation.</p>',
                'features' => [
                    'Direct factory partnerships with world-renowned engine builders',
                    'Certified Stamford, Leroy-Somer, and Mecc Alte alternators',
                    'Sound-attenuated weatherproof enclosures and open skid sets',
                    'Comprehensive 1-year or 2000-hour international manufacturer warranty',
                    'Full installation, testing, and commissioning by certified engineers',
                ],
                'benefits' => [
                    'Competitive pricing with direct factory import advantages',
                    'Custom fuel tank capacities and exhaust muffler configurations',
                    'Complimentary first scheduled service and technician handover training',
                    'Seamless transition into our post-warranty AMC maintenance program',
                ],
                'order' => 7,
                'is_featured' => false,
                'featured_image' => '/storage/media/2026/10/2-im4l8z.jpg',
                'meta_title' => 'New Diesel Generators for Sale Dubai | Cummins, Perkins & CAT',
                'meta_description' => 'Buy brand new diesel generators from 20 to 3000 kVA in Dubai & UAE. Certified engines, Stamford alternators, full warranty and commissioning.',
            ],
            [
                'title' => 'Used & Refurbished Generator Buy & Sell',
                'slug' => 'used-refurbished-generators',
                'tagline' => 'Certified Load-Bank Tested Pre-Owned Gensets with Warranty & Instant Buy-Back',
                'hero_badge' => 'Certified Pre-Owned',
                'icon' => 'refresh-cw',
                'summary' => 'High-quality refurbished diesel generators and used portacabins. Fully overhauled, load-tested under 100% capacity, and sold with operating warranty. We also offer instant cash buy-back for surplus generators and portacabins across the UAE.',
                'content' => '<p>Save up to 50% on capital expenditure without sacrificing electrical reliability. Our pre-owned generator sets undergo rigorous 60-point mechanical overhauls, new filters, fresh fluids, recalibrated injectors, and full load-bank certification.</p><p>Have surplus generators or portacabins on your jobsite? We provide instant cash offers, free crane dismantling, and prompt site clearance anywhere in Dubai, Abu Dhabi, Sharjah, and Northern Emirates.</p>',
                'features' => [
                    'Complete 100% load-bank testing verification report with every unit',
                    'Full fluid changes, genuine OEM filtration, and battery replacement',
                    'Operational warranty coverage up to 6 months on major components',
                    'Instant cash valuation and purchase for surplus equipment across the UAE',
                    'Free crane rigging, heavy transport removal, and site clearance',
                ],
                'benefits' => [
                    'Immediate delivery from stock with zero factory lead times',
                    'Substantial CAPEX savings for growing contractors and industrial plants',
                    'Eliminate dead capital by monetizing idle machinery quickly',
                    'Trade-in options available to upgrade to larger capacity sets',
                ],
                'order' => 8,
                'is_featured' => true,
                'featured_image' => '/storage/media/2026/10/03-8ab0vq.jpg',
                'meta_title' => 'Used Generators for Sale & Buyback UAE | Refurbished Power Sets',
                'meta_description' => 'Buy load-tested refurbished diesel generators with warranty in Dubai. Instant cash buy-back for used generators and portacabins across UAE.',
            ],
        ];

        foreach ($servicesData as $s) {
            $service = Service::updateOrCreate(
                ['slug' => $s['slug']],
                array_merge($s, [
                    'status' => 'published',
                    'is_indexable' => true,
                    'seo_score' => 95,
                    'readability_score' => 90,
                ])
            );
            $this->line("   - Service: {$service->title} ({$service->slug})");
        }

        // -------------------------------------------------------------
        // 4. Import Products (Generator Fleet KVA Models)
        // -------------------------------------------------------------
        $this->info('4. Importing Generator Fleet KVA Models into Products table...');
        $fleetKvaData = [
            '50-kva' => ['kva' => 50, 'kw' => 40, 'primeKw' => 40, 'standbyKva' => 55, 'standbyKw' => 44, 'model' => 'Cummins C55 D5 / Perkins 1103A-33TG1', 'fuelTank' => '180 Liters (~16 hrs continuous)', 'consumption' => '9.1 L/hr @ 75% Load', 'soundLevel' => '66 dBA @ 7m', 'dimensions' => '2200 x 980 x 1450 mm', 'weight' => '1,120 kg', 'circuitBreaker' => '80A 4-Pole MCCB'],
            '100-kva' => ['kva' => 100, 'kw' => 80, 'primeKw' => 80, 'standbyKva' => 110, 'standbyKw' => 88, 'model' => 'Cummins C110 D5 / Perkins 1104A-44TAG2', 'fuelTank' => '340 Liters (~17 hrs continuous)', 'consumption' => '16.5 L/hr @ 75% Load', 'soundLevel' => '68 dBA @ 7m', 'dimensions' => '2750 x 1100 x 1750 mm', 'weight' => '1,820 kg', 'circuitBreaker' => '160A 4-Pole MCCB'],
            '150-kva' => ['kva' => 150, 'kw' => 120, 'primeKw' => 120, 'standbyKva' => 165, 'standbyKw' => 132, 'model' => 'Perkins 1106A-70TG1 / Cummins 6BTA5.9-G2', 'fuelTank' => '450 Liters (~15 hrs continuous)', 'consumption' => '24.5 L/hr @ 75% Load', 'soundLevel' => '69 dBA @ 7m', 'dimensions' => '3300 x 1150 x 1850 mm', 'weight' => '2,250 kg', 'circuitBreaker' => '250A 4-Pole MCCB'],
            '200-kva' => ['kva' => 200, 'kw' => 160, 'primeKw' => 160, 'standbyKva' => 220, 'standbyKw' => 176, 'model' => 'Cummins 6CTA8.3-G2 / Perkins 1106A-70TAG3', 'fuelTank' => '520 Liters (~14 hrs continuous)', 'consumption' => '31.0 L/hr @ 75% Load', 'soundLevel' => '70 dBA @ 7m', 'dimensions' => '3600 x 1300 x 1950 mm', 'weight' => '2,750 kg', 'circuitBreaker' => '315A 4-Pole MCCB'],
            '250-kva' => ['kva' => 250, 'kw' => 200, 'primeKw' => 200, 'standbyKva' => 275, 'standbyKw' => 220, 'model' => 'Caterpillar CAT DE250 GC / Cummins QSL9-G3', 'fuelTank' => '600 Liters (~14 hrs continuous)', 'consumption' => '38.2 L/hr @ 75% Load', 'soundLevel' => '70 dBA @ 7m', 'dimensions' => '3900 x 1400 x 2050 mm', 'weight' => '3,100 kg', 'circuitBreaker' => '400A 4-Pole MCCB'],
            '300-kva' => ['kva' => 300, 'kw' => 240, 'primeKw' => 240, 'standbyKva' => 330, 'standbyKw' => 264, 'model' => 'Perkins 1506A-E88TAG5 / Cummins QSL9-G5', 'fuelTank' => '750 Liters (~14 hrs continuous)', 'consumption' => '45.5 L/hr @ 75% Load', 'soundLevel' => '71 dBA @ 7m', 'dimensions' => '4150 x 1500 x 2100 mm', 'weight' => '3,650 kg', 'circuitBreaker' => '500A 4-Pole MCCB'],
            '350-kva' => ['kva' => 350, 'kw' => 280, 'primeKw' => 280, 'standbyKva' => 385, 'standbyKw' => 308, 'model' => 'Cummins QSL9-G5 / Perkins 2206C-E13TAG2', 'fuelTank' => '850 Liters (~14 hrs continuous)', 'consumption' => '52.8 L/hr @ 75% Load', 'soundLevel' => '71 dBA @ 7m', 'dimensions' => '4400 x 1600 x 2200 mm', 'weight' => '4,300 kg', 'circuitBreaker' => '630A 4-Pole MCCB'],
            '500-kva' => ['kva' => 500, 'kw' => 400, 'primeKw' => 400, 'standbyKva' => 550, 'standbyKw' => 440, 'model' => 'Cummins QSX15-G8 / Perkins 2506A-E15TAG1', 'fuelTank' => '1,000 Liters (~12 hrs continuous)', 'consumption' => '74.0 L/hr @ 75% Load', 'soundLevel' => '72 dBA @ 7m', 'dimensions' => '4800 x 1800 x 2400 mm', 'weight' => '5,400 kg', 'circuitBreaker' => '800A 4-Pole MCCB'],
            '600-kva' => ['kva' => 600, 'kw' => 480, 'primeKw' => 480, 'standbyKva' => 660, 'standbyKw' => 528, 'model' => 'Perkins 2806A-E18TAG1A / Caterpillar C18', 'fuelTank' => '1,200 Liters (~12 hrs continuous)', 'consumption' => '89.0 L/hr @ 75% Load', 'soundLevel' => '73 dBA @ 7m', 'dimensions' => '5200 x 1950 x 2550 mm', 'weight' => '6,800 kg', 'circuitBreaker' => '1000A 4-Pole MCCB'],
            '800-kva' => ['kva' => 800, 'kw' => 640, 'primeKw' => 640, 'standbyKva' => 900, 'standbyKw' => 720, 'model' => 'Caterpillar CAT C27 / Cummins QSK23-G3', 'fuelTank' => '1,500 Liters (~11 hrs continuous)', 'consumption' => '118.0 L/hr @ 75% Load', 'soundLevel' => '75 dBA @ 7m', 'dimensions' => '5800 x 2100 x 2700 mm', 'weight' => '8,200 kg', 'circuitBreaker' => '1250A 4-Pole MCCB'],
            '1000-kva' => ['kva' => 1000, 'kw' => 800, 'primeKw' => 800, 'standbyKva' => 1100, 'standbyKw' => 880, 'model' => 'Cummins QST30-G4 / Caterpillar 3508B (20ft ISO Container)', 'fuelTank' => '2,000 Liters (~12 hrs continuous)', 'consumption' => '145.0 L/hr @ 75% Load', 'soundLevel' => '75 dBA @ 7m', 'dimensions' => '6058 x 2438 x 2591 mm (20ft ISO Container)', 'weight' => '12,500 kg', 'circuitBreaker' => '1600A 4-Pole ACB'],
            '1250-kva' => ['kva' => 1250, 'kw' => 1000, 'primeKw' => 1000, 'standbyKva' => 1375, 'standbyKw' => 1100, 'model' => 'Caterpillar CAT 3512B / Cummins KTA50-G3 (20ft ISO Container)', 'fuelTank' => '2,500 Liters (~12 hrs continuous)', 'consumption' => '185.0 L/hr @ 75% Load', 'soundLevel' => '76 dBA @ 7m', 'dimensions' => '6058 x 2438 x 2591 mm (20ft ISO Container)', 'weight' => '14,800 kg', 'circuitBreaker' => '2000A 4-Pole ACB'],
        ];

        $order = 1;
        foreach ($fleetKvaData as $slug => $item) {
            $kva = $item['kva'];
            $kw = $item['kw'];
            $title = "{$kva} kVA ({$kw} kW) Silent Diesel Generator";

            // Grab scraped spec if available
            $scrapedSpec = $data["fleet/{$slug}"]['props']['spec'] ?? [];
            $summary = $scrapedSpec['summary'] ?? "Our {$kva} kVA silent diesel generator rental delivers reliable {$kw} kW prime power for UAE construction sites, civil projects, events, and emergency standby.";
            $applications = $scrapedSpec['applications'] ?? [
                'Commercial site offices, tower cranes, and contractor facilities',
                'Industrial manufacturing, concrete plants, and dewatering pumps',
                'Events, concerts, outdoor hospitality, and VIP cooling',
                '24/7 emergency standby power for utility and transformer outages',
            ];

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'tagline' => "{$kva} kVA Prime / {$item['standbyKva']} kVA Standby Soundproof Power",
                    'badge' => "{$kva} kVA Fleet",
                    'category' => 'Diesel Generators',
                    'icon' => 'zap',
                    'summary' => $summary,
                    'content' => "<p>{$summary}</p><p>Featuring genuine {$item['model']} engine technology, this {$kva} kVA set delivers high fuel efficiency, ultra-low acoustic sound levels ({$item['soundLevel']}), and continuous 3-phase 400V/230V 50Hz electrical supply even under high ambient summer temperatures of 50°C+.</p>",
                    'modules' => [
                        'engine_model' => $item['model'],
                        'prime_power' => "{$kva} kVA / {$kw} kW",
                        'standby_power' => "{$item['standbyKva']} kVA / {$item['standbyKw']} kW",
                        'fuel_tank' => $item['fuelTank'],
                        'fuel_consumption' => $item['consumption'],
                        'sound_attenuation' => $item['soundLevel'],
                        'dimensions' => $item['dimensions'],
                        'dry_weight' => $item['weight'],
                        'circuit_breaker' => $item['circuitBreaker'],
                    ],
                    'highlights' => $applications,
                    'featured_image' => ($kva >= 1000) ? '/storage/media/2026/10/5-5gbsbw.jpg' : '/storage/media/2026/10/2-im4l8z.jpg',
                    'status' => 'published',
                    'order' => $order++,
                    'is_featured' => in_array($kva, [50, 100, 250, 500, 1000]),
                    'focus_keyword' => "{$kva} kva generator rental dubai",
                    'meta_title' => "{$kva} kVA Diesel Generator Rental Dubai & UAE | Silent Canopy",
                    'meta_description' => "Hire {$kva} kVA ({$kw} kW) soundproof diesel generator in Dubai & UAE. {$item['model']}, {$item['consumption']}, 24/7 delivery and turnkey setup.",
                    'is_indexable' => true,
                    'seo_score' => 95,
                    'readability_score' => 90,
                ]
            );
            $this->line("   - Fleet Product: {$product->title} ({$product->slug})");
        }

        // -------------------------------------------------------------
        // 5. Import Pages
        // -------------------------------------------------------------
        $this->info('5. Importing Pages...');
        $pagesData = [
            [
                'title' => 'Generator Rental in Dubai & UAE',
                'slug' => 'home',
                'template' => 'home',
                'meta_title' => 'Generator Rental in UAE | Diesel Generator Hire Dubai',
                'meta_description' => 'Generator rental in UAE from 50 to 2500 kVA. Rent silent diesel generators across Dubai, Abu Dhabi and Sharjah with 24/7 technical support.',
                'content' => $homepage['hero']['paragraph_1'] ?? 'Premier provider of heavy-duty temporary power solutions in Dubai.',
            ],
            [
                'title' => 'About Generator Dubai',
                'slug' => 'about-us',
                'template' => 'about',
                'meta_title' => 'About Generator Dubai | UAE Power Generation & Fleet History',
                'meta_description' => 'Learn about Generator Dubai, the UAE leader in turnkey temporary power generation, heavy diesel fleet operations, and certified electrical engineering.',
                'content' => '<h2>Over a Decade of Temporary Power Engineering Across the UAE</h2><p>Generator Dubai was founded with a single mission: to deliver uncompromising electrical power continuity to the fastest-growing infrastructure and industrial developments in the Middle East.</p><p>With dedicated logistics yards in Dubai, Abu Dhabi, and Sharjah, our fleet of Tier-1 Cummins, Perkins, and Caterpillar generators guarantees dependable power for mega-events, civil construction, remote desert explorations, and emergency utility outages.</p>',
            ],
            [
                'title' => 'Diesel Generator Fleet',
                'slug' => 'fleet',
                'template' => 'fleet',
                'meta_title' => 'Diesel Generator Fleet Rental UAE | 50 kVA to 2500 kVA Capacities',
                'meta_description' => 'Explore our complete rental fleet of soundproof diesel generators from 50 to 2500 kVA. Built for high ambient desert conditions with 24/7 dispatch across UAE.',
                'content' => '<h2>Comprehensive Generator Fleet from 50 kVA to 2500 kVA</h2><p>Our fleet comprises sound-attenuated acoustic canopy sets and ISO containerized power plants engineered for continuous prime operation in extreme Middle Eastern weather conditions.</p>',
            ],
            [
                'title' => 'Turnkey Power & Site Services',
                'slug' => 'services',
                'template' => 'services',
                'meta_title' => 'Generator Rental & Site Power Services UAE | Generator Dubai',
                'meta_description' => 'Complete generator hire, preventative AMC maintenance, multi-megawatt temporary power plants, portacabins, and electrical site distribution in UAE.',
                'content' => '<h2>Full-Lifecycle Power Engineering Services</h2><p>Beyond generator hire, Generator Dubai provides end-to-end electrical distribution, automatic transfer switch installation, scheduled maintenance, and bulk fuel delivery.</p>',
            ],
            [
                'title' => 'Industries We Power',
                'slug' => 'industries',
                'template' => 'industries',
                'meta_title' => 'Industries We Serve | Construction, Oil & Gas, Events & Data Centers',
                'meta_description' => 'Delivering engineered power continuity to UAE civil construction, oil & gas, hospitality, healthcare, utility substations, and critical data centers.',
                'content' => '<h2>Powering the UAE\'s Critical Commercial & Industrial Sectors</h2><p>From towering skyscrapers in Downtown Dubai to remote desert exploration camps in Abu Dhabi\'s Al Dhafra region, our generator fleet powers the nation\'s most critical infrastructure projects.</p>',
            ],
            [
                'title' => 'Used & Refurbished Generators & Portacabins',
                'slug' => 'used-refurbished-generators',
                'template' => 'used-generators',
                'meta_title' => 'Used & Refurbished Generators UAE | Certified Pre-Owned Power Sets',
                'meta_description' => 'Certified load-tested used and refurbished diesel generators and portacabins for sale and immediate cash buyback across Dubai & UAE.',
                'content' => '<h2>Certified Pre-Owned Generators & Portacabins</h2><p>Buy load-tested refurbished generators with warranty or sell surplus site equipment for instant cash payment with complimentary crane dismantling and transport removal.</p>',
            ],
            [
                'title' => 'Service Locations Across UAE',
                'slug' => 'locations',
                'template' => 'locations',
                'meta_title' => 'Generator Rental Network UAE | Dubai, Abu Dhabi, Sharjah & Northern Emirates',
                'meta_description' => 'Strategic regional depots delivering rapid 24/7 generator delivery across all 7 Emirates within 60 to 120 minutes of confirmation.',
                'content' => '<h2>24/7 Rapid Deployment Across All 7 Emirates</h2><p>With fully equipped logistics yards in Dubai, Abu Dhabi, Sharjah, and Northern Emirates, we ensure rapid emergency response and guaranteed power uptime nationwide.</p>',
            ],
            [
                'title' => 'Contact Generator Dubai',
                'slug' => 'contact-us',
                'template' => 'contact',
                'meta_title' => 'Contact Generator Dubai | 24/7 Hotline & Technical Inquiries',
                'meta_description' => 'Get in touch with Generator Dubai for immediate quotes, site audits, and 24/7 emergency generator dispatch. Hotline: +971 56 921 3754.',
                'content' => '<h2>24/7 Emergency Dispatch & Technical Consultations</h2><p>Speak directly with our power engineering team for instant quotes, complimentary electrical load sizing, or emergency blackout restoration.</p>',
            ],
            // 8 Locations
            [
                'title' => 'Generator Rental in Dubai',
                'slug' => 'locations/dubai',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Dubai | 24/7 Silent Diesel Power Hire',
                'meta_description' => 'Rapid generator rental in Dubai: Al Quoz, JAFZA, Dubai South, Downtown & Business Bay. Soundproof 50-2500 kVA generators delivered in under 60 minutes.',
                'content' => '<h2>Premier Generator Rental Hub in Dubai</h2><p>Serving Al Quoz, Jebel Ali Free Zone (JAFZA), Dubai Industrial City (DIC), Dubai South, Business Bay, and Dubai Investments Park with rapid emergency response.</p>',
            ],
            [
                'title' => 'Generator Rental in Abu Dhabi',
                'slug' => 'locations/abu-dhabi',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Abu Dhabi & Mussafah | Industrial Power Hire',
                'meta_description' => 'Heavy-duty industrial generator rental in Abu Dhabi: Mussafah, ICAD, KIZAD, Khalifa Port, and Al Dhafra. 50-2500 kVA generators ready for immediate deployment.',
                'content' => '<h2>Industrial Power Solutions in Abu Dhabi & Mussafah</h2><p>Specialized heavy power equipment serving Mussafah, ICAD, KIZAD, Al Dhafra, and regional oil and gas installations.</p>',
            ],
            [
                'title' => 'Generator Rental in Sharjah',
                'slug' => 'locations/sharjah',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Sharjah | Industrial Area & Hamriyah Free Zone',
                'meta_description' => 'Fast generator rental across Sharjah: Industrial Areas 1 to 18, SAIF Zone, and Hamriyah Free Zone with 24/7 mobile technicians and bulk fuel.',
                'content' => '<h2>Central Logistics Depot in Sharjah</h2><p>Direct fleet access to Industrial Areas 1 to 18, Sharjah Airport Free Zone (SAIF Zone), and Hamriyah Port within 45 minutes.</p>',
            ],
            [
                'title' => 'Generator Rental in Ajman',
                'slug' => 'locations/ajman',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Ajman | Industrial Zone & Coastal Sites',
                'meta_description' => 'Reliable generator rental in Ajman Industrial Areas, Al Jurf, and port zones with soundproof canopies and 24/7 support.',
                'content' => '<h2>Ajman Industrial Power Support</h2><p>Supporting manufacturing plants, civil construction, and port facilities across Ajman with guaranteed continuous power supply.</p>',
            ],
            [
                'title' => 'Generator Rental in Ras Al Khaimah',
                'slug' => 'locations/ras-al-khaimah',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Ras Al Khaimah | Quarry, Port & Industrial Power',
                'meta_description' => 'Heavy-duty generators for RAK quarry crushers, Saqr Port, Al Hamra, and manufacturing plants. High-ambient diesel power sets.',
                'content' => '<h2>Heavy-Duty Generation in Ras Al Khaimah</h2><p>High-capacity power systems engineered to handle heavy inductive motor starting for quarries, crushing plants, and port logistics in RAK.</p>',
            ],
            [
                'title' => 'Generator Rental in Fujairah',
                'slug' => 'locations/fujairah',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Fujairah | Marine Port & Bunkering Power',
                'meta_description' => 'Marine-grade temporary power and generator hire in Fujairah Port, oil bunkering terminals, and offshore support facilities.',
                'content' => '<h2>Fujairah Marine & Port Power</h2><p>Specialized shore-to-ship marine power conversion, tank terminal construction power, and offshore bunkering support.</p>',
            ],
            [
                'title' => 'Generator Rental in Umm Al Quwain',
                'slug' => 'locations/umm-al-quwain',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Umm Al Quwain | Coastal & Industrial Power',
                'meta_description' => 'Quiet, fuel-efficient generator rental in Umm Al Quwain for civil infrastructure, farm compounds, and industrial workshops.',
                'content' => '<h2>Umm Al Quwain Regional Service</h2><p>Dependable silent power generation for construction compounds, coastal resorts, and utility outages across UAQ.</p>',
            ],
            [
                'title' => 'Cross-Border Generator Rental in Oman',
                'slug' => 'locations/oman',
                'template' => 'location-detail',
                'meta_title' => 'Generator Rental in Oman | Cross-Border Industrial Power Packages',
                'meta_description' => 'Cross-border generator rental and temporary power plants for Sohar Port, Muscat, and regional oilfield operations in Oman.',
                'content' => '<h2>Cross-Border Power Supply into Oman</h2><p>Turnkey power logistics and high-capacity synchronized containerized generators delivered to Sohar, Muscat, and regional exploration sites.</p>',
            ],
        ];

        foreach ($pagesData as $p) {
            $page = Page::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'user_id' => $adminUser->id,
                    'title' => $p['title'],
                    'content' => $p['content'],
                    'template' => $p['template'],
                    'status' => 'published',
                    'meta_title' => $p['meta_title'],
                    'meta_description' => $p['meta_description'],
                    'is_indexable' => true,
                    'seo_score' => 95,
                    'readability_score' => 90,
                ]
            );
            $this->line("   - Page: {$page->title} ({$page->slug})");
        }

        // -------------------------------------------------------------
        // 6. Import Navigation Menus
        // -------------------------------------------------------------
        $this->info('6. Importing Primary Navigation Menu...');
        $primaryMenu = [
            ['title' => 'Home', 'url' => '/', 'order' => 1, 'location' => 'header'],
            ['title' => 'About Us', 'url' => '/about-us', 'order' => 2, 'location' => 'header'],
            ['title' => 'Fleet', 'url' => '/fleet', 'order' => 3, 'location' => 'header'],
            [
                'title' => 'Services',
                'url' => '/services',
                'order' => 4,
                'location' => 'header',
                'children' => [
                    ['title' => 'Rental Power', 'url' => '/category/rental-power', 'order' => 1],
                    ['title' => 'Power Plant', 'url' => '/services/power-plant', 'order' => 2],
                    ['title' => 'AMC Generator', 'url' => '/services/amc-generator', 'order' => 3],
                    ['title' => 'Generator Maintenance', 'url' => '/category/maintenance', 'order' => 4],
                    ['title' => 'Portacabin & Site Offices', 'url' => '/services/portacabin', 'order' => 5],
                    ['title' => 'Turnkey Power Packages', 'url' => '/services/we-offer', 'order' => 6],
                    ['title' => 'New Generators', 'url' => '/category/new-generators', 'order' => 7],
                ],
            ],
            ['title' => 'Industries', 'url' => '/industries', 'order' => 5, 'location' => 'header'],
            ['title' => 'Used & Refurbished', 'url' => '/used-refurbished-generators', 'order' => 6, 'location' => 'header'],
            [
                'title' => 'Locations',
                'url' => '/locations',
                'order' => 7,
                'location' => 'header',
                'children' => [
                    ['title' => 'Dubai', 'url' => '/locations/dubai', 'order' => 1],
                    ['title' => 'Abu Dhabi', 'url' => '/locations/abu-dhabi', 'order' => 2],
                    ['title' => 'Sharjah', 'url' => '/locations/sharjah', 'order' => 3],
                    ['title' => 'Ajman', 'url' => '/locations/ajman', 'order' => 4],
                    ['title' => 'Ras Al Khaimah', 'url' => '/locations/ras-al-khaimah', 'order' => 5],
                    ['title' => 'Fujairah', 'url' => '/locations/fujairah', 'order' => 6],
                    ['title' => 'Umm Al Quwain', 'url' => '/locations/umm-al-quwain', 'order' => 7],
                    ['title' => 'Oman', 'url' => '/locations/oman', 'order' => 8],
                ],
            ],
            ['title' => 'Blogs', 'url' => '/blog', 'order' => 8, 'location' => 'header'],
            ['title' => 'Contact Us', 'url' => '/contact-us', 'order' => 9, 'location' => 'header'],
        ];

        foreach ($primaryMenu as $m) {
            $children = $m['children'] ?? [];
            unset($m['children']);
            $parent = MenuItem::create(array_merge($m, ['is_active' => true]));

            foreach ($children as $c) {
                MenuItem::create(array_merge($c, [
                    'parent_id' => $parent->id,
                    'location' => 'header',
                    'is_active' => true,
                ]));
            }
        }

        $this->info("\n=================================================");
        $this->info('  Generator Dubai Site Import Finished!          ');
        $this->info('=================================================');
        $this->table(
            ['Entity', 'Count in Laravel'],
            [
                ['Categories', Category::count()],
                ['Services', Service::count()],
                ['Fleet Products', Product::count()],
                ['Pages', Page::count()],
                ['Menu Items', MenuItem::count()],
                ['Users', User::count()],
            ]
        );

        return Command::SUCCESS;
    }
}
