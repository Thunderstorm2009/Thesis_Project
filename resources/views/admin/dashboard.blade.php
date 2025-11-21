@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

  <h4 class="fw-bold text-secondary mb-3">Dashboard Statistik Presensi</h4>

  <!-- FILTER -->
  <div class="card shadow-sm p-3 mb-4 border-0">
    <label class="fw-semibold mb-1">Filter Presensi</label>
    <div class="row g-2">
      <div class="col-md-3">
        <select id="filterJabatan" class="form-select" onchange="renderDashboard()">
          <option value="all">Semua Jabatan</option>
        </select>
      </div>
      <div class="col-md-3">
        <select id="filterRange" class="form-select" onchange="renderDashboard()">
          <option value="today">Hari Ini</option>
          <option value="weekly">Mingguan</option>
          <option value="monthly">Bulanan</option>
          <option value="custom">Pilih Tanggal</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="date" id="filterTanggal" class="form-control" style="display:none;" onchange="renderDashboard()">
      </div>
    </div>
  </div>

  <!-- MAIN TABS -->
  <ul class="nav nav-tabs mb-4">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabOverview">📌 Ikhtisar</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabDistribusi">📊 Distribusi Jabatan</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabTren">📈 Tren Harian</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabPerJabatan">🏢 Per Jabatan</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabRanking">🏆 Ranking</button></li>
  </ul>

  <div class="tab-content">

    <!-- OVERVIEW -->
    <div class="tab-pane fade show active" id="tabOverview">
      <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card shadow-sm p-3 text-center"><h6 class="text-secondary">Total Karyawan</h6><h3 id="statTotalUser" class="fw-bold">0</h3></div></div>
        <div class="col-md-3"><div class="card shadow-sm p-3 text-center"><h6 class="text-secondary">Presensi Hari Ini</h6><h3 id="statHadirHariIni" class="fw-bold text-success">0</h3></div></div>
        <div class="col-md-3"><div class="card shadow-sm p-3 text-center"><h6 class="text-secondary">Telat / Izin Hari Ini</h6><h3 id="statIzinHariIni" class="fw-bold text-warning">0</h3></div></div>
        <div class="col-md-3"><div class="card shadow-sm p-3 text-center"><h6 class="text-secondary">Alpha Hari Ini</h6><h3 id="statAlphaHariIni" class="fw-bold text-danger">0</h3></div></div>
      </div>
    </div>

    <!-- DISTRIBUSI -->
    <div class="tab-pane fade" id="tabDistribusi">
      <div class="row g-3">
        <div class="col-md-6">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-bold">Distribusi Pengguna per Jabatan</div>
            <div class="card-body"><div id="chartUsersPie" style="height:350px"></div></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-bold">Struktur Jabatan (Treemap)</div>
            <div class="card-body"><div id="chartSunburst" style="height:350px"></div></div>
          </div>
        </div>
      </div>
    </div>


    <!-- TREND -->
    <div class="tab-pane fade" id="tabTren">
      <div class="card shadow-sm border-0"><div class="card-header bg-white fw-bold">Tren Total Presensi Harian</div><div class="card-body"><div id="chartLinePresensi" style="height:350px"></div></div></div>
    </div>

    <!-- PER JABATAN -->
    <div class="tab-pane fade" id="tabPerJabatan">
      <div class="card shadow-sm border-0"><div class="card-header bg-white fw-bold">Total Presensi berdasarkan Jabatan</div><div class="card-body"><div id="chartBarJabatan" style="height:350px"></div></div></div>
    </div>

    <!-- RANKING -->
    <div class="tab-pane fade" id="tabRanking">
      <div class="card shadow-sm border-0"><div class="card-header bg-white fw-bold">Ranking Kehadiran (Top 5)</div><div class="card-body"><ul id="rankingList" class="list-group"></ul></div></div>
    </div>

  </div>
</div>

<script>
let chartRef = [];

function getData() {
  const users = Object.keys(localStorage).filter(k => k.startsWith("user__")).map(k => JSON.parse(localStorage.getItem(k)));
  const presensi = Object.keys(localStorage).filter(k => k.startsWith("presensi__")).map(k => JSON.parse(localStorage.getItem(k)));
  return { users, presensi };
}

const jobColors = ["#3056D3","#5A8DEE","#FF6B6B","#FFA447","#00C49A","#845EC2","#2C73D2","#FFC75F","#F9F871"];

function populateFilter(users) {
  const select = document.getElementById("filterJabatan");
  select.innerHTML = '<option value="all">Semua Jabatan</option>';
  [...new Set(users.map(u => u.jabatan || "Tidak Ada"))].forEach(j =>
    select.innerHTML += `<option value="${j}">${j}</option>`
  );
}

function renderDashboard() {
  chartRef.forEach(c => c.destroy()); chartRef = [];
  const { users } = getData();
  populateFilter(users);
}

document.addEventListener("DOMContentLoaded", renderDashboard);
</script>

@endsection
