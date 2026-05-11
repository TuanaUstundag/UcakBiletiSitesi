<?php
/**
 * Kullanıcı Çıkış
 */
if (session_status() === PHP_SESSION_NONE) session_start();

// Sadece kullanıcı session değişkenlerini temizle (admin oturumuna dokunma)
unset($_SESSION['kullanici_id']);
unset($_SESSION['kullanici_adi']);
unset($_SESSION['kullanici_email']);

// Oturumu tamamen yok etmek için:
// session_destroy();

header('Location: kullanici_giris.php?cikis=1');
exit();
