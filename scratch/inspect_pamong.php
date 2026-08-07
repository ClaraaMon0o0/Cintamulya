<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');

echo "=== SAMPLE PAMONG DATA ===\n";
$stmt = $pdo->query('SELECT p.pamong_id, p.pamong_nama, p.pamong_nip, p.pamong_niap, p.foto, p.pamong_sex, p.pamong_status, p.urut, j.nama as nama_jabatan FROM tweb_desa_pamong p LEFT JOIN ref_jabatan j ON p.jabatan_id = j.id WHERE p.pamong_status = 1 ORDER BY p.urut ASC LIMIT 10');
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID:" . $r['pamong_id'] . " | NAME: " . $r['pamong_nama'] . " | JABATAN: " . ($r['nama_jabatan'] ?? 'N/A') . " | FOTO: " . ($r['foto'] ?? 'N/A') . " | SEX: " . $r['pamong_sex'] . "\n";
}
