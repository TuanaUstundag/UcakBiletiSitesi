<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UçuşBul — Koltuk Seçimi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* --- UÇUŞBUL ANA TEMASI --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f7f8fc; /* Anasayfa arka planı */
            color: #141b3c; 
        }

        /* Üst Menü (Anasayfaya Dönüş İçin) */
        nav {
            background: #0a1628;
            padding: 1rem 2.5rem;
            display: flex;
            align-items: center;
        }
        .logo { font-size: 20px; font-weight: 700; color: #fff; text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .logo-icon { width: 30px; height: 30px; background: #f90; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; }

        /* Ana Taşıyıcı */
        .main-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* Sol Taraf: Uçak ve Koltuklar */
        .selection-area {
            flex: 2;
            min-width: 300px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(5,16,58,.05);
            overflow: hidden;
            border: 1px solid #edf0fa;
        }

        /* Uçak Başlığı */
        .header {
            background: linear-gradient(135deg, #0a1628 0%, #1a3a6b 100%);
            color: #fff;
            padding: 2rem;
            text-align: center;
        }
        .header h1 { font-size: 24px; font-weight: 800; margin: 10px 0 5px; }
        .header p { color: rgba(255,255,255,.7); font-size: 14px; }

        /* Uçak Gövdesi Tasarımı */
        .cabin-layout { padding: 3rem 1rem; display: flex; justify-content: center; }
        .fuselage {
            background: #fff;
            border: 3px solid #eef0f7;
            border-radius: 50% 50% 10px 10px / 15% 15% 0 0; /* Uçak burnu efekti */
            padding: 3rem 2rem 2rem;
            box-shadow: inset 0 0 20px rgba(0,0,0,.02);
        }

        /* Koltuk Planı  */
        .seating-plan {
            display: grid;
            gap: 12px;
            
        }

        /* Sağ Taraf: Özet Ekranı */
        .summary-area {
            flex: 1;
            min-width: 280px;
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(5,16,58,.05);
            border: 1px solid #edf0fa;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }
        .summary-area h2 { font-size: 18px; font-weight: 800; color: #0a1628; margin-bottom: 1rem; border-bottom: 2px solid #eef0f7; padding-bottom: 10px;}
        .booking-summary p { font-size: 14px; color: #9199b8; font-weight: 500; }
        
        .chair-icon-corner { text-align: center; margin-top: 2rem; opacity: 0.2; }
        .chair-icon-corner img { width: 60px; filter: grayscale(100%); }

        
        .seat-btn { 
            background: #eef0f7; border: 2px solid #d1d8f0; border-radius: 8px; 
            padding: 15px; cursor: pointer; transition: 0.2s; font-weight: bold; color: #3a4168;
        }
        .seat-btn:hover { background: #d1d8f0; }
        .seat-btn.selected { background: #f90; border-color: #e08800; color: #fff; } /* Anasayfa turuncusu */
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
                <p>Kullanıcı yorumlarına göre dinamik fiyatlandırma! Zevkinize ve bütçenize göre seçin.</p>
            </header>

            <div class="cabin-layout">
                <div class="fuselage">
                    <div class="seating-plan" id="seatingPlan"></div>
                </div>
            </div>
        </div>

        <div class="summary-area" <button id="satinAlBtn" class="fl-btn" style="display: none; width: 100%; margin-top: 15px; background: #f90; font-size: 16px; text-align: center;">Bileti Satın Al ✈️</button>>
            <h2>Uçuş Özeti</h2>
            <div id="bookingSummary" class="booking-summary">
                <p>Henüz bir koltuk seçmediniz.</p>
            </div>
            <div class="chair-icon-corner">
                <img src="https://img.icons8.com/ios/100/000000/armchair.png" alt="koltuk ikonu">
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>