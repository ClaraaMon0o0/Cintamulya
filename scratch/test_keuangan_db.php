<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');
echo "=== KEUANGAN RECORDS ===\n";
$stmt = $pdo->query('SELECT COUNT(*) as count FROM keuangan_ta_anggaran');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Keuangan TA Anggaran Row Count: " . $row['count'] . "\n";
