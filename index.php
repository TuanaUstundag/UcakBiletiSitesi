<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uçak Bileti Sistemi</title>
</head>
<body>

    <form method="GET" action="index.php" style="background: #f1f1f1; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <label>Nereden:</label>
        <select name="kalkis" required>
            <option value="">Seçiniz...</option>
            <option value="İstanbul">İstanbul</option>
            <option value="Ankara">Ankara</option>
            <option value="İzmir">İzmir</option>
            <option value="İstanbul">Antalya</option>
            <option value="Trabzon">Trabzon</option>
        </select>

        <label>Nereye:</label>
        <select name="varis" required>
            <option value="">Seçiniz...</option>
            <option value="İzmir">İzmir</option>
            <option value="Antalya">Antalya</option>
            <option value="Trabzon">Trabzon</option>
            <option value="İstanbul">İstanbul</option>
            <option value="Ankara">Ankara</option>
        </select>

        <button type="submit">Uçuş Bul ✈️</button>
    </form>

    <?php
    require_once 'baglanti.php';

    // Başlangıçta tüm uçuşları çekecek varsayılan SQL sorgusu
    $sql = "SELECT * FROM ucuslar";
    $parametreler = [];

    // Eğer arama formundan veriler geldiyse ve boş değilse Filtreleme çalışır
    if (isset($_GET['kalkis']) && isset($_GET['varis']) && $_GET['kalkis'] != "" && $_GET['varis'] != "") {
        $sql = "SELECT * FROM ucuslar WHERE kalkis_yeri = ? AND varis_yeri = ?";
        $parametreler = [$_GET['kalkis'], $_GET['varis']];
    }

    // Tarihe göre sıralama
    $sql .= " ORDER BY kalkis_zamani ASC";

    
    $sorgu = $db->prepare($sql);
    $sorgu->execute($parametreler);
    $ucuslar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <h2>Uçuş Listesi</h2>
    
    <?php if (count($ucuslar) > 0): ?>
        <?php foreach ($ucuslar as $ucus): ?>
            <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0; border-radius: 5px;">
                <h3><?= htmlspecialchars($ucus['kalkis_yeri']) ?> ✈️ <?= htmlspecialchars($ucus['varis_yeri']) ?></h3>
                <p>Kalkış Zamanı: <?= date('d.m.Y H:i', strtotime($ucus['kalkis_zamani'])) ?></p>
                <button style="background: #007BFF; color: white; border: none; padding: 5px 10px; cursor:pointer;">Koltuk Seç</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: red;">Aradığınız kriterlere uygun uçuş bulunamadı.</p>
    <?php endif; ?>

</body>
</html>