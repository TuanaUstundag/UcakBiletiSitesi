<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UçuşBul — En Uygun Uçak Bileti</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
    :root {
      --navy:     #05103a;
      --blue:     #1340c8;
      --sky:      #2f82ff;
      --orange:   #ff6b00;
      --orange-h: #e05d00;
      --white:    #ffffff;
      --gray-50:  #f7f8fc;
      --gray-100: #eef0f7;
      --gray-400: #9199b8;
      --gray-700: #3a4168;
      --text:     #141b3c;
      --card-r:   20px;
      --shadow-lg: 0 32px 80px rgba(5,16,58,.28);
    }
 
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--gray-50);
      color: var(--text);
      min-height: 100vh;
    }
 
    /* ─── NAV ─── */
    nav {
      position: absolute; top: 0; left: 0; right: 0; z-index: 20;
      display: flex; align-items: center; justify-content: space-between;
      padding: 1.25rem 3.5rem;
    }
    .logo {
      display: flex; align-items: center; gap: 10px;
      text-decoration: none; color: var(--white);
      font-size: 20px; font-weight: 800; letter-spacing: -.3px;
    }
    .logo-mark {
      width: 36px; height: 36px; background: var(--orange);
      border-radius: 10px; display: flex; align-items: center;
      justify-content: center; font-size: 18px;
    }
    .nav-links { display: flex; gap: 2rem; align-items: center; }
    .nav-links a {
      color: rgba(255,255,255,.72); font-size: 14px; font-weight: 500;
      text-decoration: none; transition: color .2s;
    }
    .nav-links a:hover { color: var(--white); }
    .nav-cta {
      background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.25); color: var(--white) !important;
      padding: 8px 20px; border-radius: 8px; font-weight: 600 !important;
      transition: background .2s !important;
    }
    .nav-cta:hover { background: rgba(255,255,255,.25) !important; color: var(--white) !important; }
 
    /* ─── HERO ─── */
    .hero {
      position: relative; min-height: 620px;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 7rem 1.5rem 3rem;
      overflow: hidden;
      background: linear-gradient(160deg, #040e2e 0%, #0b2060 40%, #0d3a8a 70%, #0e4bb5 100%);
    }
 
    /* Animated background dots / lines */
    .hero-canvas {
      position: absolute; inset: 0; overflow: hidden; pointer-events: none;
    }
    .hero-canvas::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 20% 30%, rgba(47,130,255,.18) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255,107,0,.12) 0%, transparent 45%),
        radial-gradient(circle at 55% 10%, rgba(255,255,255,.06) 0%, transparent 35%);
    }
    /* grid lines */
    .hero-canvas::after {
      content: '';
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: 60px 60px;
    }
 
    /* Floating plane animation */
    .plane-anim {
      position: absolute;
      font-size: 28px;
      opacity: .15;
      animation: flyAcross 18s linear infinite;
    }
    .plane-anim:nth-child(1) { top: 22%; animation-delay: 0s; }
    .plane-anim:nth-child(2) { top: 55%; animation-delay: -7s; font-size: 20px; opacity: .08; }
    .plane-anim:nth-child(3) { top: 78%; animation-delay: -13s; font-size: 16px; opacity: .06; }
    @keyframes flyAcross {
      from { left: -80px; }
      to   { left: calc(100% + 80px); }
    }
 
    /* Floating orbs */
    .orb {
      position: absolute; border-radius: 50%; pointer-events: none;
      animation: pulse 8s ease-in-out infinite;
    }
    .orb-1 {
      width: 420px; height: 420px;
      background: radial-gradient(circle, rgba(47,130,255,.14) 0%, transparent 70%);
      top: -100px; right: -80px; animation-delay: -2s;
    }
    .orb-2 {
      width: 300px; height: 300px;
      background: radial-gradient(circle, rgba(255,107,0,.10) 0%, transparent 70%);
      bottom: 20px; left: -60px; animation-delay: -5s;
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.08); opacity: .7; }
    }
 
    .hero-content { position: relative; z-index: 5; text-align: center; width: 100%; max-width: 900px; }
 
    .hero-eyebrow {
      display: inline-flex; align-items: center; gap: 7px;
      background: rgba(255,255,255,.1); backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,.18);
      border-radius: 100px; padding: 5px 16px;
      font-size: 12px; font-weight: 600; color: rgba(255,255,255,.85);
      letter-spacing: .6px; text-transform: uppercase; margin-bottom: 1.25rem;
      animation: fadeDown .6s ease both;
    }
    .eyebrow-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--orange); animation: blink 1.8s ease infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
 
    .hero-title {
      color: var(--white); font-size: clamp(30px, 5vw, 52px);
      font-weight: 800; line-height: 1.1; letter-spacing: -1.5px;
      margin-bottom: .75rem;
      animation: fadeDown .7s .1s ease both;
    }
    .hero-title span { color: var(--orange); }
 
    .hero-sub {
      color: rgba(255,255,255,.58); font-size: 15px; font-weight: 400;
      margin-bottom: 2.25rem;
      animation: fadeDown .7s .2s ease both;
    }
 
    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
 
    /* ─── SEARCH CARD ─── */
    .search-card {
      background: var(--white); border-radius: 24px;
      padding: 2rem 2rem 1.75rem;
      width: 100%; max-width: 900px;
      box-shadow: var(--shadow-lg);
      position: relative; z-index: 5;
      animation: fadeUp .7s .3s ease both;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }
 
    /* Tab row */
    .trip-tabs {
      display: flex; gap: 3px; margin-bottom: 1.5rem;
      background: var(--gray-100); border-radius: 10px; padding: 4px;
      width: fit-content;
    }
    .trip-tab {
      padding: 7px 20px; border-radius: 7px; font-size: 13px;
      border: none; cursor: pointer; font-family: inherit;
      background: transparent; color: var(--gray-400); font-weight: 600;
      transition: all .2s;
    }
    .trip-tab.active {
      background: var(--white); color: var(--text);
      box-shadow: 0 2px 8px rgba(0,0,0,.09);
    }
 
    /* Form grid */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 46px 1fr 1fr 1fr auto;
      gap: 10px; align-items: end;
    }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-label {
      font-size: 10.5px; font-weight: 700; color: var(--gray-400);
      text-transform: uppercase; letter-spacing: .7px;
    }
    .field-wrap { position: relative; }
    .field-icon {
      position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
      font-size: 15px; pointer-events: none; opacity: .4;
    }
    .form-control {
      width: 100%; padding: 12px 14px 12px 38px;
      border: 1.5px solid #e2e6f0; border-radius: 12px;
      font-size: 14px; font-family: inherit; color: var(--text);
      background: var(--gray-50); appearance: none; -webkit-appearance: none;
      cursor: pointer; transition: border-color .2s, background .2s, box-shadow .2s;
      outline: none; font-weight: 500;
    }
    .form-control:hover  { border-color: #c0c8e8; background: var(--white); }
    .form-control:focus  {
      border-color: var(--sky); background: var(--white);
      box-shadow: 0 0 0 3px rgba(47,130,255,.12);
    }
    .form-control.no-icon { padding-left: 14px; }
 
    /* Swap button */
    .swap-wrap { display: flex; align-items: flex-end; padding-bottom: 1px; }
    .swap-btn {
      width: 42px; height: 42px; border-radius: 50%;
      border: 1.5px solid #e2e6f0; background: var(--white);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: 16px; color: var(--blue);
      transition: all .2s; box-shadow: 0 2px 8px rgba(0,0,0,.06);
    }
    .swap-btn:hover { background: var(--gray-100); transform: rotate(180deg); border-color: var(--sky); }
 
    /* Search button */
    .search-btn {
      background: var(--orange); border: none; border-radius: 12px;
      color: var(--white); font-size: 14px; font-weight: 700;
      padding: 12px 26px; cursor: pointer; font-family: inherit;
      display: flex; align-items: center; gap: 8px;
      white-space: nowrap; transition: background .2s, transform .15s, box-shadow .2s;
      align-self: flex-end; letter-spacing: .2px;
      box-shadow: 0 4px 18px rgba(255,107,0,.35);
    }
    .search-btn:hover { background: var(--orange-h); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(255,107,0,.4); }
    .search-btn:active { transform: translateY(0); }
 
    /* Divider */
    .card-divider {
      height: 1px; background: var(--gray-100);
      margin: 1.25rem 0 1rem;
    }
 
    /* Popular routes */
    .popular {
      display: flex; gap: 8px; flex-wrap: wrap; align-items: center;
    }
    .pop-label { font-size: 12px; font-weight: 600; color: var(--gray-400); }
    .route-chip {
      padding: 5px 13px; border-radius: 100px;
      background: var(--gray-100); color: var(--gray-700);
      font-size: 12px; font-weight: 600; cursor: pointer;
      border: 1px solid var(--gray-100); transition: all .18s;
    }
    .route-chip:hover { background: #e2e8ff; border-color: #c2ccf0; color: var(--blue); }
 
    /* ─── STATS ─── */
    .stats {
      display: flex; gap: 0; justify-content: center;
      margin-top: 2.5rem; flex-wrap: wrap;
      animation: fadeDown .7s .5s ease both;
    }
    .stat-item {
      text-align: center; padding: 0 2.5rem;
      border-right: 1px solid rgba(255,255,255,.14);
    }
    .stat-item:last-child { border-right: none; }
    .stat-num { font-size: 22px; font-weight: 800; color: var(--white); }
    .stat-label { font-size: 11.5px; color: rgba(255,255,255,.45); margin-top: 2px; font-weight: 500; }
 
    /* ─── POPULAR CHIPS ─── */
    .popular-section { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; margin-top: 1.75rem; animation: fadeDown .7s .6s ease both; }
    .pop-chip {
      padding: 6px 16px; border-radius: 100px;
      background: rgba(255,255,255,.11); border: 1px solid rgba(255,255,255,.18);
      color: rgba(255,255,255,.8); font-size: 12px; font-weight: 600;
      cursor: pointer; backdrop-filter: blur(6px);
      transition: background .2s;
    }
    .pop-chip:hover { background: rgba(255,255,255,.2); color: var(--white); }
    .pop-chip-label { color: rgba(255,255,255,.4); font-size: 12px; font-weight: 500; }
 
    /* ─── RESULTS ─── */
    .results-section { max-width: 900px; margin: 2.5rem auto; padding: 0 1.5rem; }
    .result-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 1rem;
    }
    .result-title { font-size: 17px; font-weight: 700; color: var(--text); }
    .result-count {
      font-size: 13px; font-weight: 600;
      background: #e9f0ff; color: var(--blue);
      padding: 4px 12px; border-radius: 100px;
    }
 
    .flight-card {
      background: var(--white); border-radius: 16px;
      border: 1.5px solid #edf0fa;
      padding: 1.25rem 1.5rem; margin-bottom: 10px;
      display: flex; align-items: center; justify-content: space-between;
      transition: box-shadow .2s, border-color .2s;
    }
    .flight-card:hover {
      box-shadow: 0 8px 32px rgba(19,64,200,.1);
      border-color: #c8d4f8;
    }
    .fl-airline-badge {
      width: 40px; height: 40px; border-radius: 10px;
      background: var(--gray-100); display: flex; align-items: center;
      justify-content: center; font-size: 20px; margin-right: 1rem;
      flex-shrink: 0;
    }
    .fl-body { flex: 1; }
    .fl-route {
      font-size: 15px; font-weight: 700; color: var(--text);
      display: flex; align-items: center; gap: 8px;
    }
    .fl-arrow { color: var(--sky); font-size: 13px; }
    .fl-meta { font-size: 12px; color: var(--gray-400); margin-top: 3px; font-weight: 500; }
    .fl-badges { display: flex; gap: 5px; margin-top: 6px; flex-wrap: wrap; }
    .fl-badge {
      font-size: 11px; border-radius: 5px; padding: 2px 9px; font-weight: 600;
    }
    .badge-direct { background: #e8faf0; color: #1a7f4b; }
    .badge-cheap  { background: #fff3e0; color: #c05a00; }
 
    .fl-right { display: flex; align-items: center; gap: 1rem; }
    .fl-price-wrap { text-align: right; }
    .fl-price-label { font-size: 10.5px; color: var(--gray-400); font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
    .fl-price { font-size: 24px; font-weight: 800; color: var(--navy); letter-spacing: -1px; }
    .fl-btn {
      background: var(--blue); color: var(--white);
      border: none; border-radius: 10px; padding: 10px 20px;
      font-size: 13px; font-weight: 700; cursor: pointer;
      font-family: inherit; transition: background .2s, transform .15s;
      white-space: nowrap;
    }
    .fl-btn:hover { background: #0f33b5; transform: translateY(-1px); }
 
    /* Alert */
    .alert {
      padding: 14px 18px; border-radius: 12px;
      font-size: 14px; font-weight: 500; margin-bottom: 1rem;
    }
    .alert-danger { background: #fef2f2; color: #991b1b; border: 1.5px solid #fca5a5; }
    .alert-info   { background: #eff6ff; color: #1e40af; border: 1.5px solid #93c5fd; }
 
    /* ─── FEATURES ─── */
    .features-section {
      background: var(--white); border-top: 1px solid #edf0fa;
      padding: 4rem 2rem;
    }
    .features-inner {
      max-width: 900px; margin: 0 auto;
    }
    .section-label {
      font-size: 11px; font-weight: 700; color: var(--blue);
      text-transform: uppercase; letter-spacing: 1px;
      margin-bottom: .5rem;
    }
    .section-title {
      font-size: 26px; font-weight: 800; letter-spacing: -.5px;
      margin-bottom: 2.5rem; color: var(--navy);
    }
    .features-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
      gap: 1.25rem;
    }
    .feat-card {
      border: 1.5px solid #edf0fa; border-radius: 18px;
      padding: 1.5rem; transition: box-shadow .2s, border-color .2s;
    }
    .feat-card:hover { box-shadow: 0 8px 28px rgba(19,64,200,.09); border-color: #c8d4f8; }
    .feat-icon {
      width: 46px; height: 46px; border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; margin-bottom: 1rem;
    }
    .feat-icon.orange { background: #fff3e0; }
    .feat-icon.blue   { background: #e9f0ff; }
    .feat-icon.green  { background: #e8faf0; }
    .feat-icon.purple { background: #f3e9ff; }
    .feat-title { font-size: 14px; font-weight: 700; margin-bottom: 5px; color: var(--navy); }
    .feat-desc  { font-size: 12.5px; color: var(--gray-400); line-height: 1.6; font-weight: 500; }
 
    /* ─── FOOTER ─── */
    footer {
      background: var(--navy); color: rgba(255,255,255,.4);
      padding: 2rem 3rem; font-size: 13px; font-weight: 500;
      display: flex; justify-content: space-between; align-items: center;
      flex-wrap: wrap; gap: 1rem;
    }
    footer a { color: rgba(255,255,255,.4); text-decoration: none; }
    footer a:hover { color: rgba(255,255,255,.7); }
    .footer-links { display: flex; gap: 2rem; }
 
    /* ─── RESPONSIVE ─── */
    @media (max-width: 720px) {
      nav { padding: 1rem 1.25rem; }
      .nav-links { display: none; }
      .hero { padding: 6rem 1rem 2.5rem; min-height: 520px; }
      .search-card { padding: 1.25rem; border-radius: 18px; }
      .form-row { grid-template-columns: 1fr; gap: 10px; }
      .swap-wrap { display: none; }
      .stat-item { padding: 0 1.25rem; }
      .features-grid { grid-template-columns: 1fr 1fr; }
      footer { flex-direction: column; text-align: center; padding: 1.5rem; }
    }
  </style>
</head>
<body>
 
<!-- ──────────── HERO ──────────── -->
<section class="hero">
  <!-- Animated background -->
  <div class="hero-canvas">
    <span class="plane-anim">✈</span>
    <span class="plane-anim">✈</span>
    <span class="plane-anim">✈</span>
  </div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
 
  <!-- Nav -->
  <nav>
    <a class="logo" href="#">
      <div class="logo-mark">✈</div>
      UçuşBul
    </a>
    <div class="nav-links">
      <a href="#">Uçuşlar</a>
      <a href="#">Oteller</a>
      <a href="#">Araç Kiralama</a>
      <a href="#" class="nav-cta">Giriş Yap</a>
    </div>
  </nav>
 
  <!-- Hero content -->
  <div class="hero-content">
    <div class="hero-eyebrow">
      <span class="eyebrow-dot"></span>
      Anlık fiyat karşılaştırma
    </div>
    <h1 class="hero-title">
      En Uygun Uçuş<br>
      <span>Fiyatlarını Bul</span>
    </h1>
    <p class="hero-sub">Yüzlerce havayolunu saniyeler içinde karşılaştır</p>
 
    <!-- ── SEARCH CARD ── -->
    <div class="search-card">
      <div class="trip-tabs">
        <button class="trip-tab active">✈ Tek Yön</button>
        <button class="trip-tab">⇄ Gidiş-Dönüş</button>
        <button class="trip-tab">⊕ Çok Güzergah</button>
      </div>
 
      <form method="GET" action="index.php">
        <div class="form-row">
 
          <div class="form-group">
            <label class="form-label">Nereden</label>
            <div class="field-wrap">
              <span class="field-icon">🛫</span>
              <select name="kalkis" class="form-control" required>
                <option value="">Şehir seçin</option>
                <option value="Istanbul"  <?= ($_GET['kalkis'] ?? '') === 'Istanbul'  ? 'selected' : '' ?>>İstanbul</option>
                <option value="Ankara"    <?= ($_GET['kalkis'] ?? '') === 'Ankara'    ? 'selected' : '' ?>>Ankara</option>
                <option value="Izmir"     <?= ($_GET['kalkis'] ?? '') === 'Izmir'     ? 'selected' : '' ?>>İzmir</option>
                <option value="Antalya"   <?= ($_GET['kalkis'] ?? '') === 'Antalya'   ? 'selected' : '' ?>>Antalya</option>
                <option value="Istanbul_Antalya" <?= ($_GET['kalkis'] ?? '') === 'Istanbul_Antalya' ? 'selected' : '' ?>>İstanbul/Antalya</option>
                <option value="Trabzon"   <?= ($_GET['kalkis'] ?? '') === 'Trabzon'   ? 'selected' : '' ?>>Trabzon</option>
              </select>
            </div>
          </div>
 
          <div class="swap-wrap">
            <button type="button" class="swap-btn" onclick="swapCities()" title="Şehirleri değiştir">⇄</button>
          </div>
 
          <div class="form-group">
            <label class="form-label">Nereye</label>
            <div class="field-wrap">
              <span class="field-icon">🛬</span>
              <select name="varis" class="form-control" required>
                <option value="">Şehir seçin</option>
                <option value="Izmir"     <?= ($_GET['varis'] ?? '') === 'Izmir'     ? 'selected' : '' ?>>İzmir</option>
                <option value="Antalya"   <?= ($_GET['varis'] ?? '') === 'Antalya'   ? 'selected' : '' ?>>Antalya</option>
                <option value="Trabzon"   <?= ($_GET['varis'] ?? '') === 'Trabzon'   ? 'selected' : '' ?>>Trabzon</option>
                <option value="Istanbul"  <?= ($_GET['varis'] ?? '') === 'Istanbul'  ? 'selected' : '' ?>>İstanbul</option>
                <option value="Ankara"    <?= ($_GET['varis'] ?? '') === 'Ankara'    ? 'selected' : '' ?>>Ankara</option>
              </select>
            </div>
          </div>
 
          <div class="form-group">
            <label class="form-label">Gidiş Tarihi</label>
            <div class="field-wrap">
              <span class="field-icon">📅</span>
              <input type="date" name="tarih" class="form-control"
                     value="<?= htmlspecialchars($_GET['tarih'] ?? '') ?>" />
            </div>
          </div>
 
          <div class="form-group">
            <label class="form-label">Yolcu</label>
            <div class="field-wrap">
              <span class="field-icon">👤</span>
              <select name="yolcu" class="form-control">
                <option>1 Yetişkin</option>
                <option>2 Yetişkin</option>
                <option>3 Yetişkin</option>
                <option>1 Yetişkin, 1 Çocuk</option>
              </select>
            </div>
          </div>
 
          <button type="submit" class="search-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Uçuş Ara
          </button>
        </div>
 
        <div class="card-divider"></div>
        <div class="popular">
          <span class="pop-label">🔥 Popüler:</span>
          <span class="route-chip" onclick="setRoute('Istanbul','Antalya')">İstanbul → Antalya</span>
          <span class="route-chip" onclick="setRoute('Ankara','Istanbul')">Ankara → İstanbul</span>
          <span class="route-chip" onclick="setRoute('Istanbul','Izmir')">İstanbul → İzmir</span>
          <span class="route-chip" onclick="setRoute('Izmir','Trabzon')">İzmir → Trabzon</span>
        </div>
      </form>
    </div>
 
    <!-- Stats -->
    <div class="stats">
      <div class="stat-item"><div class="stat-num">120+</div><div class="stat-label">Havayolu</div></div>
      <div class="stat-item"><div class="stat-num">500+</div><div class="stat-label">Destinasyon</div></div>
      <div class="stat-item"><div class="stat-num">%100</div><div class="stat-label">Güvenli Ödeme</div></div>
      <div class="stat-item"><div class="stat-num">24/7</div><div class="stat-label">Destek</div></div>
    </div>
  </div>
</section>
 
<!-- ──────────── SONUÇLAR ──────────── -->
<?php
require_once 'baglanti.php';
 
$sql = "SELECT * FROM ucuslar";
$parametreler = [];
 
if (!empty($_GET['kalkis']) && !empty($_GET['varis'])) {
    $sql = "SELECT * FROM ucuslar WHERE kalkis_yeri = ? AND varis_yeri = ?";
    $parametreler = [$_GET['kalkis'], $_GET['varis']];
}
$sql .= " ORDER BY kalkis_zamani ASC";
 
$sorgu = $db->prepare($sql);
$sorgu->execute($parametreler);
$ucuslar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>
 
<div class="results-section">
<?php if (!empty($_GET['kalkis'])): ?>
  <?php if (count($ucuslar) > 0): ?>
    <div class="result-header">
      <div class="result-title">
        <?= htmlspecialchars($_GET['kalkis']) ?> → <?= htmlspecialchars($_GET['varis']) ?>
      </div>
      <span class="result-count"><?= count($ucuslar) ?> uçuş bulundu</span>
    </div>
 
    <?php foreach ($ucuslar as $i => $ucus): ?>
    <div class="flight-card">
      <div class="fl-airline-badge">✈</div>
      <div class="fl-body">
        <div class="fl-route">
          <?= htmlspecialchars($ucus['kalkis_yeri']) ?>
          <span class="fl-arrow">→</span>
          <?= htmlspecialchars($ucus['varis_yeri']) ?>
        </div>
        <div class="fl-meta">
          🕐 <?= date('d M Y · H:i', strtotime($ucus['kalkis_zamani'])) ?>
        </div>
        <div class="fl-badges">
          <span class="fl-badge badge-direct">Direkt Uçuş</span>
          <?php if ($i === 0): ?>
          <span class="fl-badge badge-cheap">En Ucuz</span>
          <?php endif; ?>
        </div>
      </div>
      <div class="fl-right">
        <div class="fl-price-wrap">
          <div class="fl-price-label">kişi başı</div>
          <div class="fl-price">
            <?= isset($ucus['fiyat']) ? number_format($ucus['fiyat'], 0, ',', '.') . ' ₺' : '—' ?>
          </div>
        </div>
        <a href="ucus.php?id=<?= $ucus['id'] ?>" class="fl-btn" style="text-decoration:none; display:inline-flex; align-items:center;">Koltuk Seç →</a>
      </div>
    </div>
    <?php endforeach; ?>
 
  <?php else: ?>
    <div class="alert alert-danger">
      ✈ Aradiğiniz kriterlere uygun uçuş bulunamadi. Farkli bir güzergah deneyin.
    </div>
  <?php endif; ?>
<?php endif; ?>
</div>
 
<!-- ──────────── ÖZELLİKLER ──────────── -->
<div class="features-section">
  <div class="features-inner">
    <div class="section-label">Neden UçuşBul?</div>
    <div class="section-title">Seyahatini kolaylaştiriyoruz</div>
    <div class="features-grid">
      <div class="feat-card">
        <div class="feat-icon orange">💰</div>
        <div class="feat-title">En Düşük Fiyat</div>
        <div class="feat-desc">Yüzlerce havayolunu anlik karşilaştiririz. Fazla ödeme yok.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon blue">⚡</div>
        <div class="feat-title">Anında Bilet</div>
        <div class="feat-desc">Saniyeler içinde bileti güvence altina al, onay beklemez.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon green">🛡️</div>
        <div class="feat-title">Güvenli Ödeme</div>
        <div class="feat-desc">SSL şifreli, 3D Secure korumali güvenli alişveriş ortami.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon purple">📱</div>
        <div class="feat-title">Mobil Bilet</div>
        <div class="feat-desc">Biniş kartini telefonuna indir. Kağit bilete gerek yok.</div>
      </div>
    </div>
  </div>
</div>
 
<!-- ──────────── FOOTER ──────────── -->
<footer>
  <div class="logo" style="color:rgba(255,255,255,.5);">
    <div class="logo-mark" style="opacity:.7;">✈</div>
    UçuşBul
  </div>
  <div class="footer-links">
    <a href="#">Gizlilik</a>
    <a href="#">Kullanım Koşulları</a>
    <a href="#">İletişim</a>
  </div>
  <div>&copy; <?= date('Y') ?> UçuşBul — Tüm hakları saklıdır.</div>
</footer>
 
<script>
function swapCities() {
  const k = document.querySelector('[name="kalkis"]');
  const v = document.querySelector('[name="varis"]');
  [k.value, v.value] = [v.value, k.value];
}
function setRoute(from, to) {
  document.querySelector('[name="kalkis"]').value = from;
  document.querySelector('[name="varis"]').value  = to;
}
document.querySelectorAll('.trip-tab').forEach(btn => {
  btn.addEventListener('click', function () {
    document.querySelectorAll('.trip-tab').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>
</body>
</html>