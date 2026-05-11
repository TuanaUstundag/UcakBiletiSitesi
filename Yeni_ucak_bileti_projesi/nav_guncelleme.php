<?php
/**
 * index.php — nav bloğu için bu kodu kullanın.
 *
 * index.php dosyanızın başına session_start() ekleyin:
 *   <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
 *
 * Ardından <nav>...</nav> bloğunu aşağıdakiyle değiştirin:
 */
?>

<!-- ====== GÜNCELLENEN NAV ====== -->
<nav>
  <a class="logo" href="index.php">
    <div class="logo-icon">✈</div>
    UçuşBul
  </a>
  <div class="nav-links">
    <a href="#flights">Uçuşlar</a>
    <a href="#features">Neden Biz?</a>
    <a href="#survey">Değerlendirme</a>
  </div>

  <!-- Giriş durumuna göre nav sağ tarafı -->
  <?php if (isset($_SESSION['kullanici_id'])): ?>
    <!-- Giriş yapılmış: kullanıcı adı + çıkış butonu -->
    <div style="display:flex; align-items:center; gap:14px;">
      <span style="color:rgba(255,255,255,0.80); font-size:14px; font-weight:600;">
        👤 <?= htmlspecialchars($_SESSION['kullanici_adi']) ?>
      </span>
      <a href="kullanici_cikis.php" class="nav-btn" style="background:transparent; border:1.5px solid rgba(255,255,255,0.3); color:rgba(255,255,255,0.8);">
        Çıkış
      </a>
    </div>
  <?php else: ?>
    <!-- Giriş yapılmamış: Giriş Yap + Üye Ol -->
    <div style="display:flex; align-items:center; gap:10px;">
      <a href="kullanici_giris.php" class="nav-btn" style="background:transparent; border:1.5px solid rgba(255,255,255,0.3); color:rgba(255,255,255,0.8);">
        Giriş Yap
      </a>
      <a href="register.php" class="nav-btn">
        Üye Ol
      </a>
    </div>
  <?php endif; ?>
</nav>

<?php
/*
 * AYRICA index.php'nin EN ÜSTÜNE ekleyin (<?php include_once 'baglanti.php'; satırından önce):
 *
 *   if (session_status() === PHP_SESSION_NONE) session_start();
 *
 * Ve kayıt başarı mesajı için hero bölümüne şunu ekleyebilirsiniz:
 *
 *   <?php if (isset($_GET['kayit']) && $_GET['kayit'] === 'tamam'): ?>
 *     <div style="position:fixed;top:80px;right:20px;z-index:999;
 *                 background:#22c55e;color:white;padding:14px 20px;
 *                 border-radius:12px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,0.2);">
 *       ✅ Hesabınız oluşturuldu, hoş geldiniz!
 *     </div>
 *   <?php endif; ?>
 */
?>
