<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }

    /* SIDEBAR */
    .sidebar { width: 220px; background: #1a237e; min-height: 100vh; padding: 0; flex-shrink: 0; }
    .sidebar .logo { color: white; text-align: center; padding: 22px 16px; font-size: 17px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.15); }
    .sidebar a { display: block; color: rgba(255,255,255,0.82); padding: 13px 24px; text-decoration: none; font-size: 14px; transition: background 0.2s; }
    .sidebar a:hover { background: rgba(255,255,255,0.12); }
    .sidebar a.active { background: #ff6b00; color: white; }
    .sidebar .bolum { color: rgba(255,255,255,0.4); font-size: 11px; padding: 14px 24px 4px; text-transform: uppercase; letter-spacing: 1px; }

    /* MAIN */
    .main { flex: 1; padding: 30px; }
    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
    .topbar h1 { color: #1a237e; font-size: 22px; }
    .topbar span { font-size: 13px; color: #666; }
    .topbar a { color: #ff6b00; text-decoration: none; font-weight: bold; }

    /* KARTLAR */
    .cards { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px; }
    .card { background: white; border-radius: 12px; padding: 26px 32px; min-width: 170px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); text-align: center; }
    .card .sayi { font-size: 38px; font-weight: bold; color: #ff6b00; }
    .card .etiket { color: #777; font-size: 14px; margin-top: 6px; }

    /* TABLO */
    .tablo-wrap { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #1a237e; color: white; padding: 13px 16px; text-align: left; font-size: 13px; }
    td { padding: 12px 16px; border-bottom: 1px solid #f0f0f0; font-size: 14px; color: #333; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafafa; }

    /* BUTONLAR */
    .btn { padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 13px; border: none; cursor: pointer; display: inline-block; }
    .btn-edit { background: #1a237e; color: white; }
    .btn-edit:hover { background: #283593; }
    .btn-del { background: #e53935; color: white; }
    .btn-del:hover { background: #c62828; }
    .btn-add { background: #ff6b00; color: white; padding: 10px 20px; border-radius: 7px; text-decoration: none; font-size: 14px; font-weight: bold; border: none; cursor: pointer; }
    .btn-add:hover { background: #e55a00; }

    /* FORM */
    .form-wrap { background: white; border-radius: 12px; padding: 32px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); max-width: 520px; }
    .form-grup { margin-bottom: 18px; }
    .form-grup label { display: block; font-size: 13px; color: #555; font-weight: bold; margin-bottom: 6px; }
    .form-grup input, .form-grup select { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 7px; font-size: 14px; }
    .form-grup input:focus, .form-grup select:focus { outline: none; border-color: #ff6b00; }
    .basari { background: #e8f5e9; color: #2e7d32; padding: 10px 14px; border-radius: 7px; margin-bottom: 18px; border-left: 4px solid #43a047; font-size: 14px; }
    .hata-msg { background: #fdecea; color: #c62828; padding: 10px 14px; border-radius: 7px; margin-bottom: 18px; border-left: 4px solid #e53935; font-size: 14px; }
</style>