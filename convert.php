<?php
function convert($jenis, $nilai, $dari, $ke) {
    if ($jenis === 'suhu') {
        if ($dari === 'c') $c = $nilai;
        elseif ($dari === 'f') $c = ($nilai - 32) * 5/9;
        elseif ($dari === 'k') $c = $nilai - 273.15;
        if ($ke === 'c') return $c;
        elseif ($ke === 'f') return $c * 9/5 + 32;
        elseif ($ke === 'k') return $c + 273.15;
    }
    if ($jenis === 'panjang') {
        $to_meter = ['m'=>1, 'km'=>1000, 'cm'=>0.01, 'mil'=>1609.34];
        $meter = $nilai * $to_meter[$dari];
        return $meter / $to_meter[$ke];
    }
    if ($jenis === 'berat') {
        $to_kg = ['g'=>0.001, 'kg'=>1, 'pon'=>0.453592];
        $kg = $nilai * $to_kg[$dari];
        return $kg / $to_kg[$ke];
    }
    if ($jenis === 'waktu') {
        $to_sec = ['detik'=>1, 'menit'=>60, 'jam'=>3600];
        $sec = $nilai * $to_sec[$dari];
        return $sec / $to_sec[$ke];
    }
    return null;
}
$result = '';
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['jenis'], $_POST['value'], $_POST['from'], $_POST['to'])
) {
    $jenis = $_POST['jenis'];
    $nilai = floatval($_POST['value']);
    $dari = $_POST['from'];
    $ke = $_POST['to'];
    $hasil = convert($jenis, $nilai, $dari, $ke);
    $result = $nilai . ' ' . strtoupper($dari) . ' = ' . round($hasil, 4) . ' ' . strtoupper($ke);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konversi Satuan - Informatics Tools</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Roboto:wght@400;500&display=swap');
        html, body { height: 100%; }
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .main-content { flex: 1 0 auto; margin-bottom: 1rem; }
        footer { flex-shrink: 0; background: linear-gradient(90deg, #38bdf8 0%, #818cf8 100%); color: #222; text-align: center; font-size: 1rem; border-radius: 2rem 2rem 0 0; box-shadow: 0 -2px 16px #818cf822; border-top: 3px solid #0ea5e9; padding: 1.2rem 0 0.5rem 0; margin-top: 0; }
        body { background: #0f172a; min-height: 100vh; font-family: 'Roboto', Arial, sans-serif; }
        body::before { content: ''; position: fixed; z-index: 0; top: 0; left: 0; right: 0; bottom: 0; background: repeating-linear-gradient(135deg, rgba(56,189,248,0.04) 0 2px, transparent 2px 40px), repeating-linear-gradient(45deg, rgba(139,92,246,0.04) 0 2px, transparent 2px 40px); pointer-events: none; }
        .navbar { background: linear-gradient(90deg, #312e81 0%, #0ea5e9 100%); font-family: 'Orbitron', 'Roboto', Arial, sans-serif; letter-spacing: 1px; box-shadow: 0 2px 16px #818cf822; }
        .navbar-brand, .nav-link, .navbar-brand:focus, .nav-link:focus { color: #fff !important; }
        .navbar-brand { font-size: 1.3rem; font-weight: 700; letter-spacing: 2px; }
        .nav-link.active { color: #38bdf8 !important; font-weight: 600; }
        .main-header { background: linear-gradient(90deg, #312e81 0%, #0ea5e9 100%); color: #fff; padding: 2.2rem 0 1.2rem 0; border-radius: 0 0 2.5rem 2.5rem; box-shadow: 0 4px 32px rgba(14,165,233,0.18); margin-bottom: 2.5rem; position: relative; overflow: hidden; }
        .main-header .icon-lg { font-size: 3.2rem; color: #38bdf8; text-shadow: 0 0 16px #818cf8, 0 0 32px #0ea5e9; animation: iconPop 1.2s cubic-bezier(.4,2,.6,1) infinite alternate; }
        @keyframes iconPop { 0% { transform: scale(1) rotate(-3deg); } 100% { transform: scale(1.13) rotate(3deg); } }
        .main-header h1 { font-family: 'Orbitron', 'Roboto', Arial, sans-serif; font-size: 2.2rem; letter-spacing: 2px; text-shadow: 0 2px 16px #0ea5e9; }
        .main-header p { font-size: 1.1rem; color: #bae6fd; text-shadow: 0 1px 8px #0ea5e9; }
        .card-modern { border: none; border-radius: 1.5rem; box-shadow: 0 8px 40px rgba(56,189,248,0.13); background: rgba(30,41,59,0.82); backdrop-filter: blur(8px) saturate(1.2); transition: transform 0.2s, box-shadow 0.2s, background 0.2s; }
        .card-modern:hover { transform: translateY(-8px) scale(1.04) rotate(-1deg); box-shadow: 0 20px 64px 0 rgba(139,92,246,0.18); background: rgba(30,41,59,0.93); }
        .card-title, .card-title i { color: #38bdf8; font-family: 'Orbitron', 'Roboto', Arial, sans-serif; letter-spacing: 1px; }
        .form-label { font-weight: 500; color: #818cf8; }
        .form-control { background: rgba(255,255,255,0.08); color: #fff; border: 1.5px solid #818cf8; border-radius: 0.7rem; }
        .form-control:focus { background: rgba(255,255,255,0.18); border-color: #38bdf8; color: #fff; box-shadow: 0 0 0 2px #38bdf833; }
        .btn-primary { background: linear-gradient(90deg, #6366f1 0%, #38bdf8 100%); color: #fff; border: none; border-radius: 0.7rem; font-weight: 600; letter-spacing: 0.5px; box-shadow: 0 2px 12px 0 #818cf822; transition: background 0.2s, box-shadow 0.2s, transform 0.15s; }
        .btn-primary:hover { box-shadow: 0 6px 24px #818cf855; transform: scale(1.07) translateY(-2px); filter: brightness(1.09); }
        .btn-secondary { border-radius: 0.7rem; font-weight: 600; letter-spacing: 0.5px; }
        .alert-success { border-radius: 1rem; font-size: 1.1rem; background: linear-gradient(90deg, #818cf8 0%, #38bdf8 100%); color: #fff; border: none; box-shadow: 0 2px 16px #818cf822; }
        @media (max-width: 576px) { .main-header { padding: 1.2rem 0 0.7rem 0; border-radius: 0 0 1.2rem 1.2rem; } .main-header h1 { font-size: 1.3rem; } .card-modern { border-radius: 1rem; } }
    </style>
    <script>
    const satuan = {
        suhu: {c:'Celsius', f:'Fahrenheit', k:'Kelvin'},
        panjang: {m:'Meter', km:'Kilometer', cm:'Centimeter', mil:'Mil'},
        berat: {g:'Gram', kg:'Kilogram', pon:'Pound'},
        waktu: {detik:'Detik', menit:'Menit', jam:'Jam'}
    };
    function updateSatuan() {
        const jenis = document.getElementById('jenis').value;
        const from = document.getElementById('from');
        const to = document.getElementById('to');
        from.innerHTML = '';
        to.innerHTML = '';
        for (const k in satuan[jenis]) {
            from.innerHTML += `<option value="${k}">${satuan[jenis][k]}</option>`;
            to.innerHTML += `<option value="${k}">${satuan[jenis][k]}</option>`;
        }
        to.selectedIndex = 1;
    }
    window.onload = function() {
        updateSatuan();
        document.getElementById('jenis').addEventListener('change', updateSatuan);
    };
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="bi bi-pc-display-horizontal"></i> Informatics Tools</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="convert.php">Konversi</a></li>
        <li class="nav-item"><a class="nav-link" href="compress.php">Kompresi</a></li>
      </ul>
    </div>
  </div>
</nav>
<header class="main-header text-center mb-4">
    <div class="container position-relative">
        <i class="bi bi-sliders2-vertical icon-lg mb-2"></i>
        <h1 class="fw-bold mb-0">Konversi Satuan</h1>
        <p class="lead mb-0">Konversi suhu, panjang, berat, dan waktu dengan mudah dan cepat.</p>
    </div>
</header>
<div class="main-content">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card card-modern">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Konversi</label>
                                <select name="jenis" id="jenis" class="form-select">
                                    <option value="suhu">Suhu</option>
                                    <option value="panjang">Panjang</option>
                                    <option value="berat">Berat</option>
                                    <option value="waktu">Waktu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="value" class="form-label">Nilai</label>
                                <input type="number" step="any" name="value" id="value" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="from" class="form-label">Dari Satuan</label>
                                <select name="from" id="from" class="form-select"></select>
                            </div>
                            <div class="mb-3">
                                <label for="to" class="form-label">Ke Satuan</label>
                                <select name="to" id="to" class="form-select"></select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-left-right me-1"></i>Konversi</button>
                            </div>
                        </form>
                        <?php if ($result): ?>
                            <div class="alert alert-success mt-4 text-center d-flex align-items-center justify-content-center gap-2" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><strong>Hasil:</strong> <?php echo $result; ?></span>
                            </div>
                        <?php endif; ?>
                        <a href="index.php" class="btn btn-secondary mt-4"><i class="bi bi-house-door"></i> Kembali ke Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    &copy; <?php echo date('Y'); ?> Informatics Tools &mdash; All rights reserved.
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 