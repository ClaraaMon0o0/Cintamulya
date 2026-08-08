<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');
echo "=== KEUANGAN TABLES ===\n";
$stmt = $pdo->query("SHOW TABLES LIKE '%keuangan%'");
while($r = $stmt->fetch(PDO::FETCH_NUM)) {
    echo $r[0] . "\n";
}
