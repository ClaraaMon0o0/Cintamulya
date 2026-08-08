<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== TABLES MATCHING MANDIRI / PENDUDUK ===\n";
$stmt = $pdo->query("SHOW TABLES LIKE '%penduduk%'");
while($r = $stmt->fetch(PDO::FETCH_NUM)) {
    echo $r[0] . "\n";
}

echo "\n=== TABLES MATCHING MANDIRI ===\n";
$stmt = $pdo->query("SHOW TABLES LIKE '%mandiri%'");
while($r = $stmt->fetch(PDO::FETCH_NUM)) {
    echo $r[0] . "\n";
}

echo "\n=== COLUMNS IN tweb_penduduk RELATED TO PIN/PASS/MANDIRI ===\n";
$stmt = $pdo->query("DESCRIBE tweb_penduduk");
while($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (preg_match('/pin|pass|mandiri|nik/i', $r['Field'])) {
        print_r($r);
    }
}
