<?php
/**
 * Anket Kaydet
 * HATA DÜZELTMELERİ:
 * - SQL tablosu anket_sonuclari → veritabanında bu tablo eksikti (ucak_bileti_db.sql'e eklenmeli)
 * - Input doğrulama eklendi
 * - Güvenli PDO parametreli sorgu kullanıldı
 */
include_once 'baglanti.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$ucus_id = filter_input(INPUT_POST, 'ucus_id', FILTER_VALIDATE_INT);
$puan    = filter_input(INPUT_POST, 'puan', FILTER_VALIDATE_INT);
$yorum   = trim($_POST['yorum'] ?? '');

// Doğrulama
if (!$ucus_id || !$puan || $puan < 1 || $puan > 5) {
    http_response_code(400);
    echo json_encode(['durum' => 'hata', 'mesaj' => 'Geçersiz veri.']);
    exit();
}

$yorum = htmlspecialchars($yorum, ENT_QUOTES, 'UTF-8');

try {
    /*
     * NOT: ucak_bileti_db.sql'e şu tabloyu eklemeniz gerekiyor:
     *
     * CREATE TABLE `anket_sonuclari` (
     *   `id` int(11) NOT NULL AUTO_INCREMENT,
     *   `ucus_id` int(11) NOT NULL,
     *   `puan` tinyint(1) NOT NULL,
     *   `yorum` text DEFAULT NULL,
     *   `olusturulma_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
     *   PRIMARY KEY (`id`),
     *   FOREIGN KEY (`ucus_id`) REFERENCES `ucuslar`(`id`) ON DELETE CASCADE
     * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
     */
    $sorgu = $db->prepare(
        "INSERT INTO anket_sonuclari (ucus_id, puan, yorum) VALUES (?, ?, ?)"
    );
    $sorgu->execute([$ucus_id, $puan, $yorum]);

    // JSON yanıt (AJAX için) veya redirect
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        echo json_encode(['durum' => 'tamam', 'mesaj' => 'Anket kaydedildi.']);
    } else {
        header("Location: index.php?anket=tamam");
    }
} catch (PDOException $e) {
    error_log("Anket kayıt hatası: " . $e->getMessage());
    echo json_encode(['durum' => 'hata', 'mesaj' => 'Kayıt sırasında bir hata oluştu.']);
}
