<?php
// Önceki sayfadan (URL'den) gelen koltuk numarasını yakalıyoruz
$secilen_koltuk = isset($_GET['koltuk']) ? $_GET['koltuk'] : 'Seçilmedi';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UçuşBul — Güvenli Ödeme</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f7f8fc; color: #141b3c; }
        
        /* Üst Menü */
        nav { background: #0a1628; padding: 1rem 2.5rem; display: flex; align-items: center; }
        .logo { font-size: 20px; font-weight: 700; color: #fff; text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .logo-icon { width: 30px; height: 30px; background: #f90; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; }

        /* Ödeme Formu Konteynerı */
        .payment-container { max-width: 650px; margin: 3rem auto; background: #fff; padding: 2.5rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(5,16,58,.05); border: 1px solid #edf0fa; }
        .payment-container h2 { color: #0a1628; margin-bottom: 1.5rem; border-bottom: 2px solid #edf0fa; padding-bottom: 10px; font-size: 22px; }
        
        /* Özet Kutusu */
        .summary-box { background: #eef0f7; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;}
        .summary-text { font-size: 15px; font-weight: 600; color: #0a1628; }
        .summary-seat { background: #f90; color: #fff; padding: 5px 15px; border-radius: 8px; font-weight: 800; font-size: 18px;}

        /* Form Elemanları */
        h3 { font-size: 16px; color: #0a1628; margin: 1.5rem 0 1rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-size: 13px; font-weight: 700; color: #3a4168; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1.5px solid #eef0f7; border-radius: 10px; font-family: inherit; font-size: 14px; background: #fafafa; transition: 0.2s;}
        .form-control:focus { outline: none; border-color: #f90; background: #fff; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        /* Satın Al Butonu */
        .pay-btn { display: block; width: 100%; background: #f90; color: #fff; border: none; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: 800; cursor: pointer; transition: 0.2s; font-family: inherit; margin-top: 1.5rem; letter-spacing: 0.5px;}
        .pay-btn:hover { background: #e08800; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,102,0,.2); }

        /* --- YENİ: EKRANIN ORTASINDA ÇIKAN BAŞARI MODALI (POP-UP) STİLLERİ --- */
        .modal-overlay {
            display: none; /* Başlangıçta gizli */
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(10, 22, 40, 0.7); /* Arkaplanı lacivert ve bulanık yapar */
            backdrop-filter: blur(4px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #fff;
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            /* Tatlı bir zıplama efektiyle açılır */
            animation: modalAcilis 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .modal-icon { font-size: 55px; margin-bottom: 1rem; }
        .modal-content h3 { color: #0a1628; font-size: 22px; margin: 10px 0; font-weight: 800; }
        .modal-content p { color: #3a4168; font-size: 15px; margin-bottom: 8px; line-height: 1.5; }
        .modal-btn {
            background: #f90; color: #fff; border: none; padding: 14px 24px;
            border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer;
            margin-top: 1.5rem; width: 100%; transition: 0.2s;
        }
        .modal-btn:hover { background: #e08800; transform: translateY(-2px); }
        
        @keyframes modalAcilis {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    <nav>
        <a class="logo" href="index.php"><div class="logo-icon">✈</div> UçuşBul</a>
    </nav>

    <div class="payment-container">
        <h2>Güvenli Ödeme Aşaması</h2>
        
        <div class="summary-box">
            <div class="summary-text">Seçtiğiniz Koltuk Numarası:</div>
            <div class="summary-seat"><?= htmlspecialchars($secilen_koltuk) ?></div>
        </div>

        <form onsubmit="odemeTamamla(event)">
            <h3>Yolcu Bilgileri</h3>
            <div class="grid-2">
                <div class="form-group">
                    <label>Adınız Soyadınız</label>
                    <input type="text" class="form-control" placeholder="Örn: Ali Yılmaz" required>
                </div>
                <div class="form-group">
                    <label>T.C. Kimlik No</label>
                    <input type="text" class="form-control" placeholder="11 Haneli TC Numaranız" maxlength="11" required>
                </div>
            </div>

            <h3>Kart Bilgileri</h3>
            <div class="form-group">
                <label>Kart Üzerindeki İsim</label>
                <input type="text" class="form-control" placeholder="Kart sahibinin adı" required>
            </div>
            <div class="form-group">
                <label>Kart Numarası</label>
                <input type="text" class="form-control" placeholder="0000 0000 0000 0000" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label>Son Kullanma Tarihi</label>
                    <input type="text" class="form-control" placeholder="AA/YY" required>
                </div>
                <div class="form-group">
                    <label>CVV / CVC</label>
                    <input type="password" class="form-control" placeholder="***" maxlength="3" required>
                </div>
            </div>

            <button type="submit" class="pay-btn">💳 BİLETİ SATIN AL</button>
        </form>
    </div>

    <div id="successModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-icon">✅</div>
            <h3>ÖDEME BAŞARILI!</h3>
            <p>✈️ Biletiniz onaylandı ve PNR numaranız oluşturuldu.</p>
            <p>UçuşBul'u tercih ettiğiniz için teşekkür eder, iyi uçuşlar dileriz.</p>
            <button class="modal-btn" onclick="anasayfayaDon()">Harika, Ana Sayfaya Dön</button>
        </div>
    </div>

    <script>
        // Form gönderildiğinde çalışacak fonksiyon
        function odemeTamamla(event) {
            event.preventDefault(); // Sayfanın yenilenmesini engeller
            
            // tarayıcı alert'i yerine  Modal
            document.getElementById('successModal').style.display = 'flex';
        }

        // Modaldaki butona tıklayınca çalışacak fonksiyon
        function anasayfayaDon() {
            window.location.href = 'index.php';
        }
    </script>

</body>
</html>