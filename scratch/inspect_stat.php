<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');
$stmt = $pdo->query("SELECT id, nama, link, enabled FROM menu WHERE link LIKE '%statistik%' OR link LIKE '%bantuan%' OR link LIKE '%keluarga%' OR link IN ('dpt', 'data-wilayah')");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "=== MENU TABLE IN DB ===\n";
print_r($menus);
