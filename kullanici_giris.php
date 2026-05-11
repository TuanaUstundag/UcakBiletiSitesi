<?php
/**
 * Kullanıcı Giriş Sayfası (Normal Üye + Admin Yönlendirme)
 * Güvenli: password_verify, session_regenerate_id, PDO parametreli sorgu
 */
if (session_status() === PHP_SESSION_NONE) session_start();

// Zaten giriş yapmışsa ana sayfaya yönlendir
if (isset($_SESSION['kullanici_id'])) {
    header('Location: index.php');
    exit();
}

require_once 'baglanti.php';

$hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email  = trim($_POST['email']  ?? '');
    $sifre  = $_POST['sifre'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hata = 'Geçerli bir e-posta adresi girin.';
    } elseif (empty($sifre)) {
        $hata = 'Şifre boş bırakılamaz.';
    } else {
        // Hem musteri hem admin rolünü getir
        $stmt = $db->prepare(
            "SELECT id, ad_soyad, email, sifre, rol FROM kullanicilar
             WHERE email = ? AND rol IN ('musteri', 'admin')"
        );
        $stmt->execute([$email]);
        $kullanici = $stmt->fetch();

        $gecerli = false;
        if ($kullanici) {
            if (password_verify($sifre, $kullanici['sifre'])) {
                $gecerli = true;
            }
            // Geçici: eski md5 uyumluluğu (kaldırılmalı!)
            elseif (md5($sifre) === $kullanici['sifre']) {
                $gecerli = true;
                $yeniHash = password_hash($sifre, PASSWORD_BCRYPT);
                $db->prepare("UPDATE kullanicilar SET sifre = ? WHERE id = ?")
                   ->execute([$yeniHash, $kullanici['id']]);
            }
        }

        if ($gecerli) {
            session_regenerate_id(true);

            // --- ADMIN KONTROLÜ ---
            if ($kullanici['rol'] === 'admin') {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_adi']       = $kullanici['ad_soyad'];
                header('Location: admin/dashboard.php');
                exit();
            }

            // --- NORMAL KULLANICI ---
            $_SESSION['kullanici_id']    = $kullanici['id'];
            $_SESSION['kullanici_adi']   = $kullanici['ad_soyad'];
            $_SESSION['kullanici_email'] = $kullanici['email'];

            // Önceki sayfaya ya da ana sayfaya yönlendir
            $hedef = $_SESSION['giris_sonrasi_url'] ?? 'index.php';
            unset($_SESSION['giris_sonrasi_url']);
            header('Location: ' . $hedef);
            exit();
        } else {
            $hata = 'E-posta veya şifre hatalı.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap — UçuşBul</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(160deg, #040e2e 0%, #0b1f52 100%);
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 2rem 1rem;
        }

        .top-logo {
            text-align: center; margin-bottom: 1.5rem; color: white;
        }
        .top-logo a {
            display: inline-flex; align-items: center; gap: 10px;
            text-decoration: none; color: white;
            font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800;
        }
        .logo-icon {
            width: 40px; height: 40px;
            background: #f97316; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .box {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            width: 100%; max-width: 400px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
        }
        .box-title {
            font-family: 'Sora', sans-serif;
            font-size: 22px; font-weight: 800;
            color: #040e2e; margin-bottom: 0.25rem;
        }
        .box-sub {
            font-size: 14px; color: #6b7280; margin-bottom: 1.75rem;
        }

        label {
            display: block; font-size: 13px;
            font-weight: 600; color: #374151; margin-bottom: 5px;
        }
        input {
            width: 100%; padding: 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px; font-size: 15px;
            margin-bottom: 16px;
            font-family: 'DM Sans', sans-serif;
            transition: border 0.2s; background: #f8faff;
        }
        input:focus { outline: none; border-color: #f97316; background: white; }

        /* Şifre satırı */
        .pass-row { position: relative; }
        .pass-row input { padding-right: 44px; }
        .toggle-pass {
            position: absolute; right: 12px; top: 14px;
            background: none; border: none;
            cursor: pointer; font-size: 18px; color: #9ca3af;
        }

        /* Şifremi unuttum */
        .forgot {
            display: block; text-align: right;
            font-size: 13px; color: #f97316;
            text-decoration: none; margin-top: -10px;
            margin-bottom: 18px;
        }
        .forgot:hover { text-decoration: underline; }

        .btn {
            width: 100%; padding: 14px;
            background: #f97316; color: white;
            border: none; border-radius: 10px;
            font-size: 16px; font-weight: 700;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.2s;
        }
        .btn:hover { background: #ea6000; }

        .hata-kutu {
            background: #fef2f2; color: #991b1b;
            border-left: 4px solid #ef4444;
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .basari-kutu {
            background: #f0fdf4; color: #166534;
            border-left: 4px solid #22c55e;
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .divider {
            text-align: center; color: #d1d5db;
            margin: 1.25rem 0; font-size: 13px;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute; top: 50%;
            width: 42%; height: 1px; background: #e5e7eb;
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .btn-register {
            width: 100%; padding: 13px;
            background: white; color: #040e2e;
            border: 2px solid #040e2e;
            border-radius: 10px; font-size: 15px;
            font-weight: 700; cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s; text-decoration: none;
            display: block; text-align: center;
        }
        .btn-register:hover { background: #040e2e; color: white; }

        .alt-link {
            text-align: center; margin-top: 1.25rem;
            font-size: 13px; color: #6b7280;
        }
        .alt-link a { color: #f97316; font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>

<div class="top-logo">
    <a href="index.php">
        <div class="logo-icon">✈</div>
        UçuşBul
    </a>
</div>

<div class="box">
    <div class="box-title">Giriş Yap</div>
    <div class="box-sub">Hesabınıza hoş geldiniz 👋</div>

    <?php if ($hata): ?>
        <div class="hata-kutu"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['kayit']) && $_GET['kayit'] === 'tamam'): ?>
        <div class="basari-kutu">✅ Kayıt başarılı! Giriş yapabilirsiniz.</div>
    <?php endif; ?>

    <?php if (isset($_GET['cikis'])): ?>
        <div class="basari-kutu">👋 Başarıyla çıkış yapıldı.</div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <label>E-posta</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
               placeholder="ahmet@email.com" required autofocus>

        <label>Şifre</label>
        <div class="pass-row">
            <input type="password" name="sifre" id="sifreInput"
                   placeholder="••••••••" required>
            <button type="button" class="toggle-pass" onclick="togglePass()">👁️</button>
        </div>

        <a href="#" class="forgot">Şifremi unuttum</a>

        <button class="btn" type="submit">Giriş Yap →</button>
    </form>

    <div class="divider">veya</div>

    <a class="btn-register" href="register.php">✈ Yeni Hesap Oluştur</a>

    <div class="alt-link" style="margin-top:1rem;">
        <a href="index.php">← Ana Sayfaya Dön</a>
    </div>
</div>

<script>
function togglePass() {
    const input = document.getElementById('sifreInput');
    const btn = document.querySelector('.toggle-pass');
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>
</body>
</html>