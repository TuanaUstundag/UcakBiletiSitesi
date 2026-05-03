<?php
require_once 'auth_check.php';
require_once '../baglanti.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
if (!$id) { header('Location: ucuslar.php'); exit(); }

$stmt = $db->prepare("SELECT * FROM ucuslar WHERE id = ?");
$stmt->execute([$id]);
$ucus = $stmt->fetch();
if (!$ucus) { header('Location: ucuslar.php'); exit(); }

$mesaj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kalkis_yeri   = trim($_POST['kalkis_yeri']);
    $varis_yeri    = trim($_POST['varis_yeri']);
    $kalkis_zamani = trim($_POST['kalkis_zamani']);

    $stmt = $db->prepare("UPDATE ucuslar SET kalkis_yeri=?, varis_yeri=?, kalkis_zamani=? WHERE id=?");
    $stmt->execute([$kalkis_yeri, $varis_yeri, $kalkis_zamani, $id]);
    $mesaj = 'Uçuş başarıyla güncellendi! ✅';

    // Güncel veriyi tekrar çek
    $stmt = $db->prepare("SELECT * FROM ucuslar WHERE id = ?");
    $stmt->execute([$id]);
    $ucus = $stmt->fetch();
}

// datetime-local için format
$kalkis_format = date('Y-m-d\TH:i', strtotime($ucus['kalkis_zamani']));
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Uçuş Düzenle — Admin</title>
    <?php include 'inc_style.php'; ?>
</head>
<body>
<?php include 'inc_sidebar.php'; ?>
<div class="main">
    <div class="topbar">
        <h1>Uçuş Düzenle <small style="font-size:14px;color:#999">#<?= $id ?></small></h1>
        <a href="ucuslar.php" class="btn btn-edit">← Listeye Dön</a>
    </div>
    <div class="form-wrap">
        <?php if ($mesaj): ?><div class="basari"><?= $mesaj ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-grup">
                <label>Kalkış Yeri</label>
                <input type="text" name="kalkis_yeri" value="<?= htmlspecialchars($ucus['kalkis_yeri']) ?>" required>
            </div>
            <div class="form-grup">
                <label>Varış Yeri</label>
                <input type="text" name="varis_yeri" value="<?= htmlspecialchars($ucus['varis_yeri']) ?>" required>
            </div>
            <div class="form-grup">
                <label>Kalkış Zamanı</label>
                <input type="datetime-local" name="kalkis_zamani" value="<?= $kalkis_format ?>" required>
            </div>
            <button type="submit" class="btn-add">💾 Değişiklikleri Kaydet</button>
        </form>
    </div>
</div>
</body>
</html>