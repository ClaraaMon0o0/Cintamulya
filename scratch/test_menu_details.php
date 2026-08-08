<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== PARRENT & LINK TIPE IN MENU TABLE ===\n";
$stmt = $pdo->query("SELECT id, config_id, nama, link, parrent, link_tipe, enabled FROM menu WHERE link IN ('pemerintah', 'status-idm') OR link LIKE '%pemerintah%' OR link LIKE '%idm%'");
while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$m['id']} | ConfigID: {$m['config_id']} | Name: {$m['nama']} | Link: {$m['link']} | Parrent: {$m['parrent']} | Tipe: {$m['link_tipe']} | Enabled: {$m['enabled']}\n";
}
