<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UçuşBul — En Uygun Uçak Bileti</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; } 
    :root {
      --navy: #05103a; --blue: #1340c8; --orange: #ff6b00; --white: #ffffff;
      --gray-50: #f7f8fc; --text: #141b3c;
    } 
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--text); } 

    /* NAV */
    nav { background: var(--navy); padding: 1.25rem 3.5rem; display: flex; justify-content: space-between; align-items: center; }
    .logo { color: var(--white); text-decoration: none; font-size: 20px; font-weight: 800; }

    /* HERO */
    .hero {
      background: linear-gradient(160deg, #040e2e 0%, #0b2060 100%);
      padding: 5rem 1.5rem; text-align: center; color: white;
    }
    .hero-title { font-size: 42px; margin-bottom: 2rem; }
    .hero-title span { color: var(--orange); }

    /* ARAMA KARTI (ESKİ SİTEN) */
    .search-card {
      background: var(--white); border-radius: 24px; padding: 2rem;
      max-width: 900px; margin: -40px auto 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }
    .form-row { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 15px; align-items: end; }
    .form-control { width: 100%; padding: 12px; border: 1.5px solid #e2e6f0; border-radius: 12px; }
    .search-btn { background: var(--orange); color: white; border: none; padding: 12px 25px; border-radius: 12px; cursor: pointer; font-weight: 700; }

    /* ANKET BÖLÜMÜ (YENİ EKLEDİĞİMİZ) */
    .anket-section { padding: 3rem 1.5rem; }
    .anket-card {
      max-width: 600px; margin: 0 auto; background: var(--white);
      padding: 2.5rem; border-radius: 24px; border: 3px solid var(--orange);
    }
    .anket-title { font-size: 22px; font-weight: 800; margin-bottom: 1.5rem; text-align: center; color: var(--navy); }
    .submit-btn { width: 100%; background: var(--orange); color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 800; cursor: pointer; margin-top: 10px; }

    footer { background: var(--navy); color: rgba(255,255,255,0.6); padding: 2rem; text-align: center; }
  </style>
</head>
<body>

<nav>
  <a class="logo" href="#">✈ UçuşBul</a>
</nav>

<section class="hero">
  <h1 class="hero-title">En Uygun Uçuş <span>Fiyatlarını Bul</span></h1>
</section>

<div class="search-card">
  <form method="GET" action="index.php">
    <div class="form-row">
      <div><label style="font-size:12px; font-weight:700;">Kalkış</label><select class="form-control"><option>İstanbul</option></select></div>
      <div><label style="font-size:12px; font-weight:700;">Varış</label><select class="form-control"><option>Antalya</option></select></div>
      <div><label style="font-size:12px; font-weight:700;">Tarih</label><input type="date" class="form-control"></div>
      <button type="submit" class="search-btn">Uçuş Ara</button>
    </div>
  </form>
</div>

<section class="anket-section">
  <div class="anket-card">
    <div class="anket-title">✈ Deneyiminizi Puanlayın</div>
    <form action="anket_kaydet.php" method="POST">
      <input type="hidden" name="ucus_id" value="1">
      <div style="margin-bottom:15px;">
        <label style="display:block; font-weight:700; margin-bottom:5px;">Puanınız</label>
        <select name="puan" class="form-control" required>
          <option value="5">⭐⭐⭐⭐⭐ Mükemmel</option>
          <option value="4">⭐⭐⭐⭐ Çok İyi</option>
          <option value="3">⭐⭐⭐ Orta</option>
          <option value="2">⭐⭐ Kötü</option>
          <option value="1">⭐ Çok Kötü</option>
        </select>
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block; font-weight:700; margin-bottom:5px;">Yorumunuz</label>
        <textarea name="yorum" class="form-control" rows="3" placeholder="Görüşlerinizi yazın..."></textarea>
      </div>
      <button type="submit" class="submit-btn">Değerlendirmeyi Gönder 🚀</button>
    </form>
  </div>
</section>

<footer>
  <div>&copy; 2026 UçuşBul — Tüm hakları saklıdır.</div>
</footer>

</body>
</html>