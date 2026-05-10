<?php
include 'baglanti.php'; // Senin attığın $db değişkenini buradan alıyoruz

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ucus_id = $_POST['ucus_id'];
    $puan = $_POST['puan'];
    $yorum = $_POST['yorum'];

    try {
        // PDO kullanarak veritabanına güvenli ekleme yapıyoruz
        $sorgu = $db->prepare("INSERT INTO anket_sonuclari (ucus_id, puan, yorum) VALUES (?, ?, ?)");
        $sorgu->execute([$ucus_id, $puan, $yorum]);

        echo "Anket kaydedildi! Fiyatlar güncelleniyor...";
        header("Refresh: 2; url=index.php"); 
    } catch(PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}
?>