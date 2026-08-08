<?php
function hash_pin($pin = 0): string
{
    $pin = (int) strrev($pin);
    $pin *= 77;
    $pin .= '!#@$#%';

    return md5($pin);
}

$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

$stmt = $pdo->query("SELECT m.*, p.nik, p.nama FROM tweb_penduduk_mandiri m JOIN tweb_penduduk p ON m.id_pend = p.id WHERE m.aktif = 1");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total Layanan Mandiri Users: " . count($rows) . "\n\n";

$common_pins = ['123456', '111111', '12345', '654321', '000000', '123123', '1234', '112233', '888888', '777777', '999999'];

foreach ($rows as $user) {
    echo "Nama: {$user['nama']}\n";
    echo "NIK : {$user['nik']}\n";
    echo "Hash: {$user['pin']}\n";
    
    $found_pin = null;
    foreach ($common_pins as $p) {
        if (hash_pin($p) === $user['pin']) {
            $found_pin = $p;
            break;
        }
    }
    
    // Also check if PIN could be last 6 digits of NIK, or birth date, or reverse NIK
    if (!$found_pin) {
        $last6 = substr($user['nik'], -6);
        if (hash_pin($last6) === $user['pin']) $found_pin = "Last 6 NIK ($last6)";
    }
    
    if ($found_pin) {
        echo "PIN Found: $found_pin\n";
    } else {
        echo "PIN: Hashed (Custom)\n";
    }
    echo "----------------------------------------\n";
}
