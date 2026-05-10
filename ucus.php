<?php
// 1. Veritabanı bağlantısı (Senin hazırladığın baglanti.php)
include 'baglanti.php'; 

// 2. MUSTAFA'NIN DİNAMİK FİYAT HESAPLAMA MOTORU
$ucus_id = 1; // Test için 1 numaralı uçuş
$sorgu_puan = $db->prepare("SELECT AVG(puan) as ortalama FROM anket_sonuclari WHERE ucus_id = ?");
$sorgu_puan->execute([$ucus_id]);
$anket_verisi = $sorgu_puan->fetch(PDO::FETCH_ASSOC);

$ortalama_puan = $anket_verisi['ortalama'] ? round($anket_verisi['ortalama'], 1) : 0;

// Fiyat Algoritması
$baz_fiyat = 750; 
$guncel_fiyat = $baz_fiyat;
$durum_mesaji = "";

if ($ortalama_puan >= 4.5) {
    $guncel_fiyat = $baz_fiyat * 1.20; // %20 Zam
    $durum_mesaji = "🔥 Popüler Seçim!";
} elseif ($ortalama_puan > 0 && $ortalama_puan <= 2.5) {
    $guncel_fiyat = $baz_fiyat * 0.85; // %15 İndirim
    $durum_mesaji = "📉 Fırsat Uçuşu!";
}

$yildizlar = $ortalama_puan > 0 ? str_repeat("⭐", floor($ortalama_puan)) : "Henüz puanlanmadı";
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UçuşBul — Koltuk Seçimi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* --- Senin Tasarımın + Küçük Düzeltmeler --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f7f8fc; color: #141b3c; }
        nav { background: #0a1628; padding: 1rem 2.5rem; display: flex; align-items: center; }
        .logo { font-size: 20px; font-weight: 700; color: #fff; text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .logo-icon { width: 30px; height: 30px; background: #f90; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .main-container { display: flex; flex-wrap: wrap; gap: 2rem; max-width: 1000px; margin: 2rem auto; padding: 0 1.5rem; }
        .selection-area { flex: 2; min-width: 300px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(5,16,58,.05); overflow: hidden; border: 1px solid #edf0fa; }
        .header { background: linear-gradient(135deg, #0a1628 0%, #1a3a6b 100%); color: #fff; padding: 2rem; text-align: center; }
        .header h1 { font-size: 24px; font-weight: 800; margin: 10px 0 5px; }
        .cabin-layout { padding: 3rem 1rem; display: flex; justify-content: center; }
        .fuselage { background: #fff; border: 3px solid #eef0f7; border-radius: 50% 50% 10px 10px / 15% 15% 0 0; padding: 3rem 2rem 2rem; }
        .seating-plan { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .summary-area { flex: 1; min-width: 280px; background: #fff; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(5,16,58,.05); border: 1px solid #edf0fa; height: fit-content; position: sticky; top: 2rem; }
        .summary-area h2 { font-size: 18px; font-weight: 800; color: #0a1628; margin-bottom: 1rem; border-bottom: 2px solid #eef0f7; padding-bottom: 10px;}
        .seat-btn { background: #eef0f7; border: 2px solid #d1d8f0; border-radius: 8px; padding: 15px; cursor: pointer; transition: 0.2s; font-weight: bold; }
        .seat-btn.selected { background: #f90; border-color: #e08800; color: #fff; }
        .puan-badge { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 10px; font-size: 13px; margin-top: 10px; }
        .buy-btn { width: 100%; margin-top: 15px; background: #f90; color: white; border: none; padding: 15px; border-radius: 10px; font-weight: 800; cursor: pointer; display: none; }
    </style>
</head>
<body>

    <nav>
        <a class="logo" href="index.php"><div class="logo-icon">✈</div> UçuşBul</a>
    </nav>

    <div class="main-container">
        <div class="selection-area">
            <header class="header">
                <h1>UçuşBul Koltuk Seçimi</h1>
                <div class="puan-badge">
                    Müşteri Memnuniyeti: <?php echo $yildizlar; ?> (<?php echo $ortalama_puan; ?>)<br>
                    <strong><?php echo $durum_mesaji; ?></strong>
                </div>
            </header>

            <div class="cabin-layout">
                <div class="fuselage">
                    <div class="seating-plan">
                        <?php for($i=1; $i<=20; $i++): ?>
                            <button class="seat-btn" onclick="selectSeat(this, <?php echo $i; ?>)"><?php echo $i; ?></button>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="summary-area">
            <h2>Uçuş Özeti</h2>
            <div id="bookingSummary" class="booking-summary">
                <p>Birim Fiyat: <strong><?php echo number_format($guncel_fiyat, 2); ?> TL</strong></p>
                <p id="seatList" style="margin-top:10px; color:#9199b8;">Koltuk seçilmedi.</p>
                <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eef0f7;">
                <p style="font-size: 18px; color: #0a1628;">Toplam: <strong id="totalPrice" style="color:#f90;">0.00 TL</strong></p>
            </div>
            <button id="satinAlBtn" class="buy-btn">Bileti Satın Al ✈️</button>
        </div>
    </div>

    <script>
        let selectedSeats = [];
        const pricePerSeat = <?php echo $guncel_fiyat; ?>;

        function selectSeat(element, seatNo) {
            element.classList.toggle('selected');
            
            if (element.classList.contains('selected')) {
                selectedSeats.push(seatNo);
            } else {
                selectedSeats = selectedSeats.filter(s => s !== seatNo);
            }

            // Arayüzü Güncelle
            document.getElementById('seatList').innerText = selectedSeats.length > 0 ? 
                "Seçilen: " + selectedSeats.join(', ') : "Koltuk seçilmedi.";
            
            const total = selectedSeats.length * pricePerSeat;
            document.getElementById('totalPrice').innerText = total.toLocaleString('tr-TR', { minimumFractionDigits: 2 }) + " TL";
            
            document.getElementById('satinAlBtn').style.display = selectedSeats.length > 0 ? 'block' : 'none';
        }
    </script>
</body>
</html>