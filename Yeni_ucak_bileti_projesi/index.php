<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UçuşBul — En Uygun Uçak Bileti</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy: #040e2e;
      --navy-mid: #0b1f52;
      --blue: #1a56db;
      --blue-light: #3b82f6;
      --orange: #f97316;
      --orange-dark: #ea6000;
      --white: #ffffff;
      --gray-50: #f8faff;
      --gray-100: #eef2ff;
      --gray-200: #d4daf0;
      --gray-500: #6b7280;
      --gray-700: #374151;
      --text: #111827;
      --seat-empty: #22c55e;
      --seat-occupied: #ef4444;
      --seat-selected: #f97316;
      --seat-low: #fbbf24;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--gray-50);
      color: var(--text);
      overflow-x: hidden;
    }

    /* ====== NAV ====== */
    nav {
      position: fixed; top: 0; left: 0; right: 0; z-index: 100;
      background: rgba(4, 14, 46, 0.92);
      backdrop-filter: blur(12px);
      padding: 1rem 3rem;
      display: flex; justify-content: space-between; align-items: center;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .logo {
      color: var(--white); text-decoration: none;
      font-family: 'Sora', sans-serif;
      font-size: 22px; font-weight: 800;
      display: flex; align-items: center; gap: 10px;
    }
    .logo-icon {
      width: 38px; height: 38px;
      background: var(--orange);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px;
    }
    .nav-links { display: flex; gap: 2rem; align-items: center; }
    .nav-links a { color: rgba(255,255,255,0.75); text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.2s; }
    .nav-links a:hover { color: var(--white); }
    .nav-btn {
      background: var(--orange); color: white; border: none;
      padding: 9px 22px; border-radius: 8px; font-size: 14px;
      font-weight: 600; cursor: pointer; text-decoration: none;
      transition: background 0.2s;
    }
    .nav-btn:hover { background: var(--orange-dark); }

    /* ====== HERO ====== */
    .hero {
      min-height: 100vh;
      background:
        radial-gradient(ellipse at 20% 50%, rgba(26,86,219,0.35) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 20%, rgba(249,115,22,0.2) 0%, transparent 50%),
        radial-gradient(ellipse at 60% 80%, rgba(59,130,246,0.15) 0%, transparent 50%),
        linear-gradient(160deg, #040e2e 0%, #071640 40%, #040e2e 100%);
      display: flex; align-items: center; justify-content: center;
      padding: 8rem 2rem 4rem;
      position: relative; overflow: hidden;
    }

    /* Animated clouds / atmosphere */
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 15% 85%, rgba(255,255,255,0.03) 0%, transparent 40%),
        radial-gradient(circle at 85% 15%, rgba(59,130,246,0.08) 0%, transparent 40%);
      animation: atmosphereShift 8s ease-in-out infinite alternate;
    }
    @keyframes atmosphereShift {
      from { opacity: 0.6; }
      to { opacity: 1; }
    }

    /* Flying plane */
    .plane-decoration {
      position: absolute;
      font-size: 80px;
      opacity: 0.06;
      animation: planeFly 20s linear infinite;
      top: 30%;
    }
    @keyframes planeFly {
      0% { left: -15%; transform: rotate(-5deg); }
      100% { left: 110%; transform: rotate(-5deg); }
    }

    /* Stars/dots */
    .stars {
      position: absolute; inset: 0; overflow: hidden; pointer-events: none;
    }
    .star {
      position: absolute;
      width: 2px; height: 2px;
      background: white;
      border-radius: 50%;
      animation: twinkle 3s ease-in-out infinite;
    }

    @keyframes twinkle {
      0%, 100% { opacity: 0.2; }
      50% { opacity: 0.8; }
    }

    .hero-content { text-align: center; color: white; position: relative; z-index: 2; max-width: 750px; }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(249,115,22,0.15);
      border: 1px solid rgba(249,115,22,0.3);
      color: #fb923c;
      padding: 6px 16px; border-radius: 100px;
      font-size: 13px; font-weight: 600; margin-bottom: 1.5rem;
    }
    .hero h1 {
      font-family: 'Sora', sans-serif;
      font-size: clamp(36px, 6vw, 64px);
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 1.5rem;
    }
    .hero h1 span { color: var(--orange); }
    .hero p {
      font-size: 18px;
      color: rgba(255,255,255,0.65);
      line-height: 1.7;
      margin-bottom: 3rem;
      max-width: 520px;
      margin-left: auto; margin-right: auto;
    }

    /* Stats */
    .hero-stats {
      display: flex; gap: 3rem; justify-content: center;
      margin-top: 2.5rem;
    }
    .stat-item { text-align: center; }
    .stat-num {
      font-family: 'Sora', sans-serif;
      font-size: 28px; font-weight: 800; color: var(--orange);
    }
    .stat-lbl { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 2px; }

    /* ====== SEARCH CARD ====== */
    .search-wrap {
      max-width: 920px; margin: -70px auto 0;
      padding: 0 1.5rem;
      position: relative; z-index: 10;
    }
    .search-card {
      background: white;
      border-radius: 20px;
      padding: 2rem 2.5rem;
      box-shadow: 0 25px 80px rgba(4,14,46,0.2), 0 2px 20px rgba(0,0,0,0.08);
      border: 1px solid rgba(255,255,255,0.8);
    }
    .search-tabs {
      display: flex; gap: 0.5rem; margin-bottom: 1.5rem;
    }
    .search-tab {
      padding: 8px 18px; border-radius: 8px; font-size: 14px;
      font-weight: 600; cursor: pointer; border: none;
      background: var(--gray-100); color: var(--gray-500);
      transition: all 0.2s;
    }
    .search-tab.active { background: var(--navy); color: white; }
    .search-row {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr auto;
      gap: 12px; align-items: end;
    }
    .search-field label {
      display: block; font-size: 11px; font-weight: 700;
      color: var(--gray-500); letter-spacing: 0.8px;
      text-transform: uppercase; margin-bottom: 6px;
    }
    .search-field select,
    .search-field input {
      width: 100%; padding: 12px 14px;
      border: 1.5px solid var(--gray-200);
      border-radius: 10px; font-size: 15px;
      font-family: 'DM Sans', sans-serif;
      background: var(--gray-50);
      color: var(--text);
      transition: border 0.2s;
      appearance: none;
    }
    .search-field select:focus,
    .search-field input:focus {
      outline: none; border-color: var(--blue);
      background: white;
    }
    .search-btn-main {
      background: var(--orange);
      color: white; border: none;
      padding: 13px 28px;
      border-radius: 10px; font-size: 15px;
      font-weight: 700; cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: all 0.2s;
      white-space: nowrap;
    }
    .search-btn-main:hover { background: var(--orange-dark); transform: translateY(-1px); }

    /* ====== SECTIONS ====== */
    .section { padding: 5rem 1.5rem; }
    .container { max-width: 1100px; margin: 0 auto; }
    .section-title {
      font-family: 'Sora', sans-serif;
      font-size: 36px; font-weight: 800;
      color: var(--navy); margin-bottom: 0.5rem;
    }
    .section-sub { color: var(--gray-500); font-size: 16px; margin-bottom: 3rem; }

    /* ====== FLIGHTS LIST ====== */
    .flights-section { background: var(--gray-50); }
    .flight-grid { display: grid; gap: 16px; }
    .flight-card {
      background: white; border-radius: 16px;
      padding: 1.5rem 2rem;
      border: 1.5px solid var(--gray-200);
      display: grid;
      grid-template-columns: 1fr auto 1fr auto auto;
      gap: 2rem; align-items: center;
      transition: all 0.25s;
      cursor: pointer;
    }
    .flight-card:hover {
      border-color: var(--blue);
      box-shadow: 0 8px 30px rgba(26,86,219,0.12);
      transform: translateY(-2px);
    }
    .flight-city { font-size: 13px; color: var(--gray-500); margin-bottom: 4px; }
    .flight-code { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--navy); }
    .flight-time { font-size: 14px; color: var(--gray-500); margin-top: 4px; }
    .flight-mid { text-align: center; }
    .flight-duration {
      font-size: 12px; color: var(--gray-500);
      margin-bottom: 6px;
    }
    .flight-line {
      display: flex; align-items: center; gap: 6px;
      color: var(--blue-light);
    }
    .flight-line-bar {
      height: 2px; background: var(--gray-200);
      flex: 1; position: relative;
    }
    .flight-line-bar::after {
      content: '✈';
      position: absolute; top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      font-size: 14px; color: var(--orange);
      background: white; padding: 0 4px;
    }
    .flight-price {
      text-align: right;
    }
    .price-from { font-size: 12px; color: var(--gray-500); }
    .price-amount {
      font-family: 'Sora', sans-serif;
      font-size: 28px; font-weight: 800; color: var(--orange);
    }
    .price-pp { font-size: 12px; color: var(--gray-500); }
    .select-btn {
      background: var(--navy); color: white;
      border: none; padding: 12px 22px;
      border-radius: 10px; font-size: 14px;
      font-weight: 600; cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s;
    }
    .select-btn:hover { background: var(--navy-mid); }
    .badge-popular {
      background: rgba(249,115,22,0.1); color: var(--orange);
      border: 1px solid rgba(249,115,22,0.3);
      font-size: 11px; font-weight: 700;
      padding: 3px 10px; border-radius: 100px;
      display: inline-block; margin-bottom: 8px;
    }

    /* ====== SEAT SELECTION (MODAL-STYLE) ====== */
    .overlay {
      display: none;
      position: fixed; inset: 0; z-index: 200;
      background: rgba(4,14,46,0.85);
      backdrop-filter: blur(6px);
      align-items: center; justify-content: center;
      padding: 1.5rem;
    }
    .overlay.open { display: flex; }
    .modal {
      background: white; border-radius: 24px;
      max-width: 960px; width: 100%;
      max-height: 90vh; overflow-y: auto;
      padding: 2.5rem;
      animation: modalIn 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.2) forwards;
    }
    @keyframes modalIn {
      from { opacity: 0; transform: scale(0.9) translateY(20px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .modal-header {
      display: flex; justify-content: space-between; align-items: flex-start;
      margin-bottom: 2rem;
    }
    .modal-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: var(--navy); }
    .modal-subtitle { color: var(--gray-500); font-size: 14px; margin-top: 4px; }
    .close-btn {
      background: var(--gray-100); border: none;
      width: 36px; height: 36px; border-radius: 50%;
      font-size: 18px; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s;
    }
    .close-btn:hover { background: var(--gray-200); }

    .seat-layout-wrap { display: flex; gap: 2rem; }

    /* Legend */
    .seat-legend {
      display: flex; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;
    }
    .legend-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-700); }
    .legend-dot { width: 16px; height: 16px; border-radius: 4px; }
    .leg-empty { background: #dcfce7; border: 2px solid var(--seat-empty); }
    .leg-occ { background: #fee2e2; border: 2px solid var(--seat-occupied); }
    .leg-sel { background: #fed7aa; border: 2px solid var(--seat-selected); }
    .leg-low { background: #fef3c7; border: 2px solid var(--seat-low); }

    /* Cabin */
    .cabin-outer {
      flex: 1;
      background: linear-gradient(180deg, #e8ecf8 0%, #f0f3fa 100%);
      border-radius: 20px; padding: 2rem 1.5rem;
      position: relative;
    }
    .cabin-nose {
      text-align: center; margin-bottom: 1.5rem;
      font-size: 13px; color: var(--gray-500); font-weight: 600;
    }
    .cabin-nose::before {
      content: '✈';
      display: block; font-size: 32px;
      color: var(--navy); margin-bottom: 6px;
    }
    .seating-plan {
      display: grid;
      grid-template-columns: 55px 55px 40px 55px 55px;
      gap: 10px;
      justify-content: center;
    }
    .seat {
      width: 50px; height: 62px;
      border-radius: 10px;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      font-size: 11px; font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
      border: 2px solid transparent;
    }
    .seat.empty {
      background: #dcfce7;
      border-color: var(--seat-empty);
      color: #15803d;
    }
    .seat.occupied {
      background: #fee2e2;
      border-color: var(--seat-occupied);
      color: #b91c1c;
      cursor: not-allowed;
    }
    .seat.low-rated {
      background: #fef3c7;
      border-color: var(--seat-low);
      color: #92400e;
    }
    .seat.selected {
      background: #fed7aa;
      border-color: var(--seat-selected);
      color: #9a3412;
      transform: scale(1.08);
      box-shadow: 0 0 16px rgba(249,115,22,0.4);
    }
    .seat:hover:not(.occupied) { transform: translateY(-2px) scale(1.05); }
    .seat.selected:hover { transform: scale(1.08); }
    .seat-num { font-size: 12px; font-weight: 700; }
    .seat-score { font-size: 10px; opacity: 0.8; margin-top: 2px; }
    .corridor { width: 40px; display: flex; align-items: center; justify-content: center; color: var(--gray-500); font-size: 11px; }

    /* Seat summary panel */
    .seat-summary {
      width: 260px; flex-shrink: 0;
    }
    .summary-box {
      background: var(--gray-50);
      border: 1.5px solid var(--gray-200);
      border-radius: 16px; padding: 1.5rem;
    }
    .summary-box h3 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 1rem; }
    .summary-item { display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 10px; }
    .summary-item .lbl { color: var(--gray-500); }
    .summary-item .val { font-weight: 600; color: var(--navy); }
    .summary-empty { text-align: center; color: var(--gray-500); font-size: 14px; padding: 1rem 0; }
    .proceed-btn {
      display: none; width: 100%;
      background: var(--orange); color: white;
      border: none; padding: 14px;
      border-radius: 12px; font-size: 16px;
      font-weight: 700; cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s;
      margin-top: 1rem;
    }
    .proceed-btn:hover { background: var(--orange-dark); }

    /* ====== PAYMENT MODAL ====== */
    .payment-modal {
      background: white; border-radius: 24px;
      max-width: 600px; width: 100%;
      padding: 2.5rem;
      animation: modalIn 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.2) forwards;
    }
    .pay-header { margin-bottom: 2rem; }
    .pay-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: var(--navy); }
    .pay-summary-strip {
      background: linear-gradient(135deg, var(--navy), var(--navy-mid));
      color: white; border-radius: 14px;
      padding: 1.25rem 1.5rem;
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 2rem;
    }
    .pss-route { font-size: 18px; font-weight: 700; }
    .pss-detail { font-size: 12px; opacity: 0.65; margin-top: 3px; }
    .pss-price { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 800; color: var(--orange); }

    .pay-section-title { font-size: 13px; font-weight: 700; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 1rem; }
    .pay-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    .pay-field { margin-bottom: 14px; }
    .pay-field label { display: block; font-size: 13px; font-weight: 600; color: var(--gray-700); margin-bottom: 6px; }
    .pay-field input {
      width: 100%; padding: 12px 14px;
      border: 1.5px solid var(--gray-200);
      border-radius: 10px; font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      background: var(--gray-50);
      transition: border 0.2s;
    }
    .pay-field input:focus { outline: none; border-color: var(--blue); background: white; }
    .card-icons { display: flex; gap: 8px; margin-bottom: 14px; }
    .card-icon {
      padding: 4px 12px; border-radius: 6px;
      font-size: 12px; font-weight: 700;
      background: var(--gray-100); color: var(--gray-700);
      border: 1.5px solid var(--gray-200);
    }
    .pay-btn-main {
      width: 100%;
      background: linear-gradient(135deg, var(--orange), #ef4444);
      color: white; border: none;
      padding: 16px; border-radius: 12px;
      font-size: 17px; font-weight: 800;
      cursor: pointer; font-family: 'DM Sans', sans-serif;
      transition: all 0.2s; margin-top: 1rem;
      letter-spacing: 0.3px;
    }
    .pay-btn-main:hover { filter: brightness(1.08); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(249,115,22,0.35); }
    .security-note {
      text-align: center; font-size: 12px;
      color: var(--gray-500); margin-top: 12px;
      display: flex; align-items: center; justify-content: center; gap: 6px;
    }

    /* ====== SUCCESS ====== */
    .success-modal {
      background: white; border-radius: 24px;
      max-width: 480px; width: 100%;
      padding: 3rem 2.5rem; text-align: center;
      animation: modalIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.2) forwards;
    }
    .success-icon {
      width: 80px; height: 80px;
      background: #dcfce7; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 36px; margin: 0 auto 1.5rem;
    }
    .success-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 800; color: var(--navy); margin-bottom: 0.75rem; }
    .success-sub { color: var(--gray-500); line-height: 1.7; margin-bottom: 1rem; }
    .pnr-box {
      background: var(--gray-100); border-radius: 12px;
      padding: 1rem; margin: 1.5rem 0;
      font-family: 'Sora', sans-serif;
      font-size: 22px; font-weight: 800;
      color: var(--navy); letter-spacing: 3px;
    }
    .pnr-label { font-size: 12px; color: var(--gray-500); font-weight: 400; letter-spacing: 0; font-family: 'DM Sans', sans-serif; margin-bottom: 4px; }
    .home-btn {
      width: 100%; background: var(--navy);
      color: white; border: none; padding: 14px;
      border-radius: 12px; font-size: 15px;
      font-weight: 700; cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s;
    }
    .home-btn:hover { background: var(--navy-mid); }

    /* ====== SURVEY ====== */
    .survey-section { background: var(--navy); color: white; }
    .survey-card {
      max-width: 640px; margin: 0 auto;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 24px; padding: 3rem;
    }
    .survey-card .section-title { color: white; }
    .survey-card .section-sub { color: rgba(255,255,255,0.55); }
    .survey-select, .survey-textarea {
      width: 100%; padding: 12px 14px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 10px; color: white;
      font-family: 'DM Sans', sans-serif; font-size: 15px;
      margin-bottom: 16px;
    }
    .survey-select option { background: var(--navy); }
    .survey-textarea { min-height: 100px; resize: vertical; }
    .survey-btn {
      width: 100%; background: var(--orange);
      color: white; border: none; padding: 14px;
      border-radius: 12px; font-size: 16px;
      font-weight: 700; cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s;
    }
    .survey-btn:hover { background: var(--orange-dark); }
    .survey-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-top: 1rem; display: none; }

    /* ====== FEATURES ====== */
    .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .feature-card {
      background: white; border-radius: 16px;
      padding: 2rem; border: 1.5px solid var(--gray-200);
      transition: all 0.25s;
    }
    .feature-card:hover { border-color: var(--blue); transform: translateY(-4px); box-shadow: 0 12px 40px rgba(26,86,219,0.1); }
    .feature-icon { font-size: 36px; margin-bottom: 1rem; }
    .feature-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; }
    .feature-desc { color: var(--gray-500); font-size: 14px; line-height: 1.7; }

    /* ====== FOOTER ====== */
    footer {
      background: var(--navy);
      color: rgba(255,255,255,0.45);
      padding: 3rem 2rem; text-align: center;
    }
    .footer-logo { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: white; margin-bottom: 0.5rem; }

    @media (max-width: 768px) {
      nav { padding: 1rem 1.5rem; }
      .search-row { grid-template-columns: 1fr 1fr; }
      .features-grid { grid-template-columns: 1fr; }
      .flight-card { grid-template-columns: 1fr; gap: 1rem; }
      .seat-layout-wrap { flex-direction: column; }
      .seat-summary { width: 100%; }
      .pay-grid-2 { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<!-- Uçuş seçim verisi -->
<?php
include_once 'baglanti.php';
$ucuslar = [];
$hata = null;
try {
  $ucuslar = $db->query("SELECT * FROM ucuslar ORDER BY kalkis_zamani ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  $hata = "Uçuşlar yüklenemedi.";
}
?>

<nav>
  <a class="logo" href="#">
    <div class="logo-icon">✈</div>
    UçuşBul
  </a>
  <div class="nav-links">
    <a href="#flights">Uçuşlar</a>
    <a href="#features">Neden Biz?</a>
    <a href="#survey">Değerlendirme</a>
  </div>
</nav>

<!-- ====== HERO ====== -->
<section class="hero" id="home">
  <div class="stars" id="stars"></div>
  <div class="plane-decoration">✈</div>
  <div class="hero-content">
    <div class="hero-badge">✈ Türkiye'nin En Uygun Bilet Platformu</div>
    <h1>Hayalinizdeki<br>Uçuşu <span>Keşfedin</span></h1>
    <p>Yüzlerce uçuş arasından en uygun fiyatlı, en konforlu koltuğu akıllı koltuk puanı sistemiyle bulun.</p>
    <div class="hero-stats">
      <div class="stat-item">
        <div class="stat-num">48</div>
        <div class="stat-lbl">Koltuk Seçeneği</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">%100</div>
        <div class="stat-lbl">Güvenli Ödeme</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">7/24</div>
        <div class="stat-lbl">Müşteri Desteği</div>
      </div>
    </div>
  </div>
</section>

<!-- ====== SEARCH ====== -->
<div class="search-wrap">
  <div class="search-card">
    <div class="search-tabs">
      <button class="search-tab active">Tek Yön</button>
      <button class="search-tab">Gidiş-Dönüş</button>
    </div>
    <div class="search-row">
      <div class="search-field">
        <label>Nereden</label>
        <select id="fromCity">
          <option value="">Şehir seçin...</option>
          <option>İstanbul</option>
          <option>Ankara</option>
          <option>İzmir</option>
          <option>Antalya</option>
          <option>Trabzon</option>
        </select>
      </div>
      <div class="search-field">
        <label>Nereye</label>
        <select id="toCity">
          <option value="">Şehir seçin...</option>
          <option>İstanbul</option>
          <option>Ankara</option>
          <option>İzmir</option>
          <option>Antalya</option>
          <option>Trabzon</option>
        </select>
      </div>
      <div class="search-field">
        <label>Tarih</label>
        <input type="date" id="flightDate" min="<?= date('Y-m-d') ?>">
      </div>
      <div class="search-field">
        <label>Yolcu</label>
        <select>
          <option>1 Yolcu</option>
          <option>2 Yolcu</option>
          <option>3 Yolcu</option>
        </select>
      </div>
      <button class="search-btn-main" onclick="searchFlights()">🔍 Ara</button>
    </div>
  </div>
</div>

<!-- ====== FLIGHTS ====== -->
<section class="section flights-section" id="flights">
  <div class="container">
    <div class="section-title">✈ Mevcut Uçuşlar</div>
    <div class="section-sub">Tüm sefer listesi — koltuk seçmek için bir uçuş seçin</div>

    <?php if ($hata): ?>
      <div style="background:#fee2e2;color:#991b1b;padding:1rem 1.5rem;border-radius:12px;margin-bottom:1rem;"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <div class="flight-grid" id="flightGrid">
      <?php if (empty($ucuslar)): ?>
        <!-- Demo uçuşlar (DB boşsa) -->
        <?php
        $demo = [
          ['id'=>1,'kalkis_yeri'=>'İstanbul','varis_yeri'=>'Ankara','kalkis_zamani'=>'2026-05-20 08:30:00','fiyat'=>750],
          ['id'=>2,'kalkis_yeri'=>'İzmir','varis_yeri'=>'Antalya','kalkis_zamani'=>'2026-05-21 11:00:00','fiyat'=>620],
          ['id'=>3,'kalkis_yeri'=>'Trabzon','varis_yeri'=>'İstanbul','kalkis_zamani'=>'2026-05-22 15:45:00','fiyat'=>890],
          ['id'=>4,'kalkis_yeri'=>'Ankara','varis_yeri'=>'İzmir','kalkis_zamani'=>'2026-05-23 07:15:00','fiyat'=>540],
        ];
        $ucuslar = $demo;
        ?>
      <?php endif; ?>

      <?php
      $sehir_kodlari = [
        'İstanbul'=>'IST','Ankara'=>'ANK','İzmir'=>'ADB',
        'Antalya'=>'AYT','Trabzon'=>'TZX'
      ];
      foreach ($ucuslar as $i => $u):
        $from_code = $sehir_kodlari[$u['kalkis_yeri']] ?? strtoupper(substr($u['kalkis_yeri'],0,3));
        $to_code   = $sehir_kodlari[$u['varis_yeri']] ?? strtoupper(substr($u['varis_yeri'],0,3));
        $zaman = date('H:i', strtotime($u['kalkis_zamani']));
        $tarih = date('d M Y', strtotime($u['kalkis_zamani']));
        $fiyat = isset($u['fiyat']) ? $u['fiyat'] : rand(450, 1200);
        $popular = ($i === 0);
      ?>
      <div class="flight-card" onclick="openSeatModal(<?= $u['id'] ?>, '<?= htmlspecialchars($u['kalkis_yeri']) ?>', '<?= htmlspecialchars($u['varis_yeri']) ?>', '<?= $zaman ?>', '<?= $tarih ?>', <?= $fiyat ?>)">
        <div>
          <?php if ($popular): ?><div class="badge-popular">🔥 Popüler</div><?php endif; ?>
          <div class="flight-city"><?= htmlspecialchars($u['kalkis_yeri']) ?></div>
          <div class="flight-code"><?= $from_code ?></div>
          <div class="flight-time"><?= $zaman ?></div>
        </div>
        <div class="flight-mid">
          <div class="flight-duration">~1s 20dk</div>
          <div class="flight-line">
            <div style="width:6px;height:6px;border-radius:50%;background:var(--blue-light);flex-shrink:0"></div>
            <div class="flight-line-bar"></div>
            <div style="width:6px;height:6px;border-radius:50%;background:var(--blue-light);flex-shrink:0"></div>
          </div>
          <div style="font-size:11px;color:var(--gray-500);margin-top:6px;">Direkt</div>
        </div>
        <div>
          <div class="flight-city"><?= htmlspecialchars($u['varis_yeri']) ?></div>
          <div class="flight-code"><?= $to_code ?></div>
          <div class="flight-time"><?= $tarih ?></div>
        </div>
        <div class="flight-price">
          <div class="price-from">itibaren</div>
          <div class="price-amount"><?= number_format($fiyat) ?> ₺</div>
          <div class="price-pp">/ kişi</div>
        </div>
        <button class="select-btn" onclick="event.stopPropagation(); openSeatModal(<?= $u['id'] ?>, '<?= htmlspecialchars($u['kalkis_yeri']) ?>', '<?= htmlspecialchars($u['varis_yeri']) ?>', '<?= $zaman ?>', '<?= $tarih ?>', <?= $fiyat ?>)">Koltuk Seç →</button>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ====== FEATURES ====== -->
<section class="section" id="features">
  <div class="container">
    <div class="section-title">Neden UçuşBul?</div>
    <div class="section-sub">Size özgü akıllı özellikler</div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">⭐</div>
        <div class="feature-title">Akıllı Koltuk Puanı</div>
        <div class="feature-desc">Gerçek yolcu yorumlarından beslenen puanlama sistemi ile en konforlu koltuğu seçin. Düşük puanlı koltuklar otomatik vurgulanır.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💳</div>
        <div class="feature-title">Güvenli Ödeme</div>
        <div class="feature-desc">256-bit SSL şifrelemesi ile tüm banka kartlarında güvenli ödeme. Anında PNR numarası alın.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <div class="feature-title">Dinamik Fiyatlandırma</div>
        <div class="feature-desc">Yolcu memnuniyet puanlarına göre anlık fiyat güncellemesi. Popüler uçuşlarda erken rezervasyon avantajı.</div>
      </div>
    </div>
  </div>
</section>

<!-- ====== SURVEY ====== -->
<section class="section survey-section" id="survey">
  <div class="container">
    <div class="survey-card">
      <div class="section-title">Deneyiminizi Paylaşın</div>
      <div class="section-sub" style="margin-bottom:2rem;">Yorumunuz fiyatları ve diğer yolcuları etkiler</div>
      <form onsubmit="submitSurvey(event)">
        <input type="hidden" name="ucus_id" value="1">
        <label style="display:block;font-size:13px;font-weight:700;color:rgba(255,255,255,0.65);margin-bottom:6px;">Uçuş Değerlendirmesi</label>
        <select name="puan" class="survey-select" required>
          <option value="5">⭐⭐⭐⭐⭐ Mükemmel</option>
          <option value="4">⭐⭐⭐⭐ Çok İyi</option>
          <option value="3">⭐⭐⭐ Orta</option>
          <option value="2">⭐⭐ Kötü</option>
          <option value="1">⭐ Çok Kötü</option>
        </select>
        <label style="display:block;font-size:13px;font-weight:700;color:rgba(255,255,255,0.65);margin-bottom:6px;">Yorumunuz</label>
        <textarea name="yorum" class="survey-textarea" placeholder="Uçuş deneyiminizi anlatın..." required></textarea>
        <button type="submit" class="survey-btn">🚀 Değerlendirmeyi Gönder</button>
        <div class="survey-success" id="surveySuccess">✅ Değerlendirmeniz için teşekkürler! Görüşünüz fiyatlara yansıtılacak.</div>
      </form>
    </div>
  </div>
</section>

<footer>
  <div class="footer-logo">✈ UçuşBul</div>
  <div style="margin-top:0.5rem">© 2026 UçuşBul — Tüm hakları saklıdır.</div>
</footer>

<!-- ====== SEAT SELECTION MODAL ====== -->
<div class="overlay" id="seatOverlay">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-title" id="seatModalTitle">Koltuk Seçimi</div>
        <div class="modal-subtitle" id="seatModalSub"></div>
      </div>
      <button class="close-btn" onclick="closeModal('seatOverlay')">✕</button>
    </div>
    <div class="seat-legend">
      <div class="legend-item"><div class="legend-dot leg-empty"></div> Boş</div>
      <div class="legend-item"><div class="legend-dot leg-occ"></div> Dolu</div>
      <div class="legend-item"><div class="legend-dot leg-sel"></div> Seçili</div>
      <div class="legend-item"><div class="legend-dot leg-low"></div> Düşük Puanlı (&lt;3⭐)</div>
    </div>
    <div class="seat-layout-wrap">
      <div class="cabin-outer">
        <div class="cabin-nose">ÖN — Kabin Düzeni</div>
        <div class="seating-plan" id="seatingPlan"></div>
      </div>
      <div class="seat-summary">
        <div class="summary-box">
          <h3>Seçilen Koltuk</h3>
          <div id="seatSummaryContent">
            <div class="summary-empty">Henüz koltuk seçilmedi.<br><br>Soldaki kabinden bir koltuk seçin.</div>
          </div>
        </div>
        <button class="proceed-btn" id="proceedBtn" onclick="openPayment()">
          Ödemeye Geç →
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ====== PAYMENT MODAL ====== -->
<div class="overlay" id="paymentOverlay">
  <div class="payment-modal">
    <div class="modal-header">
      <div class="pay-title">💳 Güvenli Ödeme</div>
      <button class="close-btn" onclick="closeModal('paymentOverlay')">✕</button>
    </div>
    <div class="pay-summary-strip">
      <div>
        <div class="pss-route" id="payRoute">İST → ANK</div>
        <div class="pss-detail" id="payDetail">Koltuk: — | Tarih: —</div>
      </div>
      <div class="pss-price" id="payPrice">₺0</div>
    </div>

    <form onsubmit="completePayment(event)">
      <div class="pay-section-title">Yolcu Bilgileri</div>
      <div class="pay-grid-2">
        <div class="pay-field">
          <label>Ad Soyad</label>
          <input type="text" placeholder="Ahmet Yılmaz" required>
        </div>
        <div class="pay-field">
          <label>T.C. Kimlik No</label>
          <input type="text" placeholder="12345678901" maxlength="11" required pattern="[0-9]{11}">
        </div>
      </div>
      <div class="pay-field">
        <label>E-posta</label>
        <input type="email" placeholder="ahmet@email.com" required>
      </div>

      <div class="pay-section-title" style="margin-top:1.5rem;">Kart Bilgileri</div>
      <div class="card-icons">
        <div class="card-icon">VISA</div>
        <div class="card-icon">MC</div>
        <div class="card-icon">AMEX</div>
        <div class="card-icon">Troy</div>
      </div>
      <div class="pay-field">
        <label>Kart Üzerindeki İsim</label>
        <input type="text" placeholder="AHMET YILMAZ" required>
      </div>
      <div class="pay-field">
        <label>Kart Numarası</label>
        <input type="text" placeholder="0000 0000 0000 0000" maxlength="19" id="cardNum" required oninput="formatCard(this)">
      </div>
      <div class="pay-grid-2">
        <div class="pay-field">
          <label>Son Kullanma Tarihi</label>
          <input type="text" placeholder="AA/YY" maxlength="5" required oninput="formatExpiry(this)">
        </div>
        <div class="pay-field">
          <label>CVV / CVC</label>
          <input type="password" placeholder="•••" maxlength="3" required pattern="[0-9]{3}">
        </div>
      </div>

      <button type="submit" class="pay-btn-main">🔒 BİLETİ SATIN AL</button>
      <div class="security-note">🔐 256-bit SSL ile şifrelenmiş güvenli ödeme</div>
    </form>
  </div>
</div>

<!-- ====== SUCCESS MODAL ====== -->
<div class="overlay" id="successOverlay">
  <div class="success-modal">
    <div class="success-icon">✅</div>
    <div class="success-title">Ödeme Başarılı!</div>
    <div class="success-sub">Biletiniz onaylandı. Rezervasyon kodunuz:</div>
    <div class="pnr-box">
      <div class="pnr-label">PNR Numaranız</div>
      <div id="pnrCode">UCB-######</div>
    </div>
    <div class="success-sub" style="font-size:13px;">
      E-posta adresinize bilet bilgileri ve check-in linki gönderildi.<br>
      <strong>UçuşBul'u tercih ettiğiniz için teşekkürler. İyi uçuşlar! ✈</strong>
    </div>
    <button class="home-btn" onclick="goHome()">Ana Sayfaya Dön</button>
  </div>
</div>

<script>
// ====== STARS ======
(function() {
  const container = document.getElementById('stars');
  for (let i = 0; i < 60; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    star.style.cssText = `
      left: ${Math.random() * 100}%;
      top: ${Math.random() * 100}%;
      animation-delay: ${Math.random() * 3}s;
      animation-duration: ${2 + Math.random() * 3}s;
      opacity: ${0.1 + Math.random() * 0.5};
      width: ${1 + Math.random() * 2}px;
      height: ${1 + Math.random() * 2}px;
    `;
    container.appendChild(star);
  }
})();

// ====== SEARCH TABS ======
document.querySelectorAll('.search-tab').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.search-tab').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});

function searchFlights() {
  const from = document.getElementById('fromCity').value;
  const to = document.getElementById('toCity').value;
  document.getElementById('flights').scrollIntoView({ behavior: 'smooth' });
}

// ====== SEAT DATA (48 koltuk) ======
const seatData = [
  {id:'1A',type:'Cam',price:1500,score:2.3,comment:'Sakin ama motor sesi çok.',occupied:false},
  {id:'1B',type:'Koridor',price:1000,score:null,comment:'',occupied:true},
  {id:'1C',type:'Koridor',price:1000,score:3.1,comment:'Ortalama.',occupied:false},
  {id:'1D',type:'Cam',price:1500,score:4.4,comment:'Geniş diz mesafesi.',occupied:false},
  {id:'2A',type:'Cam',price:1500,score:4.3,comment:'Çok güzel manzara.',occupied:false},
  {id:'2B',type:'Koridor',price:1000,score:null,comment:'',occupied:true},
  {id:'2C',type:'Koridor',price:1000,score:4.1,comment:'Temiz.',occupied:false},
  {id:'2D',type:'Cam',price:1500,score:3.9,comment:'Biraz dar.',occupied:false},
  {id:'3A',type:'Cam',price:1500,score:1.7,comment:'Koltuk bozuktu.',occupied:false},
  {id:'3B',type:'Koridor',price:1000,score:4.5,comment:'Mükemmel hizmet.',occupied:false},
  {id:'3C',type:'Koridor',price:1000,score:3.3,comment:'Eh işte.',occupied:false},
  {id:'3D',type:'Cam',price:1500,score:3.5,comment:'Geniş.',occupied:false},
  {id:'4A',type:'Cam',price:1500,score:4.1,comment:'Konforlu.',occupied:false},
  {id:'4B',type:'Koridor',price:1000,score:null,comment:'',occupied:true},
  {id:'4C',type:'Koridor',price:1000,score:3.3,comment:'Geniş koridor.',occupied:false},
  {id:'4D',type:'Cam',price:1500,score:4.6,comment:'Her zaman iyi.',occupied:false},
  {id:'5A',type:'Cam',price:1400,score:null,comment:'',occupied:true},
  {id:'5B',type:'Koridor',price:900,score:4.0,comment:'Uyumak için ideal.',occupied:false},
  {id:'5C',type:'Koridor',price:900,score:null,comment:'',occupied:true},
  {id:'5D',type:'Cam',price:1400,score:3.8,comment:'Kanat manzarası güzel.',occupied:false},
  {id:'6A',type:'Cam',price:1200,score:2.5,comment:'Kanat görünmüyor.',occupied:false},
  {id:'6B',type:'Koridor',price:800,score:3.0,comment:'Biraz gürültülü.',occupied:false},
  {id:'6C',type:'Koridor',price:800,score:null,comment:'',occupied:true},
  {id:'6D',type:'Cam',price:1200,score:2.8,comment:'Motor sesi rahatsız.',occupied:false},
  {id:'7A',type:'Cam',price:1400,score:4.2,comment:'Rahat bir uçuştu.',occupied:false},
  {id:'7B',type:'Koridor',price:900,score:null,comment:'',occupied:true},
  {id:'7C',type:'Koridor',price:900,score:3.9,comment:'İkramlar güzeldi.',occupied:false},
  {id:'7D',type:'Cam',price:1400,score:null,comment:'',occupied:true},
  {id:'8A',type:'Cam',price:1400,score:null,comment:'',occupied:true},
  {id:'8B',type:'Koridor',price:900,score:null,comment:'',occupied:true},
  {id:'8C',type:'Koridor',price:900,score:4.5,comment:'Sorunsuz.',occupied:false},
  {id:'8D',type:'Cam',price:1400,score:4.7,comment:'Güneş batışı efsaneydi.',occupied:false},
  {id:'9A',type:'Cam',price:2000,score:5.0,comment:'Acil çıkış, bacak bacak!',occupied:false},
  {id:'9B',type:'Koridor',price:1500,score:null,comment:'',occupied:true},
  {id:'9C',type:'Koridor',price:1500,score:4.8,comment:'Dizlerim bayram etti.',occupied:false},
  {id:'9D',type:'Cam',price:2000,score:null,comment:'',occupied:true},
  {id:'10A',type:'Cam',price:1300,score:3.5,comment:'Normal koltuk.',occupied:false},
  {id:'10B',type:'Koridor',price:850,score:3.2,comment:'Hostesler çok geziyor.',occupied:false},
  {id:'10C',type:'Koridor',price:850,score:null,comment:'',occupied:true},
  {id:'10D',type:'Cam',price:1300,score:3.8,comment:'Sakin.',occupied:false},
  {id:'11A',type:'Cam',price:1300,score:null,comment:'',occupied:true},
  {id:'11B',type:'Koridor',price:850,score:null,comment:'',occupied:true},
  {id:'11C',type:'Koridor',price:850,score:3.6,comment:'Fena değil.',occupied:false},
  {id:'11D',type:'Cam',price:1300,score:null,comment:'',occupied:true},
  {id:'12A',type:'Cam',price:1100,score:2.1,comment:'Tuvalet kokusu geliyordu.',occupied:false},
  {id:'12B',type:'Koridor',price:750,score:2.4,comment:'Sıra bekleyenler dikildi.',occupied:false},
  {id:'12C',type:'Koridor',price:750,score:null,comment:'',occupied:true},
  {id:'12D',type:'Cam',price:1100,score:2.0,comment:'Koltuk yatmıyordu.',occupied:false},
];

let currentFlight = null;
let selectedSeat = null;

// ====== MODAL HELPERS ======
function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

// ====== SEAT MODAL ======
function openSeatModal(flightId, from, to, time, date, basePrice) {
  currentFlight = { id: flightId, from, to, time, date, basePrice };
  selectedSeat = null;

  document.getElementById('seatModalTitle').textContent = `${from} → ${to}`;
  document.getElementById('seatModalSub').textContent = `${date} | Kalkış: ${time} | Bilet fiyatı seçilen koltuğa göre değişir`;

  buildSeatingChart();

  document.getElementById('seatSummaryContent').innerHTML = '<div class="summary-empty">Henüz koltuk seçilmedi.<br><br>Soldaki kabinden bir koltuk seçin.</div>';
  document.getElementById('proceedBtn').style.display = 'none';

  document.getElementById('seatOverlay').classList.add('open');
}

function buildSeatingChart() {
  const plan = document.getElementById('seatingPlan');
  plan.innerHTML = '';

  seatData.forEach((seat, index) => {
    // Her 4 koltuğun 2. ve 3. arasına koridor
    if (index > 0 && index % 4 === 2) {
      const corridor = document.createElement('div');
      corridor.className = 'corridor';
      corridor.innerHTML = '|';
      plan.appendChild(corridor);
    }

    const el = document.createElement('div');
    el.className = 'seat';
    el.dataset.id = seat.id;

    if (seat.occupied) {
      el.classList.add('occupied');
    } else if (seat.score !== null && seat.score < 3) {
      el.classList.add('low-rated');
    } else {
      el.classList.add('empty');
    }

    el.innerHTML = `
      <span class="seat-num">${seat.id}</span>
      <span class="seat-score">${seat.score !== null ? seat.score + '⭐' : ''}</span>
    `;

    if (!seat.occupied) {
      el.addEventListener('click', () => handleSeatClick(el, seat));
    }

    plan.appendChild(el);
  });
}

function handleSeatClick(el, seat) {
  // Deselect if same
  if (selectedSeat && selectedSeat.id === seat.id) {
    el.className = 'seat ' + (seat.score !== null && seat.score < 3 ? 'low-rated' : 'empty');
    selectedSeat = null;
    document.getElementById('seatSummaryContent').innerHTML = '<div class="summary-empty">Koltuk seçimi iptal edildi.</div>';
    document.getElementById('proceedBtn').style.display = 'none';
    return;
  }

  // Deselect previous
  if (selectedSeat) {
    const prevEl = document.querySelector(`.seat[data-id="${selectedSeat.id}"]`);
    if (prevEl) {
      prevEl.className = 'seat ' + (selectedSeat.score !== null && selectedSeat.score < 3 ? 'low-rated' : 'empty');
    }
  }

  el.className = 'seat selected';
  selectedSeat = seat;

  const score = seat.score !== null ? `${seat.score} / 5.0 ⭐` : 'Puanlanmamış';
  const comment = seat.comment || 'Henüz yorum yok.';

  document.getElementById('seatSummaryContent').innerHTML = `
    <div class="summary-item"><span class="lbl">Koltuk</span><span class="val" style="color:var(--orange);font-size:18px;font-weight:800">${seat.id}</span></div>
    <div class="summary-item"><span class="lbl">Tür</span><span class="val">${seat.type}</span></div>
    <div class="summary-item"><span class="lbl">Fiyat</span><span class="val" style="color:var(--orange)">${seat.price.toLocaleString('tr-TR')} ₺</span></div>
    <div class="summary-item"><span class="lbl">Puan</span><span class="val">${score}</span></div>
    <hr style="border:none;border-top:1px solid var(--gray-200);margin:10px 0">
    <div style="font-size:13px;color:var(--gray-500);font-style:italic;">"${comment}"</div>
  `;
  document.getElementById('proceedBtn').style.display = 'block';
}

// ====== PAYMENT ======
function openPayment() {
  if (!selectedSeat || !currentFlight) return;

  const from = currentFlight.from;
  const to = currentFlight.to;
  const fromCode = from.substring(0,3).toUpperCase();
  const toCode = to.substring(0,3).toUpperCase();

  document.getElementById('payRoute').textContent = `${fromCode} → ${toCode}  (${from} → ${to})`;
  document.getElementById('payDetail').textContent = `Koltuk: ${selectedSeat.id} | ${currentFlight.date} ${currentFlight.time}`;
  document.getElementById('payPrice').textContent = `${selectedSeat.price.toLocaleString('tr-TR')} ₺`;

  document.getElementById('paymentOverlay').classList.add('open');
}

function completePayment(e) {
  e.preventDefault();
  // Generate random PNR
  const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
  let pnr = 'UCB-';
  for (let i = 0; i < 6; i++) pnr += chars[Math.floor(Math.random() * chars.length)];
  document.getElementById('pnrCode').textContent = pnr;

  document.getElementById('paymentOverlay').classList.remove('open');
  document.getElementById('successOverlay').classList.add('open');

  // Mark seat as occupied
  if (selectedSeat) {
    const seatInData = seatData.find(s => s.id === selectedSeat.id);
    if (seatInData) seatInData.occupied = true;
    selectedSeat = null;
  }
}

function goHome() {
  document.getElementById('successOverlay').classList.remove('open');
  document.getElementById('seatOverlay').classList.remove('open');
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ====== CARD FORMAT ======
function formatCard(input) {
  let val = input.value.replace(/\D/g, '').substring(0, 16);
  input.value = val.replace(/(.{4})/g, '$1 ').trim();
}

function formatExpiry(input) {
  let val = input.value.replace(/\D/g, '').substring(0, 4);
  if (val.length >= 2) val = val.substring(0, 2) + '/' + val.substring(2);
  input.value = val;
}

// ====== SURVEY ======
function submitSurvey(e) {
  e.preventDefault();
  const successEl = document.getElementById('surveySuccess');
  successEl.style.display = 'block';
  e.target.reset();
  setTimeout(() => { successEl.style.display = 'none'; }, 5000);

  // Gerçek projede fetch('anket_kaydet.php', {method:'POST', body: new FormData(e.target)})
}

// Close overlay on backdrop click
document.querySelectorAll('.overlay').forEach(overlay => {
  overlay.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
  });
});
</script>
</body>
</html>
