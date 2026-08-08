<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== ALL LINKS IN MENU TABLE ===\n";
$stmt = $pdo->query("SELECT id, nama, link, enabled FROM menu");
while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$m['id']} | Name: {$m['nama']} | Link: {$m['link']} | Enabled: {$m['enabled']}\n";
}
