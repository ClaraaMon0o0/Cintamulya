<?php
$pdo = new PDO('mysql:host=localhost;dbname=opensid_cintamulya', 'root', '');
echo "=== MEDIA SOSIAL RECORDS ===\n";
$stmt = $pdo->query('SELECT * FROM media_sosial');
while($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$r['id']} | Nama: {$r['nama']} | Link: {$r['link']} | Gambar: {$r['gambar']} | Enabled: {$r['enabled']}\n";
}
