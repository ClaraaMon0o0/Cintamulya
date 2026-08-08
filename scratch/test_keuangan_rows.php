<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');
echo "=== KEUANGAN ROWS ===\n";
$stmt = $pdo->query("SELECT * FROM keuangan");
while($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}
