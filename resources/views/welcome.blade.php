<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Presensi | User Panel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

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
      background-color: #6c757d;
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

    .sidebar a:hover, .sidebar a.active {
      background-color: #495057;
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

    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    #profileDropdownTrigger {
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

    .stat-card {
      border-radius: 10px;
      padding: 16px;
    }

    .small-muted {
      color: #6c757d;
      font-size: 0.9rem;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
      .sidebar { width: 100%; height: auto; position: relative; }
      .content { margin-left: 0; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="header">
      <h4>Panel Karyawan</h4>
    </div>
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
      <i class="fa fa-house me-2"></i> Dashboard
    </a>
    <a href="{{ url('/presensi') }}" class="{{ request()->is('presensi') ? 'active' : '' }}">
      <i class="fa fa-fingerprint me-2"></i> Sistem Presensi
    </a>
    <a href="{{ url('/izin') }}" class="{{ request()->is('izin') ? 'active' : '' }}">
      <i class="fa fa-user-times me-2"></i> Izin
    </a>
    <a href="{{ url('/telat') }}" class="{{ request()->is('telat') ? 'active' : '' }}">
      <i class="fa fa-clock me-2"></i> Telat
    </a>
    <a href="{{ url('/tutorial') }}" class="{{ request()->is('tutorial') ? 'active' : '' }}">
      <i class="fa fa-book me-2"></i> Tutorial
    </a>
  </div>

  <!-- Main Content -->
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
          <h4 class="fw-bold">
            <span class="text-primary">Sistem Presensi</span>
            <br>
            <span class="text-danger">PT. Muncul Perdana Printindo</span>
          </h4>
          <p class="text-muted mb-0">Selamat datang di aplikasi presensi berbasis wajah.</p>
        </div>

        <!-- Filters & Summary -->
        <div class="row g-3 mb-3 align-items-center">
          <div class="col-12 col-md-4">
            <label class="form-label">Pilih Bulan</label>
            <input type="month" id="filterMonth" class="form-control" />
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label">Filter</label>
            <select id="filterType" class="form-select">
              <option value="all">Semua</option>
              <option value="kehadiran">Kehadiran</option>
              <option value="izin">Izin</option>
              <option value="telat">Telat</option>
            </select>
          </div>

          <div class="col-12 col-md-4 text-end">
            <label class="form-label d-block">&nbsp;</label>
            <button id="btnRefresh" class="btn btn-primary">Refresh</button>
          </div>
        </div>

        <!-- Stat cards -->
        <div class="row g-3 mb-4">
          <div class="col-12 col-md-4">
            <div class="stat-card bg-white p-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="small-muted">Izin (maks 2 hari / bulan)</div>
                  <h5 id="izinCount">0 / 2 hari</h5>
                </div>
                <div><i class="fa fa-user-times fa-2x text-warning"></i></div>
              </div>
              <div id="izinWarning" class="small text-danger mt-2" style="display:none">Melebihi batas izin!</div>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="stat-card bg-white p-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="small-muted">Telat (peringatan maks 3 / bulan)</div>
                  <h5 id="telatCount">0 / 3 kali</h5>
                </div>
                <div><i class="fa fa-clock fa-2x text-danger"></i></div>
              </div>
              <div id="telatWarning" class="small text-danger mt-2" style="display:none">Melebihi peringatan telat!</div>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="stat-card bg-white p-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="small-muted">Kehadiran</div>
                  <h5 id="kehadiranPct">0%</h5>
                </div>
                <div style="width:64px; height:64px;">
                  <canvas id="doughnutPct"></canvas>
                </div>
              </div>
              <div class="small-muted mt-2">Persentase kehadiran terhadap total hari di bulan</div>
            </div>
          </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mb-4">
          <div class="col-12 col-lg-6">
            <div class="card p-3">
              <h6 class="fw-bold">Distribusi Kehadiran</h6>
              <canvas id="pieChart"></canvas>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="card p-3">
              <h6 class="fw-bold">Jumlah per Kategori (Bar)</h6>
              <canvas id="barChart"></canvas>
            </div>
          </div>
        </div>

        <!-- Detail Presensi table -->
        <div class="table-responsive mt-4">
          <h6 class="fw-bold text-secondary mb-3">📋 Detail Presensi</h6>
          <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
              <tr>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody id="rekapTableBody">
              <tr><td colspan="5" class="text-muted">Belum ada data presensi</td></tr>
            </tbody>
          </table>
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

    const filterMonthEl = document.getElementById("filterMonth");
    const filterTypeEl = document.getElementById("filterType");
    const btnRefresh = document.getElementById("btnRefresh");

    // Stat elements
    const izinCountEl = document.getElementById("izinCount");
    const telatCountEl = document.getElementById("telatCount");
    const kehadiranPctEl = document.getElementById("kehadiranPct");
    const izinWarningEl = document.getElementById("izinWarning");
    const telatWarningEl = document.getElementById("telatWarning");

    // Charts
    let pieChart = null;
    let barChart = null;
    let doughnutChart = null;

    // Limits
    const MAX_IZIN = 2; // hari per bulan
    const MAX_TELAT = 3; // peringatan per bulan
    // Default work start time threshold to consider 'telat'
    const TELAT_THRESHOLD = "09:00";

    document.addEventListener("DOMContentLoaded", () => {
      const currentUser = localStorage.getItem(LS_LOGGED);
      if (!currentUser) {
        alert("⚠️ Silakan login terlebih dahulu!");
        window.location.href = "{{ url('/login') }}";
        return;
      }

      showUser(currentUser);

      // set default month to current month
      const now = new Date();
      const ym = now.toISOString().slice(0,7);
      filterMonthEl.value = ym;

      loadAndRender(currentUser);

      btnRefresh.addEventListener("click", () => loadAndRender(currentUser));
      filterMonthEl.addEventListener("change", () => loadAndRender(currentUser));
      filterTypeEl.addEventListener("change", () => loadAndRender(currentUser));
    });

    function showUser(username) {
      const data = JSON.parse(localStorage.getItem("user__" + username)) || {};
      profileImg.textContent = data.photo ? "" : username.charAt(0).toUpperCase();
      if (data.photo) {
        profileImg.style.backgroundImage = `url(${data.photo})`;
      }
      profileName.textContent = data.fullname || username;
    }

    function parseTimeString(t) {
      // expect "HH:MM" or "HH:MM:SS"
      if (!t) return null;
      const m = t.match(/^(\d{1,2}):(\d{2})(?::\d{2})?$/);
      if (!m) return null;
      const hh = String(m[1]).padStart(2,'0');
      const mm = m[2];
      return `${hh}:${mm}`;
    }

    function isTimeAfter(a, b) {
      // a and b are "HH:MM"
      if (!a || !b) return false;
      return a > b;
    }

    function loadAndRender(username) {
      const key = "rekap__" + username;
      const rekap = JSON.parse(localStorage.getItem(key)) || {};
      const selectedMonth = filterMonthEl.value; // "YYYY-MM"
      const filterType = filterTypeEl.value;

      // compute month/year values
      const [selY, selM] = selectedMonth.split("-").map(n => parseInt(n));
      const daysInMonth = new Date(selY, selM, 0).getDate();

      // collect dates in the chosen month
      const entries = [];
      Object.keys(rekap).forEach(dateStr => {
        // dateStr expected "YYYY-MM-DD"
        if (!dateStr.startsWith(selectedMonth)) return;
        const entry = rekap[dateStr] || {};
        entries.push({ date: dateStr, ...entry });
      });

      // Build default day entries if you want to show empty days (optional).
      // For simplicity, we'll use daysInMonth to compute percentages and absensi.

      // Counts
      let izinCount = 0;
      let telatCount = 0;
      let hadirCount = 0;
      // We'll count absen as days without checkIn and without izin
      let recordedDaysSet = new Set(entries.map(e => e.date));

      // For table rows
      const rows = [];

      // For each recorded day in month
      entries.sort((a,b) => a.date.localeCompare(b.date)).forEach(e => {
        const status = (e.status || '').toLowerCase();
        const checkInRaw = e.checkIn || e.check_in || e.in || '';
        const checkOutRaw = e.checkOut || e.check_out || e.out || '';
        const checkIn = parseTimeString(checkInRaw);
        const checkOut = parseTimeString(checkOutRaw);

        let finalStatus = '-';
        let ket = e.note || e.keterangan || '';

        if (status === 'izin' || e.izin) {
          // treat as izin
          izinCount += (e.izinDays ? Number(e.izinDays) : 1);
          finalStatus = 'Izin';
          if (e.izinDays && Number(e.izinDays) > 1) ket = ket || `${e.izinDays} hari izin`;
        } else if (status === 'telat' || (checkIn && isTimeAfter(checkIn, TELAT_THRESHOLD))) {
          telatCount++;
          hadirCount += (checkIn ? 1 : 0);
          finalStatus = 'Telat';
        } else if (checkIn || checkOut) {
          hadirCount += (checkIn || checkOut) ? 1 : 0;
          finalStatus = 'Hadir';
        }

        rows.push({
          date: e.date,
          checkIn: checkIn || '-',
          checkOut: checkOut || '-',
          status: finalStatus,
          keterangan: ket || '-'
        });
      });

      // Determine absen count: days in month minus hadir minus izin (we count izinCount as days)
      // Note: this assumes full month working days; you can modify to exclude weekends if needed.
      const absenCount = Math.max(0, daysInMonth - hadirCount - izinCount);

      // overall totals
      const totalDays = daysInMonth;
      const hadirPct = Math.round((hadirCount / totalDays) * 100) || 0;

      // update stat cards
      izinCountEl.textContent = `${izinCount} / ${MAX_IZIN} hari`;
      telatCountEl.textContent = `${telatCount} / ${MAX_TELAT} kali`;
      kehadiranPctEl.textContent = `${hadirPct}%`;

      izinWarningEl.style.display = (izinCount > MAX_IZIN) ? 'block' : 'none';
      telatWarningEl.style.display = (telatCount > MAX_TELAT) ? 'block' : 'none';

      // Update table according to filterType
      let displayRows = rows;
      if (filterType === 'izin') displayRows = rows.filter(r => r.status.toLowerCase() === 'izin');
      else if (filterType === 'telat') displayRows = rows.filter(r => r.status.toLowerCase() === 'telat');
      else if (filterType === 'kehadiran') displayRows = rows.filter(r => r.status.toLowerCase() === 'hadir' || r.status.toLowerCase() === 'telat');

      if (displayRows.length === 0) {
        rekapTableBody.innerHTML = `<tr><td colspan="5" class="text-muted">Belum ada data presensi</td></tr>`;
      } else {
        rekapTableBody.innerHTML = displayRows.map(r => `
          <tr>
            <td>${r.date}</td>
            <td>${r.checkIn}</td>
            <td>${r.checkOut}</td>
            <td>${r.status}</td>
            <td>${r.keterangan}</td>
          </tr>
        `).join('');
      }

      // Prepare chart data
      const pieData = {
        labels: ['Hadir', 'Izin', 'Telat', 'Absen'],
        datasets: [{
          data: [hadirCount, izinCount, telatCount, absenCount],
        }]
      };

      const barData = {
        labels: ['Hadir', 'Izin', 'Telat', 'Absen'],
        datasets: [{
          label: 'Jumlah Hari',
          data: [hadirCount, izinCount, telatCount, absenCount],
          barPercentage: 0.6,
          categoryPercentage: 0.6
        }]
      };

      // Render or update charts
      const pieCtx = document.getElementById('pieChart').getContext('2d');
      const barCtx = document.getElementById('barChart').getContext('2d');
      const doughnutCtx = document.getElementById('doughnutPct').getContext('2d');

      // Destroy previous charts to avoid duplication
      if (pieChart) pieChart.destroy();
      if (barChart) barChart.destroy();
      if (doughnutChart) doughnutChart.destroy();

      pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: pieData,
        options: {
          plugins: {
            legend: { position: 'bottom' },
            tooltip: { enabled: true }
          }
        }
      });

      barChart = new Chart(barCtx, {
        type: 'bar',
        data: barData,
        options: {
          scales: {
            y: { beginAtZero: true }
          },
          plugins: { legend: { display: false } }
        }
      });

      doughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
          labels: ['Kehadiran','Sisa'],
          datasets: [{
            data: [hadirPct, Math.max(0, 100-hadirPct)]
          }]
        },
        options: {
          cutout: '70%',
          plugins: {
            legend: { display: false },
            tooltip: { enabled: false }
          }
        }
      });
    }

    logoutBtn.addEventListener("click", (e) => {
      e.preventDefault();
      if (confirm("Yakin ingin keluar?")) {
        localStorage.removeItem(LS_LOGGED);
        window.location.href = "{{ url('/login') }}";
      }
    });
  </script>

</body>
</html>
