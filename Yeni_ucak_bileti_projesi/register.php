<?php
/**
 * Kullanıcı Kayıt Sayfası
 * Güvenli: PDO parametreli sorgu, password_hash, htmlspecialchars
 */
if (session_status() === PHP_SESSION_NONE) session_start();

// Zaten giriş yapmışsa yönlendir
if (isset($_SESSION['kullanici_id'])) {
    header('Location: index.php');
    exit();
}

require_once 'baglanti.php';

$hatalar = [];
$basari  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad_soyad = trim($_POST['ad_soyad'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $telefon  = trim($_POST['telefon']  ?? '');
    $sifre    = $_POST['sifre']         ?? '';
    $sifre2   = $_POST['sifre2']        ?? '';

    // --- Doğrulama ---
    if (mb_strlen($ad_soyad) < 3) {
        $hatalar[] = 'Ad soyad en az 3 karakter olmalıdır.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hatalar[] = 'Geçerli bir e-posta adresi girin.';
    }
    if (!empty($telefon) && !preg_match('/^[0-9\s\+\-]{7,15}$/', $telefon)) {
        $hatalar[] = 'Telefon numarası geçersiz.';
    }
    if (mb_strlen($sifre) < 8) {
        $hatalar[] = 'Şifre en az 8 karakter olmalıdır.';
    }
    if ($sifre !== $sifre2) {
        $hatalar[] = 'Şifreler eşleşmiyor.';
    }

    // E-posta benzersizliği kontrolü
    if (empty($hatalar)) {
        $stmt = $db->prepare("SELECT id FROM kullanicilar WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $hatalar[] = 'Bu e-posta adresi zaten kayıtlı.';
        }
    }

    // --- Kayıt ---
    if (empty($hatalar)) {
        $hash = password_hash($sifre, PASSWORD_BCRYPT);
        $stmt = $db->prepare(
            "INSERT INTO kullanicilar (ad_soyad, email, telefon, sifre, rol)
             VALUES (?, ?, ?, ?, 'musteri')"
        );
        $stmt->execute([
            htmlspecialchars($ad_soyad, ENT_QUOTES, 'UTF-8'),
            $email,
            htmlspecialchars($telefon, ENT_QUOTES, 'UTF-8'),
            $hash,
        ]);

        // Otomatik giriş yap
        $yeniId = $db->lastInsertId();
        session_regenerate_id(true);
        $_SESSION['kullanici_id']      = $yeniId;
        $_SESSION['kullanici_adi']     = htmlspecialchars($ad_soyad, ENT_QUOTES, 'UTF-8');
        $_SESSION['kullanici_email']   = $email;

        header('Location: index.php?kayit=tamam');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Ol — UçuşBul</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(160deg, #040e2e 0%, #0b1f52 100%);
            min-height: 100vh;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 2rem 1rem;
        }

        /* Logo üstte */
        .top-logo {
            text-align: center;
            margin-bottom: 1.5rem;
            color: white;
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

        /* Kart */
        .box {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            width: 100%; max-width: 460px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
        }
        .box-title {
            font-family: 'Sora', sans-serif;
            font-size: 22px; font-weight: 800;
            color: #040e2e; margin-bottom: 0.25rem;
        }
        .box-sub {
            font-size: 14px; color: #6b7280;
            margin-bottom: 1.75rem;
        }

        label {
            display: block; font-size: 13px;
            font-weight: 600; color: #374151;
            margin-bottom: 5px;
        }
        input {
            width: 100%; padding: 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px; font-size: 15px;
            margin-bottom: 14px;
            font-family: 'DM Sans', sans-serif;
            transition: border 0.2s;
            background: #f8faff;
        }
        input:focus { outline: none; border-color: #f97316; background: white; }

        /* İkili grid */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .btn {
            width: 100%; padding: 14px;
            background: #f97316; color: white;
            border: none; border-radius: 10px;
            font-size: 16px; font-weight: 700;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            transition: background 0.2s; margin-top: 4px;
        }
        .btn:hover { background: #ea6000; }

        /* Hatalar */
        .hatalar-kutu {
            background: #fef2f2; color: #991b1b;
            border-left: 4px solid #ef4444;
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 13px;
        }
        .hatalar-kutu ul { padding-left: 16px; margin: 0; }
        .hatalar-kutu li { margin-bottom: 4px; }

        /* Alt link */
        .alt-link {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 14px; color: #6b7280;
        }
        .alt-link a { color: #f97316; font-weight: 600; text-decoration: none; }
        .alt-link a:hover { text-decoration: underline; }

        /* İsteğe bağlı etiketi */
        .optional { font-size: 11px; color: #9ca3af; font-weight: 400; }

        /* Şifre göster/gizle wrapper */
        .pass-wrap { position: relative; }
        .pass-wrap input { padding-right: 44px; }
        .toggle-pass {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; font-size: 18px;
            color: #9ca3af; padding: 0;
            margin-bottom: 14px; /* Görseli ortalamak için */
        }

        /* Güç göstergesi */
        .strength-bar {
            height: 4px; border-radius: 2px;
            background: #e2e8f0; margin-top: -10px;
            margin-bottom: 14px; overflow: hidden;
        }
        .strength-fill {
            height: 100%; border-radius: 2px;
            width: 0%; transition: width 0.3s, background 0.3s;
        }

        @media (max-width: 480px) {
            .grid-2 { grid-template-columns: 1fr; }
        }
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
    <div class="box-title">Üye Ol</div>
    <div class="box-sub">Hesap oluşturun, uçuşlarınızı kolayca yönetin.</div>

    <?php if (!empty($hatalar)): ?>
        <div class="hatalar-kutu">
            <ul>
                <?php foreach ($hatalar as $h): ?>
                    <li><?= htmlspecialchars($h) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <label>Ad Soyad</label>
        <input type="text" name="ad_soyad"
               value="<?= htmlspecialchars($_POST['ad_soyad'] ?? '') ?>"
               placeholder="Ahmet Yılmaz" required autofocus>

        <label>E-posta</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
               placeholder="ahmet@email.com" required>

        <label>Telefon <span class="optional">(isteğe bağlı)</span></label>
        <input type="tel" name="telefon"
               value="<?= htmlspecialchars($_POST['telefon'] ?? '') ?>"
               placeholder="+90 555 123 45 67">

        <div class="grid-2">
            <div>
                <label>Şifre</label>
                <div class="pass-wrap">
                    <input type="password" name="sifre" id="sifreInput"
                           placeholder="En az 8 karakter" required
                           oninput="gucGoster(this.value)">
                    <button type="button" class="toggle-pass" onclick="togglePass('sifreInput', this)">👁️</button>
                </div>
                <div class="strength-bar">
                    <div class="strength-fill" id="strengthFill"></div>
                </div>
            </div>
            <div>
                <label>Şifre Tekrar</label>
                <div class="pass-wrap">
                    <input type="password" name="sifre2" id="sifre2Input"
                           placeholder="Şifrenizi tekrar girin" required>
                    <button type="button" class="toggle-pass" onclick="togglePass('sifre2Input', this)">👁️</button>
                </div>
            </div>
        </div>

        <button class="btn" type="submit">✈ Üye Ol</button>
    </form>

    <div class="alt-link">
        Zaten hesabınız var mı?
        <a href="kullanici_giris.php">Giriş Yap</a>
    </div>
</div>

<script>
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}

function gucGoster(val) {
    const fill = document.getElementById('strengthFill');
    let puan = 0;
    if (val.length >= 8)  puan++;
    if (/[A-Z]/.test(val)) puan++;
    if (/[0-9]/.test(val)) puan++;
    if (/[^A-Za-z0-9]/.test(val)) puan++;

    const renkler = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
    fill.style.width  = (puan * 25) + '%';
    fill.style.background = renkler[puan - 1] || '#e2e8f0';
}
</script>
</body>
</html>
