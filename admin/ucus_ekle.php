<?php
require_once 'auth_check.php';
require_once '../baglanti.php';

$mesaj = '';
$hata  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kalkis_yeri   = trim($_POST['kalkis_yeri']);
    $varis_yeri    = trim($_POST['varis_yeri']);
    $kalkis_zamani = trim($_POST['kalkis_zamani']);

    if ($kalkis_yeri && $varis_yeri && $kalkis_zamani) {
        $stmt = $db->prepare("INSERT INTO ucuslar (kalkis_yeri, varis_yeri, kalkis_zamani) VALUES (?, ?, ?)");
        $stmt->execute([$kalkis_yeri, $varis_yeri, $kalkis_zamani]);
        $mesaj = 'Uçuş başarıyla eklendi! ✅';
    } else {
        $hata = 'Lütfen tüm alanları doldur.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Uçuş Ekle — Admin</title>
    <?php include 'inc_style.php'; ?>
</head>
<body>
<?php include 'inc_sidebar.php'; ?>
<div class="main">
    <div class="topbar">
        <h1>Yeni Uçuş Ekle</h1>
        <a href="ucuslar.php" class="btn btn-edit">← Listeye Dön</a>
    </div>
    <div class="form-wrap">
        <?php if ($mesaj): ?><div class="basari"><?= $mesaj ?></div><?php endif; ?>
        <?php if ($hata): ?><div class="hata-msg"><?= $hata ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-grup">
                <label>Kalkış Yeri</label>
                <input type="text" name="kalkis_yeri" placeholder="Örn: İstanbul" required>
            </div>
            <div class="form-grup">
                <label>Varış Yeri</label>
                <input type="text" name="varis_yeri" placeholder="Örn: Ankara" required>
            </div>
            <div class="form-grup">
                <label>Kalkış Zamanı</label>
                <input type="datetime-local" name="kalkis_zamani" required>
            </div>
            <button type="submit" class="btn-add">✈️ Uçuşu Ekle</button>
        </form>
    </div>
</div>
</body>
</html>