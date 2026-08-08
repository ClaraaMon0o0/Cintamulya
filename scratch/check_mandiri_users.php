<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== STRUCTURE OF tweb_penduduk_mandiri ===\n";
$stmt = $pdo->query("DESCRIBE tweb_penduduk_mandiri");
while($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}

echo "\n=== SAMPLE RECORDS IN tweb_penduduk_mandiri ===\n";
$stmt = $pdo->query("SELECT m.*, p.nik, p.nama FROM tweb_penduduk_mandiri m JOIN tweb_penduduk p ON m.id_pend = p.id LIMIT 10");
while($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}
