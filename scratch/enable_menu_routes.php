<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

// Check current menu entries for pemerintah and status-idm
echo "=== CURRENT MENU ENTRIES ===\n";
$stmt = $pdo->query("SELECT id, nama, link, enabled FROM menu WHERE link LIKE '%pemerintah%' OR link LIKE '%idm%' OR link LIKE '%status%'");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);

// Enable or insert missing menu entries
$routesToEnable = [
    'pemerintah' => 'Aparatur Desa',
    'status-idm' => 'Status IDM',
    'status-idm/2024' => 'Status IDM 2024',
    'status-idm/2023' => 'Status IDM 2023',
    'status-idm/2022' => 'Status IDM 2022',
];

foreach ($routesToEnable as $link => $nama) {
    // Check if exists
    $check = $pdo->prepare("SELECT id, enabled FROM menu WHERE link = ? OR link LIKE ?");
    $check->execute([$link, $link . '%']);
    $found = $check->fetch(PDO::FETCH_ASSOC);
    
    if ($found) {
        $upd = $pdo->prepare("UPDATE menu SET enabled = 1 WHERE id = ?");
        $upd->execute([$found['id']]);
        echo "Updated menu ID {$found['id']} ({$link}) to enabled = 1\n";
    } else {
        $ins = $pdo->prepare("INSERT INTO menu (config_id, nama, link, parrent, enabled, urut) VALUES (1, ?, ?, 0, 1, 99)");
        $ins->execute([$nama, $link]);
        echo "Inserted new menu entry for {$link}\n";
    }
}

// Enable all menu items where link matches government or IDM
$pdo->exec("UPDATE menu SET enabled = 1 WHERE link LIKE '%pemerintah%' OR link LIKE '%idm%'");
echo "\nSuccessfully enabled all pemerintah and status-idm menu items!\n";
