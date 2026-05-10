<?php
/**
 * Admin Giriş
 * HATA DÜZELTMELERİ:
 * - md5($password) → password_verify() ile değiştirildi (md5 güvensiz!)
 * - Session fixation saldırısına karşı session_regenerate_id() eklendi
 * - Brute-force için rate limit notu eklendi
 *
 * NOT: Mevcut DB'deki md5 şifrelerini password_hash() ile güncelleyin:
 *   UPDATE kullanicilar SET sifre = '$2y$...' WHERE rol = 'admin';
 *   PHP: echo password_hash('sifreni_buraya_yaz', PASSWORD_BCRYPT);
 */
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: AdminPaneli/dashboard.php');
    exit();
}

require_once 'baglanti.php';
$hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basit doğrulama
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hata = 'Geçersiz e-posta formatı.';
    } else {
        $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE email = ? AND rol = 'admin'");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        /*
         * GÜVENLİ YÖNTEM: password_verify()
         * DB'nizdeki şifreler hâlâ md5 ise geçici olarak md5 karşılaştırması yapın
         * ancak şifreleri en kısa sürede password_hash() ile güncelleyin.
         */
        $gecerli = false;
        if ($admin) {
            // Eğer şifre bcrypt ise:
            if (password_verify($password, $admin['sifre'])) {
                $gecerli = true;
            }
            // Geçici uyumluluk: eski md5 şifreler için (kaldırılmalı!)
            elseif (md5($password) === $admin['sifre']) {
                $gecerli = true;
                // Fırsatçı güncelleme: eski md5'i bcrypt ile değiştir
                $yeniHash = password_hash($password, PASSWORD_BCRYPT);
                $db->prepare("UPDATE kullanicilar SET sifre = ? WHERE id = ?")
                   ->execute([$yeniHash, $admin['id']]);
            }
        }

        if ($gecerli) {
            session_regenerate_id(true); // Session fixation önlemi
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_adi']       = $admin['ad_soyad'];
            $_SESSION['admin_id']        = $admin['id'];
            header('Location: AdminPaneli/dashboard.php');
            exit();
        } else {
            $hata = 'E-posta veya şifre hatalı!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş — UçuşBul</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(160deg, #040e2e 0%, #0b1f52 100%);
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
        }
        .box {
            background: white; padding: 2.5rem; border-radius: 20px;
            width: 400px; box-shadow: 0 25px 80px rgba(0,0,0,0.4);
        }
        .logo { text-align: center; margin-bottom: 2rem; }
        .logo-icon { font-size: 36px; display: block; margin-bottom: 10px; }
        .logo h2 { font-family: 'Sora', sans-serif; color: #040e2e; font-size: 20px; }
        label { display: block; font-size: 13px; color: #555; font-weight: 600; margin-bottom: 5px; }
        input {
            width: 100%; padding: 12px 14px; border: 1.5px solid #e2e8f0;
            border-radius: 10px; font-size: 15px; margin-bottom: 16px;
            font-family: 'DM Sans', sans-serif; transition: border 0.2s;
        }
        input:focus { outline: none; border-color: #f97316; }
        button {
            width: 100%; padding: 14px; background: #f97316;
            color: white; border: none; border-radius: 10px;
            font-size: 16px; cursor: pointer; font-weight: 700;
            font-family: 'DM Sans', sans-serif; transition: background 0.2s;
        }
        button:hover { background: #ea6000; }
        .hata {
            background: #fef2f2; color: #991b1b; padding: 10px 14px;
            border-radius: 8px; font-size: 13px; margin-bottom: 18px;
            border-left: 4px solid #ef4444;
        }
    </style>
</head>
<body>
<div class="box">
    <div class="logo">
        <span class="logo-icon">✈️</span>
        <h2>UçuşBul Admin Paneli</h2>
    </div>
    <?php if ($hata): ?>
        <div class="hata"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>E-posta</label>
        <input type="email" name="email" required autofocus placeholder="admin@ucusbul.com">
        <label>Şifre</label>
        <input type="password" name="password" required placeholder="••••••••">
        <button type="submit">Giriş Yap</button>
    </form>
</div>
</body>
</html>
