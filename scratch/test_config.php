<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== CONFIG / IDENTITAS DESA TABLE ===\n";
$stmt = $pdo->query("SELECT id, nama_desa FROM config");
while ($c = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$c['id']} | Nama Desa: {$c['nama_desa']}\n";
}
