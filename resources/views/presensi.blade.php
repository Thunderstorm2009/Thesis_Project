<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sistem Presensi | Dashboard</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f9;
    }

    .card {
      border: none;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
      border-radius: 10px;
    }

    .btn-primary {
      background-color: #1d3557;
      border-color: #1d3557;
    }

    .btn-primary:hover {
      background-color: #457b9d;
    }

    .btn-secondary {
      background-color: #adb5bd;
      border-color: #adb5bd;
    }

    .btn-back {
      background-color: transparent;
      border: none;
      color: #1d3557;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 5px;
      text-decoration: none;
      transition: color 0.3s;
    }

    .btn-back:hover {
      color: #457b9d;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <div class="card p-4">
      <!-- Tombol kembali ke dashboard -->
      <div class="mb-3">
        <a href="{{ url('/') }}" class="btn-back">
          <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
      </div>

      <div class="text-center mb-4">
        <h4 class="fw-bold">
          <span class="text-primary">Sistem Presensi</span>
          <br>
          <span class="text-danger">PT. Muncul Perdana Printindo</span>
        </h4>
        <p class="text-muted mb-0">Silahkan melakukan check in atau check out dengan tombol yang sudah disediakan.</p>
      </div>

      <div class="text-center">
        <h5 class="fw-semibold text-secondary mb-3">Dashboard Presensi</h5>
        <div class="row g-3 justify-content-center mb-4">
          <div class="col-6 col-md-3">
            <a href="{{ url('/checkin') }}" id="btnCheckIn" class="btn btn-primary w-100">
              <i class="fa-solid fa-clock me-2"></i>Check In
            </a>
          </div>
          <div class="col-6 col-md-3">
            <a href="{{ url('/checkout') }}" id="btnCheckOut" class="btn btn-secondary w-100">
              <i class="fa-solid fa-calendar-times me-2"></i>Check Out
            </a>
          </div>
        </div>

        <div class="table-responsive mt-4">
          <h6 class="fw-bold text-secondary mb-3">📋 Rekap Presensi</h6>
          <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
              <tr>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
              </tr>
            </thead>
            <tbody id="rekapTableBody">
              <tr><td colspan="3" class="text-muted">Belum ada data presensi</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <footer class="text-center text-muted mt-4 mb-3">
      <small>© 2025 Aplikasi Presensi PT. Muncul Perdana Printindo</small>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
