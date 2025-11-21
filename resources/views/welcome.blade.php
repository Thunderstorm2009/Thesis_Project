<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Presensi | User Panel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <style>
    body { font-family: 'Roboto', sans-serif; background-color: #f4f6f9; overflow: hidden; }

    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      background-color: #6c757d;
      color: white;
      display: flex;
      flex-direction: column;
    }
    .sidebar a { color: white; display: block; padding: 12px 20px; text-decoration: none; transition: .3s; }
    .sidebar a:hover, .sidebar a.active { background-color: #495057; }

    .content {
      margin-left: 250px;
      height: 100vh;
      overflow-y: auto;
      padding: 20px;
    }

    #profileImg {
      width: 38px; height: 38px;
      border-radius: 50%;
      background-color: #1d3557; color: white; display:flex;
      justify-content:center; align-items:center; font-weight:bold;
    }
    #profileName { font-size: 13px; }

    .card { border:none; box-shadow:0 0 8px rgba(0,0,0,.08); border-radius:10px; }

    canvas { max-height: 160px !important; }

    .table-responsive { max-height: 250px; overflow-y: auto; }

  </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <div class="text-center p-3 border-bottom">
    <h5 class="fw-bold m-0">Panel Karyawan</h5>
  </div>

  <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fa fa-house me-2"></i> Dashboard</a>
  <a href="{{ url('/presensi') }}" class="{{ request()->is('presensi') ? 'active' : '' }}"><i class="fa fa-fingerprint me-2"></i> Sistem Presensi</a>
  <a href="{{ url('/izin') }}" class="{{ request()->is('izin') ? 'active' : '' }}"><i class="fa fa-user-times me-2"></i> Izin</a>
  <a href="{{ url('/telat') }}" class="{{ request()->is('telat') ? 'active' : '' }}"><i class="fa fa-clock me-2"></i> Telat</a>
  <a href="{{ url('/tutorial') }}" class="{{ request()->is('tutorial') ? 'active' : '' }}"><i class="fa fa-book me-2"></i> Tutorial</a>
</div>

<!-- CONTENT -->
<div class="content">

  <nav class="navbar navbar-expand navbar-light mb-3">
    <div class="container-fluid d-flex justify-content-end align-items-center">
      <div class="dropdown">
        <div class="d-flex align-items-center" id="profileDropdownTrigger" data-bs-toggle="dropdown">
          <div id="profileImg">U</div>
          <span id="profileName" class="fw-semibold text-primary ms-1"></span>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fa fa-user me-2"></i> Profil</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="fa fa-sign-out-alt me-2"></i> Keluar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HEADER WELCOME -->
  <div class="card p-3 mb-3 text-center">
    <h5 class="fw-bold">Sistem Presensi<br><span class="text-danger">PT. Muncul Perdana Printindo</span></h5>
    <p class="text-muted">Selamat datang di aplikasi presensi berbasis wajah.</p>
  </div>

  <!-- FILTER -->
  <div class="row g-3 mb-3">
    <div class="col-md-4">
      <label class="form-label">Pilih Bulan</label>
      <input type="month" id="filterMonth" class="form-control"/>
    </div>

    <div class="col-md-4">
      <label class="form-label">Filter</label>
      <select id="filterType" class="form-select">
        <option value="all">Semua</option>
        <option value="kehadiran">Kehadiran</option>
        <option value="izin">Izin</option>
        <option value="telat">Telat</option>
      </select>
    </div>
  </div>

  <!-- TABS -->
  <ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tabRekap">Rekap Presensi</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabCharts">Grafik</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabTable">Detail Presensi</a></li>
  </ul>

  <div class="tab-content">

    <!-- TAB 1 REKAP -->
    <div class="tab-pane fade show active" id="tabRekap">

      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <div class="card p-3 stat-card">
            <div class="small text-muted">Izin (maks 2 hari)</div>
            <h5 id="izinCount">0 / 2 hari</h5>
            <div id="izinWarning" class="text-danger small mt-2" style="display:none;">Melebihi batas izin!</div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card p-3 stat-card">
            <div class="small text-muted">Telat (maks 3 kali)</div>
            <h5 id="telatCount">0 / 3 kali</h5>
            <div id="telatWarning" class="text-danger small mt-2" style="display:none;">Peringatan telat!</div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card p-3 stat-card text-center">
            <h5 id="kehadiranPct">0%</h5>
            <canvas id="doughnutPct"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 2 CHART -->
    <div class="tab-pane fade" id="tabCharts">
      <div class="row g-3">
        <div class="col-lg-6">
          <div class="card p-3">
            <h6 class="fw-bold">Distribusi Presensi</h6>
            <canvas id="pieChart"></canvas>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card p-3">
            <h6 class="fw-bold">Bar Chart</h6>
            <canvas id="barChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 3 TABLE -->
    <div class="tab-pane fade" id="tabTable">
      <div class="table-responsive mt-3">
        <table class="table table-bordered text-center">
          <thead class="table-light">
          <tr>
            <th>Tanggal</th><th>Check In</th><th>Check Out</th><th>Status</th><th>Keterangan</th>
          </tr>
          </thead>
          <tbody id="rekapTableBody">
            <tr><td colspan="5" class="text-muted">Belum ada data...</td></tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div> <!-- END CONTENT -->

<footer class="text-center text-muted mt-2">
  <small>© 2025 Aplikasi Presensi PT. Muncul Perdana Printindo</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* SCRIPT SAMA SEPERTI DI FILE ANDA SEBELUMNYA
TANPA REFRESH BUTTON — ONLY AUTO UPDATE */
</script>

</body>
</html>
