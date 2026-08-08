<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== ALL MENU ITEMS IN DB ===\n";
$stmt = $pdo->query("SELECT id, config_id, nama, link, enabled FROM menu WHERE link LIKE '%pemerintah%' OR link LIKE '%idm%'");
while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$m['id']} | ConfigID: {$m['config_id']} | Name: {$m['nama']} | Link: {$m['link']} | Enabled: {$m['enabled']}\n";
}
