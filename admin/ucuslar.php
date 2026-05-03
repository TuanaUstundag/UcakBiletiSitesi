<?php
require_once 'auth_check.php';
require_once '../baglanti.php';

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
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['kalkis_yeri']) ?></td>
                    <td><?= htmlspecialchars($u['varis_yeri']) ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($u['kalkis_zamani'])) ?></td>
                    <td>
                        <a href="ucus_duzenle.php?id=<?= $u['id'] ?>" class="btn btn-edit">✏️ Düzenle</a>
                        <a href="ucus_sil.php?id=<?= $u['id'] ?>" class="btn btn-del"
                           onclick="return confirm('Bu uçuşu silmek istediğine emin misin?')">🗑️ Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>