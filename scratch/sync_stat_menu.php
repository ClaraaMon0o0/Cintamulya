<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

// 1. Enable all existing statistik and bantuan menu rows in menu table
$stmt = $pdo->prepare("UPDATE menu SET enabled = 1 WHERE link LIKE '%statistik%' OR link LIKE '%bantuan%' OR link LIKE '%keluarga%' OR link IN ('dpt', 'data-wilayah')");
$stmt->execute();
echo "Updated " . $stmt->rowCount() . " menu rows to enabled = 1.\n";

// 2. Insert missing standard statistik & bantuan menu items if not present
$itemsToEnsure = [
    // Statistik Keluarga
    ['nama' => 'Data Kelas Sosial', 'link' => 'statistik/kelas-sosial'],
    ['nama' => 'Penerima Raskin', 'link' => 'statistik/bantuan_raskin'],
    ['nama' => 'Penerima Jamkesmas', 'link' => 'statistik/bantuan_jamkesmas'],
    ['nama' => 'Penerima PKH', 'link' => 'statistik/bantuan_pkh'],
    
    // Statistik Bantuan
    ['nama' => 'Penerima Bantuan Penduduk', 'link' => 'first/statistik/bantuan_penduduk'],
    ['nama' => 'Penerima Bantuan Keluarga', 'link' => 'first/statistik/bantuan_keluarga'],
    ['nama' => 'Penerima Bantuan Penduduk (Short)', 'link' => 'statistik/bantuan_penduduk'],
    ['nama' => 'Penerima Bantuan Keluarga (Short)', 'link' => 'statistik/bantuan_keluarga'],
];

foreach ($itemsToEnsure as $item) {
    $check = $pdo->prepare("SELECT id FROM menu WHERE link = ?");
    $check->execute([$item['link']]);
    if (!$check->fetch()) {
        $ins = $pdo->prepare("INSERT INTO menu (config_id, nama, link, parrent, enabled, urut) VALUES (1, ?, ?, 0, 1, 99)");
        $ins->execute([$item['nama'], $item['link']]);
        echo "Inserted menu item: " . $item['nama'] . "\n";
    }
}

echo "Sync completed successfully.\n";
