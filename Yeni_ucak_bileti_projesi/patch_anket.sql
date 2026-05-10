-- ==========================================================
-- UçuşBul Veritabanı Yaması
-- HATA: anket_sonuclari tablosu ucak_bileti_db.sql'de eksikti
-- Bu dosyayı phpMyAdmin'de çalıştırın veya ucak_bileti_db.sql'e ekleyin
-- ==========================================================

USE `ucak_bileti_db`;

-- Tablo zaten varsa hata verme
CREATE TABLE IF NOT EXISTS `anket_sonuclari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ucus_id` int(11) NOT NULL,
  `puan` tinyint(1) NOT NULL CHECK (`puan` BETWEEN 1 AND 5),
  `yorum` text DEFAULT NULL,
  `olusturulma_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `ucus_id` (`ucus_id`),
  CONSTRAINT `anket_ucus_fk` FOREIGN KEY (`ucus_id`)
    REFERENCES `ucuslar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ==========================================================
-- Admin kullanıcısı ekleme (şifre: admin123)
-- password_hash('admin123', PASSWORD_BCRYPT) ile oluşturuldu
-- Kendi şifrenizi eklerken PHP'de: echo password_hash('sifreni', PASSWORD_BCRYPT);
-- ==========================================================

INSERT IGNORE INTO `kullanicilar` (`ad_soyad`, `email`, `sifre`, `rol`) VALUES
('Site Yöneticisi', 'admin@ucusbul.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- NOT: Yukarıdaki hash 'password' kelimesine karşılık gelir. Değiştirin!
