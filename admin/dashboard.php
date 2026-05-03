<?php
require_once 'auth_check.php';
require_once '../baglanti.php';

$ucus_sayisi    = $db->query("SELECT COUNT(*) FROM ucuslar")->fetchColumn();
$koltuk_sayisi  = $db->query("SELECT COUNT(*) FROM koltuklar")->fetchColumn();
$kullanici_sayisi = $db->query("SELECT COUNT(*) FROM kullanicilar WHERE rol = 'kullanici'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard — Admin</title>
    <?php include 'inc_style.php'; ?>
</head>
<body>
<?php include 'inc_sidebar.php'; ?>
<div class="main">
    <div class="topbar">
        <h1>Dashboard</h1>
        <span>Hoş geldin, <strong><?= htmlspecialchars($_SESSION['admin_adi']) ?></strong>
        | <a href="logout.php">Çıkış Yap</a></span>
    </div>
    <div class="cards">
        <div class="card">
            <div class="sayi"><?= $ucus_sayisi ?></div>
            <div class="etiket">✈️ Toplam Uçuş</div>
        </div>
        <div class="card">
            <div class="sayi"><?= $koltuk_sayisi ?></div>
            <div class="etiket">💺 Toplam Koltuk</div>
        </div>
        <div class="card">
            <div class="sayi"><?= $kullanici_sayisi ?></div>
            <div class="etiket">👤 Kayıtlı Kullanıcı</div>
        </div>
    </div>
</div>
</body>
</html>