<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Presensi | User Panel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f9;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      background-color: #1d3557;
      color: white;
      display: flex;
      flex-direction: column;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #457b9d;
    }
    .sidebar .header {
      text-align: center;
      padding: 20px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar .header h4 {
      margin: 0;
      font-weight: bold;
    }

    /* Main content */
    .content {
      margin-left: 250px;
      padding: 20px;
    }

    /* Navbar */
    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* Profile avatar */
    #profileDropdownTrigger { /* ID baru untuk trigger dropdown */
      cursor: pointer;
    }
    #profileImg {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background-color: #1d3557;
      color: #fff;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      background-size: cover;
      background-position: center;
      margin-right: 8px;
    }

    /* Cards */
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
  </style>
</head>
<body>

  <div class="sidebar">
    <div class="header">
      <h4>Panel Karyawan</h4>
    </div>
    <a href="{{ url('/') }}"><i class="fa fa-house me-2"></i> Dashboard</a>
    <a href="{{ url('/izin') }}"><i class="fa fa-user-times me-2"></i> Izin</a>
    <a href="{{ url('/telat') }}"><i class="fa fa-clock me-2"></i> Telat</a>
    <a href="{{ url('/tutorial') }}"><i class="fa fa-book me-2"></i> Tutorial</a>
    </div>

  <div class="content">
    <nav class="navbar navbar-expand navbar-light mb-4">
      <div class="container-fluid d-flex justify-content-end align-items-center">
        <div class="dropdown">
          <div class="d-flex align-items-center" id="profileDropdownTrigger" data-bs-toggle="dropdown" aria-expanded="false">
            <div id="profileImg">U</div>
            <span id="profileName" class="fw-semibold text-primary"></span>
          </div>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdownTrigger">
            <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fa fa-user me-2"></i> Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="fa fa-sign-out-alt me-2"></i> Keluar</a></li>
          </ul>
        </div>
        </div>
    </nav>

    <div class="container">
      <div class="card p-4">
        <div class="text-center mb-4">
          <h4 class="text-primary fw-bold">Sistem Presensi PT. Muncul Perdana Printindo</h4>
          <p class="text-muted mb-0">Selamat datang di aplikasi presensi berbasis wajah.</p>
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
    </div>
  </div>

  <footer class="text-center text-muted mt-5 mb-3">
    <small>© 2025 Aplikasi Presensi PT. Muncul Perdana Printindo</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const LS_LOGGED = "loggedInUser";
    const profileImg = document.getElementById("profileImg");
    const profileName = document.getElementById("profileName");
    const logoutBtn = document.getElementById("logoutBtn");
    const rekapTableBody = document.getElementById("rekapTableBody");

    // Saat halaman dimuat
    document.addEventListener("DOMContentLoaded", () => {
      const currentUser = localStorage.getItem(LS_LOGGED);
      if (!currentUser) {
        alert("⚠️ Silakan login terlebih dahulu!");
        window.location.href = "{{ url('/login') }}";
        return;
      }

      showUser(currentUser);
      loadRekap(currentUser);
    });

    // Tampilkan profil user
    function showUser(username) {
      const data = JSON.parse(localStorage.getItem("user__" + username)) || {};
      profileImg.textContent = data.photo ? "" : username.charAt(0).toUpperCase();
      if (data.photo) {
        profileImg.style.backgroundImage = `url(${data.photo})`;
        profileImg.style.backgroundSize = "cover";
        profileImg.style.backgroundPosition = "center";
      }
      profileName.textContent = data.fullname || username;
    }

    // Ambil data rekap
    function loadRekap(username) {
      const key = "rekap__" + username;
      const rekap = JSON.parse(localStorage.getItem(key)) || {};
      const dates = Object.keys(rekap);
      if (dates.length === 0) {
        rekapTableBody.innerHTML = `<tr><td colspan="3" class="text-muted">Belum ada data presensi</td></tr>`;
        return;
      }
      rekapTableBody.innerHTML = dates.map(date => `
        <tr>
          <td>${date}</td>
          <td>${rekap[date].checkIn || '-'}</td>
          <td>${rekap[date].checkOut || '-'}</td>
        </tr>
      `).join('');
    }

    // Logout
    logoutBtn.addEventListener("click", (e) => { // Menambahkan (e)
      e.preventDefault(); // Mencegah navigasi default link '#'
      if (confirm("Yakin ingin keluar?")) {
        localStorage.removeItem(LS_LOGGED);
        window.location.href = "{{ url('/login') }}";
      }
    });
  </script>
</body>
</html>