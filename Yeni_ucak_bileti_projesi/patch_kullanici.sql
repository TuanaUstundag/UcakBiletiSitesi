-- ==========================================================
-- UçuşBul — Kullanıcı Sistemi Yaması
-- phpMyAdmin'de ya da MySQL CLI'de çalıştırın.
-- ==========================================================

USE `ucak_bileti_db`;

-- 1) kullanicilar tablosuna telefon sütunu ekle (yoksa)
--    (tablo zaten varsa ve telefon yoksa ALTER TABLE çalışır)
ALTER TABLE `kullanicilar`
    MODIFY COLUMN `rol` ENUM('admin','musteri') NOT NULL DEFAULT 'musteri';

-- Eğer telefon sütunu hiç yoksa ekle:
-- (MySQL 8+ için IF NOT EXISTS desteği yoktur, bu yüzden önce kontrol edin)
-- Güvenli yol: aşağıdaki komutu sadece telefon sütunu eksikse çalıştırın:
ALTER TABLE `kullanicilar`
    ADD COLUMN IF NOT EXISTS `telefon` varchar(20) DEFAULT NULL AFTER `email`;

-- 2) Örnek müşteri kaydı (test için)
--    Şifre: test1234  →  password_hash('test1234', PASSWORD_BCRYPT)
INSERT IGNORE INTO `kullanicilar` (`ad_soyad`, `email`, `telefon`, `sifre`, `rol`) VALUES
(
    'Test Kullanıcı',
    'test@ucusbul.com',
    '+90 555 000 00 00',
    '$2y$12$8M7b1uEvDUL5HyRnPEUMPOLHEV8zKLy2g3h9vYWUJqbsTb9LMqJFi',
    'musteri'
);

-- ==========================================================
-- NOTLAR:
-- • Kayıt sayfası (register.php) şifreyi otomatik olarak
--   password_hash() ile hashler, bu SQL sadece test içindir.
-- • rol sütununuz ENUM değilse önce şunu çalıştırın:
--   ALTER TABLE kullanicilar MODIFY COLUMN rol VARCHAR(20) NOT NULL DEFAULT 'musteri';
-- ==========================================================
