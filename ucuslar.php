<?php
/**
 * Uçuşlar Listesi
 * HATA DÜZELTMELERİ:
 * - Silme işlemi GET'ten POST+CSRF'ye çevrildi
 * - CSRF token session'da oluşturuluyor
 */
require_once 'auth_check.php';
require_once '../baglanti.php';

// CSRF token oluştur
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Silme başarı mesajı
$mesaj = '';
if (isset($_GET['silindi'])) $mesaj = 'Uçuş başarıyla silindi.';

$ucuslar = $db->query("SELECT * FROM ucuslar ORDER BY kalkis_zamani DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Uçuşlar — Admin</title>
    <?php include 'inc_style.php'; ?>
</head>
<body>
<?php include 'inc_sidebar.php'; ?>
<div class="main">
    <div class="topbar">
        <h1>Uçuşlar</h1>
        <a href="ucus_ekle.php" class="btn-add">+ Yeni Uçuş Ekle</a>
    </div>
    <?php if ($mesaj): ?>
        <div class="basari" style="margin-bottom:20px"><?= htmlspecialchars($mesaj) ?></div>
    <?php endif; ?>
    <div class="tablo-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kalkış Yeri</th>
                    <th>Varış Yeri</th>
                    <th>Kalkış Zamanı</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ucuslar as $u): ?>
                <tr>
                    <td><?= (int)$u['id'] ?></td>
                    <td><?= htmlspecialchars($u['kalkis_yeri']) ?></td>
                    <td><?= htmlspecialchars($u['varis_yeri']) ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($u['kalkis_zamani'])) ?></td>
                    <td>
                        <a href="ucus_duzenle.php?id=<?= (int)$u['id'] ?>" class="btn btn-edit">✏️ Düzenle</a>
                        <!-- Silme işlemi artık POST formu ile yapılıyor (CSRF güvenliği) -->
                        <form method="POST" action="ucus_sil.php" style="display:inline"
                              onsubmit="return confirm('Bu uçuşu silmek istediğine emin misin?')">
                            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <button type="submit" class="btn btn-del">🗑️ Sil</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
