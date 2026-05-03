<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Zaten giriş yaptıysa direkt dashboard'a gönder
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit();
}

require_once '../baglanti.php';
$hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE email = ? AND rol = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['sifre'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_adi']       = $admin['ad_soyad'];
        header('Location: dashboard.php');
        exit();
    } else {
        $hata = 'E-posta veya şifre hatalı, ya da admin değilsin!';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş — UçuşBul</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a237e, #283593);
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
        }
        .box {
            background: white; padding: 40px; border-radius: 14px;
            width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .logo { text-align: center; margin-bottom: 28px; }
        .logo span { font-size: 28px; }
        .logo h2 { color: #1a237e; font-size: 20px; margin-top: 8px; }
        label { display: block; font-size: 13px; color: #555; font-weight: bold; margin-bottom: 5px; }
        input {
            width: 100%; padding: 11px 14px; border: 1px solid #ddd;
            border-radius: 7px; font-size: 14px; margin-bottom: 18px;
            transition: border 0.2s;
        }
        input:focus { outline: none; border-color: #ff6b00; }
        button {
            width: 100%; padding: 13px; background: #ff6b00;
            color: white; border: none; border-radius: 7px;
            font-size: 16px; cursor: pointer; font-weight: bold;
        }
        button:hover { background: #e55a00; }
        .hata {
            background: #fdecea; color: #c62828; padding: 10px 14px;
            border-radius: 7px; font-size: 13px; margin-bottom: 18px;
            border-left: 4px solid #e53935;
        }
    </style>
</head>
<body>
<div class="box">
    <div class="logo">
        <span>✈️</span>
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