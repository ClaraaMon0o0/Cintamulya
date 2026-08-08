<?php
define('FCPATH', __DIR__ . '/../');
define('BASEPATH', __DIR__ . '/../');
define('DESAPATH', __DIR__ . '/../desa/');
define('ENVIRONMENT', 'development');

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$kodeDesa = identitas('kode_desa');
echo "Kode Desa: " . $kodeDesa . "\n";

$dataIdm2024 = idm($kodeDesa, '2024');
echo "=== IDM 2024 DATA ===\n";
print_r($dataIdm2024);
