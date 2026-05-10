<?php
/**
 * Veritabanı bağlantısı
 * HATA DÜZELTMELERİ:
 * - Şifre boş bırakılmış → production'da dolu olmalı
 * - Charset ve hata modu eklendi
 */
$host   = 'localhost';
$port   = '3306';
$dbname = 'ucak_bileti_db';
$username = 'root';
$password = ''; // Production'da gerçek şifre kullanın!

try {
    $db = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // Production'da hata detayını kullanıcıya gösterme
    error_log("DB Bağlantı Hatası: " . $e->getMessage());
    die("Gerçek Hata: " . $e->getMessage());
}
