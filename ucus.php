<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UçuşBul — En Uygun Uçak Bileti</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; color: #1a1a1a; }

    /* ── NAV ── */
    nav {
      position: absolute; top: 0; left: 0; right: 0; z-index: 10;
      display: flex; align-items: center; justify-content: space-between;
      padding: 1.1rem 2.5rem;
    }
    .logo { font-size: 22px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .logo-icon { width: 34px; height: 34px; background: #f90; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .nav-links { display: flex; gap: 1.75rem; }
    .nav-links a { color: rgba(255,255,255,0.75); font-size: 14px; text-decoration: none; transition: color .2s; }
    .nav-links a:hover { color: #fff; }

    /* ── HERO ── */
    .hero {
      background: linear-gradient(135deg, #0a1628 0%, #1a3a6b 55%, #0d2144 100%);
      min-height: 540px; position: relative;
      display: flex; flex-direction: column; align-items: center;
      justify-content: center; padding: 5rem 1rem 3.5rem; overflow: hidden;
    }
    .hero::before {
      content: ''; position: absolute; width: 500px; height: 500px;
      border-radius: 50%; background: rgba(255,255,255,.04);
      top: -120px; right: -120px; pointer-events: none;
    }
    .hero::after {
      content: ''; position: absolute; width: 300px; height: 300px;
      border-radius: 50%; background: rgba(255,255,255,.03);
      bottom: -60px; left: -60px; pointer-events: none;
    }
    .hero-title { color: #fff; font-size: 38px; font-weight: 700; text-align: center; margin-bottom: .5rem; letter-spacing: -.5px; }
    .hero-sub   { color: rgba(255,255,255,.6); font-size: 15px; text-align: center; margin-bottom: 2rem; }

    /* ── ARAMA KARTI ── */
    .search-card {
      background: #fff; border-radius: 18px; padding: 1.75rem;
      width: 100%; max-width: 860px; position: relative; z-index: 5;
      box-shadow: 0 24px 80px rgba(0,0,0,.35);
    }
    .trip-tabs { display: flex; gap: 4px; margin-bottom: 1.25rem; }
    .trip-tab {
      padding: 6px 18px; border-radius: 20px; font-size: 13px;
      border: none; cursor: pointer; font-family: inherit;
      background: transparent; color: #666; transition: all .2s;
    }
    .trip-tab.active { background: #0a1628; color: #fff; font-weight: 600; }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 42px 1fr 1fr 1fr auto;
      gap: 10px; align-items: end;
    }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-label { font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: .6px; }
    .form-control {
      width: 100%; padding: 11px 14px;
      border: 1.5px solid #e8e8e8; border-radius: 10px;
      font-size: 15px; font-family: inherit; color: #1a1a1a;
      background: #fafafa; appearance: none; -webkit-appearance: none;
      cursor: pointer; transition: border-color .2s, background .2s; outline: none;
    }
    .form-control:hover { border-color: #bbb; background: #fff; }
    .form-control:focus { border-color: #1a3a6b; background: #fff; box-shadow: 0 0 0 3px rgba(26,58,107,.1); }
    .swap-btn {
      width: 38px; height: 38px; border-radius: 50%;
      border: 1.5px solid #e0e0e0; background: #fff;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: 15px; align-self: flex-end;
      transition: all .2s;
    }
    .swap-btn:hover { background: #f0f0f0; }
    .search-btn {
      background: #f90; border: none; border-radius: 10px;
      color: #fff; font-size: 15px; font-weight: 700;
      padding: 12px 26px; cursor: pointer; font-family: inherit;
      display: flex; align-items: center; gap: 8px;
      white-space: nowrap; transition: background .2s; align-self: flex-end;
    }
    .search-btn:hover { background: #e08800; }

    /* ── POPÜLER ROTALAR ── */
    .popular { margin-top: 1rem; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .pop-label { color: rgba(255,255,255,.5); font-size: 12px; }
    .route-chip {
      padding: 5px 14px; border-radius: 20px;
      background: rgba(255,255,255,.12); color: rgba(255,255,255,.85);
      font-size: 12px; cursor: pointer;
      border: 1px solid rgba(255,255,255,.18); transition: all .2s;
    }
    .route-chip:hover { background: rgba(255,255,255,.22); }

    /* ── STATS ── */
    .stats { display: flex; gap: 2.5rem; justify-content: center; margin-top: 2.25rem; flex-wrap: wrap; }
    .stat-num   { font-size: 21px; font-weight: 700; color: #fff; }
    .stat-label { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 2px; }

    /* ── SONUÇLAR ── */
    .results-section { max-width: 860px; margin: 2rem auto; padding: 0 1rem; }
    .result-title { font-size: 17px; font-weight: 700; margin-bottom: 1rem; color: #1a1a1a; }
    .flight-card {
      background: #fff; border-radius: 14px; border: 1px solid #eee;
      padding: 1.25rem 1.5rem; margin-bottom: 12px;
      display: flex; align-items: center; justify-content: space-between;
      transition: box-shadow .2s;
    }
    .flight-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.1); }
    .fl-route { font-size: 15px; font-weight: 700; }
    .fl-meta  { font-size: 12px; color: #888; margin-top: 3px; }
    .fl-price { font-size: 22px; font-weight: 700; color: #0a1628; }
    .fl-btn {
      margin-left: 1rem; background: #0a1628; color: #fff;
      border: none; border-radius: 8px; padding: 8px 18px;
      font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit;
      transition: background .2s;
    }
    .fl-btn:hover { background: #1a3a6b; }
    .fl-badge {
      font-size: 11px; background: #fff3cd; color: #856404;
      border-radius: 4px; padding: 2px 8px; font-weight: 600;
      display: inline-block; margin-top: 4px;
    }

    /* ── ALERT ── */
    .alert { padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 1rem; }
    .alert-danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
    .alert-info    { background: #eff6ff; color: #1e40af; border: 1px solid #93c5fd; }

    /* ── FEATURES ── */
    .features { background: #f8f9fb; padding: 3rem 2rem; display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; }
    .feat-card {
      background: #fff; border-radius: 14px; border: 1px solid #eee;
      padding: 1.5rem; max-width: 210px; text-align: center;
    }
    .feat-icon  { font-size: 30px; margin-bottom: .6rem; }
    .feat-title { font-size: 14px; font-weight: 700; margin-bottom: 5px; }
    .feat-desc  { font-size: 12px; color: #888; line-height: 1.6; }

    /* ── FOOTER ── */
    footer { background: #0a1628; color: rgba(255,255,255,.5); text-align: center; padding: 1.5rem; font-size: 13px; }

    @media (max-width: 700px) {
      .form-row { grid-template-columns: 1fr; }
      .swap-btn { display: none; }
      .hero-title { font-size: 26px; }
      .nav-links { display: none; }
    }
  </style>
</head>
<body>

<!-- ──────────────── HERO ──────────────── -->
<section class="hero">
  <nav>
    <a class="logo" href="#"><div class="logo-icon">✈</div> UçuşBul</a>
    <div class="nav-links">
      <a href="#">Uçuşlar</a>
      <a href="#">Oteller</a>
      <a href="#">Araç Kiralama</a>
      <a href="#">İletişim</a>
    </div>
  </nav>

  <h1 class="hero-title">En Uygun Uçuş Fiyatları</h1>
  <p class="hero-sub">Yüzlerce havayolunu karşılaştır, en ucuz bileti bul</p>

  <!-- ── ARAMA FORMU (GET → index.php) ── -->
  <div class="search-card">
    <div class="trip-tabs">
      <button class="trip-tab active">Tek Yön</button>
      <button class="trip-tab">Gidiş-Dönüş</button>
      <button class="trip-tab">Çok Güzergahlı</button>
    </div>

    <form method="GET" action="index.php">
      <div class="form-row">

        <div class="form-group">
          <label class="form-label">Nereden</label>
          <select name="kalkis" class="form-control" required>
            <option value="">— Seçiniz —</option>
            <option value="Istanbul"  <?= ($_GET['kalkis'] ?? '') === 'Istanbul'  ? 'selected' : '' ?>>İstanbul</option>
            <option value="Ankara"    <?= ($_GET['kalkis'] ?? '') === 'Ankara'    ? 'selected' : '' ?>>Ankara</option>
            <option value="Izmir"     <?= ($_GET['kalkis'] ?? '') === 'Izmir'     ? 'selected' : '' ?>>İzmir</option>
            <option value="Antalya"   <?= ($_GET['kalkis'] ?? '') === 'Antalya'   ? 'selected' : '' ?>>Antalya</option>
            <option value="Istanbul_Antalya" <?= ($_GET['kalkis'] ?? '') === 'Istanbul_Antalya' ? 'selected' : '' ?>>İstanbul/Antalya</option>
            <option value="Trabzon"   <?= ($_GET['kalkis'] ?? '') === 'Trabzon'   ? 'selected' : '' ?>>Trabzon</option>
          </select>
        </div>

        <div style="display:flex;align-items:flex-end;padding-bottom:1px;">
          <button type="button" class="swap-btn" onclick="swapCities()" title="Şehirleri değiştir">⇄</button>
        </div>

        <div class="form-group">
          <label class="form-label">Nereye</label>
          <select name="varis" class="form-control" required>
            <option value="">— Seçiniz —</option>
            <option value="Izmir"     <?= ($_GET['varis'] ?? '') === 'Izmir'     ? 'selected' : '' ?>>İzmir</option>
            <option value="Antalya"   <?= ($_GET['varis'] ?? '') === 'Antalya'   ? 'selected' : '' ?>>Antalya</option>
            <option value="Trabzon"   <?= ($_GET['varis'] ?? '') === 'Trabzon'   ? 'selected' : '' ?>>Trabzon</option>
            <option value="Istanbul"  <?= ($_GET['varis'] ?? '') === 'Istanbul'  ? 'selected' : '' ?>>İstanbul</option>
            <option value="Ankara"    <?= ($_GET['varis'] ?? '') === 'Ankara'    ? 'selected' : '' ?>>Ankara</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Gidiş Tarihi</label>
          <input type="date" name="tarih" class="form-control"
                 value="<?= htmlspecialchars($_GET['tarih'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label class="form-label">Yolcu</label>
          <select name="yolcu" class="form-control">
            <option>1 Yetişkin</option>
            <option>2 Yetişkin</option>
            <option>3 Yetişkin</option>
            <option>1 Yetişkin, 1 Çocuk</option>
          </select>
        </div>

        <button type="submit" class="search-btn">🔍 Uçuş Ara</button>
      </div>
    </form>
  </div>

  <!-- Popüler rotalar -->
  <div class="popular">
    <span class="pop-label">Popüler:</span>
    <span class="route-chip" onclick="setRoute('Istanbul','Antalya')">İstanbul → Antalya</span>
    <span class="route-chip" onclick="setRoute('Ankara','Istanbul')">Ankara → İstanbul</span>
    <span class="route-chip" onclick="setRoute('Istanbul','Izmir')">İstanbul → İzmir</span>
    <span class="route-chip" onclick="setRoute('Izmir','Trabzon')">İzmir → Trabzon</span>
  </div>

  <div class="stats">
    <div class="stat"><div class="stat-num">120+</div><div class="stat-label">Havayolu</div></div>
    <div class="stat"><div class="stat-num">500+</div><div class="stat-label">Destinasyon</div></div>
    <div class="stat"><div class="stat-num">%100</div><div class="stat-label">Güvenli Ödeme</div></div>
    <div class="stat"><div class="stat-num">24/7</div><div class="stat-label">Destek</div></div>
  </div>
</section>

<!-- ──────────────── SONUÇLAR (PHP) ──────────────── -->
<?php
require_once 'baglanti.php';

$sql        = "SELECT * FROM ucuslar";
$parametreler = [];

if (isset($_GET['kalkis']) && isset($_GET['varis'])
    && $_GET['kalkis'] !== '' && $_GET['varis'] !== '') {

    $sql        = "SELECT * FROM ucuslar WHERE kalkis_yeri = ? AND varis_yeri = ?";
    $parametreler = [$_GET['kalkis'], $_GET['varis']];
}

$sql .= " ORDER BY kalkis_zamani ASC";

$sorgu  = $db->prepare($sql);
$sorgu->execute($parametreler);
$ucuslar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="results-section">
<?php if (isset($_GET['kalkis']) && $_GET['kalkis'] !== ''): ?>

  <?php if (count($ucuslar) > 0): ?>
    <div class="result-title">
      <?= htmlspecialchars($_GET['kalkis']) ?> → <?= htmlspecialchars($_GET['varis']) ?>
      güzergahında <?= count($ucuslar) ?> uçuş bulundu
    </div>

    <?php foreach ($ucuslar as $ucus): ?>
    <div class="flight-card">
      <div>
        <div class="fl-route">
          ✈ <?= htmlspecialchars($ucus['kalkis_yeri']) ?>
          &rarr;
          <?= htmlspecialchars($ucus['varis_yeri']) ?>
        </div>
        <div class="fl-meta">
          <?= date('d M Y H:i', strtotime($ucus['kalkis_zamani'])) ?>
        </div>
        <span class="fl-badge">Direkt Uçuş</span>
      </div>
      <div style="display:flex;align-items:center;gap:.75rem;">
        <div class="fl-price">
          <?= isset($ucus['fiyat']) ? number_format($ucus['fiyat'], 0, ',', '.') . ' ₺' : '' ?>
        </div>
        <button class="fl-btn">Koltuk Seç</button>
      </div>
    </div>
    <?php endforeach; ?>

  <?php else: ?>
    <div class="alert alert-danger">
      ✈ Aradığınız kriterlere uygun uçuş bulunamadı.
    </div>
  <?php endif; ?>

<?php endif; ?>
</div>

<!-- ──────────────── ÖZELLİKLER ──────────────── -->
<div class="features">
  <div class="feat-card">
    <div class="feat-icon">💰</div>
    <div class="feat-title">En Düşük Fiyat</div>
    <div class="feat-desc">Yüzlerce havayolunu anlık karşılaştırırız</div>
  </div>
  <div class="feat-card">
    <div class="feat-icon">⚡</div>
    <div class="feat-title">Anında Bilet</div>
    <div class="feat-desc">Saniyeler içinde bileti güvence altına al</div>
  </div>
  <div class="feat-card">
    <div class="feat-icon">🛡️</div>
    <div class="feat-title">Güvenli Ödeme</div>
    <div class="feat-desc">SSL şifreli, 3D Secure korumalı alışveriş</div>
  </div>
  <div class="feat-card">
    <div class="feat-icon">📱</div>
    <div class="feat-title">Mobil Bilet</div>
    <div class="feat-desc">Biniş kartını telefonuna indir, kağıt yok</div>
  </div>
</div>

<footer>
  &copy; <?= date('Y') ?> UçuşBul — Tüm hakları saklıdır.
</footer>

<script>
function swapCities() {
  const k = document.querySelector('[name="kalkis"]');
  const v = document.querySelector('[name="varis"]');
  const tmp = k.value; k.value = v.value; v.value = tmp;
}
function setRoute(from, to) {
  document.querySelector('[name="kalkis"]').value = from;
  document.querySelector('[name="varis"]').value  = to;
}
document.querySelectorAll('.trip-tab').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.trip-tab').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>
</body>
</html>