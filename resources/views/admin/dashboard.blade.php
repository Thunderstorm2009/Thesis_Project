@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-secondary">Dashboard Statistik Presensi</h4>
    <button class="btn btn-sm btn-outline-primary" onclick="refreshDashboard()">
      <i class="fa fa-sync"></i> Segarkan Data
    </button>
  </div>

  <!-- Statistik Ringkas -->
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-center p-3">
        <h6 class="text-secondary">Total Karyawan</h6>
        <h3 id="statTotalUser" class="fw-bold">0</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-center p-3">
        <h6 class="text-secondary">Presensi Hari Ini</h6>
        <h3 id="statHadirHariIni" class="fw-bold text-success">0</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-center p-3">
        <h6 class="text-secondary">Telat / Izin Hari Ini</h6>
        <h3 id="statIzinHariIni" class="fw-bold text-warning">0</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-center p-3">
        <h6 class="text-secondary">Alpha Hari Ini</h6>
        <h3 id="statAlphaHariIni" class="fw-bold text-danger">0</h3>
      </div>
    </div>
  </div>

  <!-- Filter Jabatan -->
  <div class="card shadow-sm p-3 mb-4 border-0">
    <label class="fw-semibold mb-1">Filter berdasarkan Jabatan</label>
    <select id="filterJabatan" class="form-select" onchange="renderDashboard()">
      <option value="all">Semua Jabatan</option>
    </select>
  </div>

  <div class="row g-4">

    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold">Distribusi Pengguna per Jabatan</div>
        <div class="card-body"><div id="chartUsersPie"></div></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold">Tren Total Presensi Harian</div>
        <div class="card-body"><div id="chartLinePresensi"></div></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold">Total Presensi berdasarkan Jabatan</div>
        <div class="card-body"><div id="chartBarJabatan"></div></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold">Struktur Jabatan (Treemap)</div>
        <div class="card-body"><div id="chartSunburst"></div></div>
      </div>
    </div>

  </div>

  <!-- Ranking -->
  <div class="card shadow-sm border-0 rounded-3 mt-4">
    <div class="card-header bg-white fw-bold">Ranking Kehadiran (Top 5)</div>
    <div class="card-body">
      <ul id="rankingList" class="list-group"></ul>
    </div>
  </div>

</div>


<script>
let chartRef = [];

function getData() {
  const users = Object.keys(localStorage)
    .filter(k => k.startsWith("user__"))
    .map(k => JSON.parse(localStorage.getItem(k)));

  const presensi = Object.keys(localStorage)
    .filter(k => k.startsWith("presensi__"))
    .map(k => JSON.parse(localStorage.getItem(k)));

  return { users, presensi };
}

// Warna jabatan
const jobColors = ["#3056D3","#5A8DEE","#FF6B6B","#FFA447","#00C49A","#845EC2","#2C73D2","#FFC75F","#F9F871"];

function populateFilter(users) {
  const select = document.getElementById("filterJabatan");
  select.innerHTML = '<option value="all">Semua Jabatan</option>';
  [...new Set(users.map(u => u.jabatan || "Tidak Ada"))].forEach(j => {
    select.innerHTML += `<option value="${j}">${j}</option>`;
  });
}

function updateStatistics(users, presensi) {
  const today = new Date().toISOString().slice(0, 10);
  const hadir = presensi.filter(p => (p.tanggal || p.time?.split(" ")[0]) === today).length;
  const izin = Object.keys(localStorage).filter(k => k.startsWith("izin__"))
    .map(k => JSON.parse(localStorage.getItem(k)))
    .filter(i => i.tanggal === today).length;

  document.getElementById("statTotalUser").innerText = users.length;
  document.getElementById("statHadirHariIni").innerText = hadir;
  document.getElementById("statIzinHariIni").innerText = izin;
  document.getElementById("statAlphaHariIni").innerText = Math.max(users.length - hadir - izin, 0);
}

function updateRanking(users, presensi) {
  const count = {};
  presensi.forEach(p => count[p.emp_id] = (count[p.emp_id] || 0) + 1);

  const ranking = Object.entries(count)
    .map(([id, total]) => {
      const u = users.find(x => x.id == id);
      return u ? { nama: u.nama, total } : null;
    })
    .filter(Boolean)
    .sort((a, b) => b.total - a.total)
    .slice(0, 5);

  document.getElementById("rankingList").innerHTML =
    ranking.map(r => `<li class="list-group-item d-flex justify-content-between">
      <span>${r.nama}</span><strong>${r.total} hari</strong></li>`).join('');
}

function renderDashboard() {
  chartRef.forEach(c => c.destroy()); chartRef = [];

  const { users, presensi } = getData();
  const filter = filterJabatan.value;
  const filteredUsers = filter === "all" ? users : users.filter(u => u.jabatan === filter);

  const jabatanCount = {};
  filteredUsers.forEach(u => jabatanCount[u.jabatan] = (jabatanCount[u.jabatan] || 0) + 1);

  chartRef.push(new ApexCharts(chartUsersPie, {
    chart: { type: 'pie' },
    series: Object.values(jabatanCount),
    labels: Object.keys(jabatanCount),
    colors: jobColors
  }).render());

  const presensiPerHari = {};
  presensi.forEach(p => {
    const t = p.tanggal || p.time?.split(" ")[0];
    presensiPerHari[t] = (presensiPerHari[t] || 0) + 1;
  });

  chartRef.push(new ApexCharts(chartLinePresensi, {
    chart: { type: 'line', height: 300 },
    stroke: { curve: 'smooth', width: 3 },
    series: [{ name: 'Presensi', data: Object.values(presensiPerHari) }],
    xaxis: { categories: Object.keys(presensiPerHari) }
  }).render());

  const presensiByJabatan = {};
  presensi.forEach(p => {
    const u = users.find(x => x.id == p.emp_id);
    if (u) presensiByJabatan[u.jabatan] = (presensiByJabatan[u.jabatan] || 0) + 1;
  });

  chartRef.push(new ApexCharts(chartBarJabatan, {
    chart: { type: "bar", height: 300 },
    series: [{ data: Object.values(presensiByJabatan) }],
    xaxis: { categories: Object.keys(presensiByJabatan) },
    colors: jobColors
  }).render());

  chartRef.push(new ApexCharts(chartSunburst, {
    chart: { type: 'treemap', height: 300 },
    series: [{ data: Object.keys(jabatanCount).map(j => ({ x: j, y: jabatanCount[j] })) }],
    colors: jobColors
  }).render());

  updateStatistics(users, presensi);
  updateRanking(users, presensi);
}

function refreshDashboard() { renderDashboard(); }

document.addEventListener("DOMContentLoaded", () => {
  const { users } = getData();
  populateFilter(users);
  renderDashboard();
});
</script>

@endsection
