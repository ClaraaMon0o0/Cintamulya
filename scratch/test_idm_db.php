<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== IDM TABLE IN DB ===\n";
$stmt = $pdo->query("SELECT * FROM idm");
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$r['id']} | Tahun: {$r['tahun']} | Skor: {$r['skor']} | Status: {$r['status']}\n";
}
