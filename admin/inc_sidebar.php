<div class="sidebar">
    <div class="logo">✈️ UçuşBul Admin</div>
    <div class="bolum">Genel</div>
    <a href="dashboard.php" <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'class="active"' : '' ?>>📊 Dashboard</a>
    <div class="bolum">Yönetim</div>
    <a href="ucuslar.php" <?= in_array(basename($_SERVER['PHP_SELF']), ['ucuslar.php','ucus_ekle.php','ucus_duzenle.php']) ? 'class="active"' : '' ?>>🛫 Uçuşlar</a>
    <div class="bolum">Hesap</div>
    <a href="logout.php">🚪 Çıkış Yap</a>
</div>