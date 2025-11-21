@extends('admin.layout')

@section('title', 'Track Telat & Konfirmasi Izin')

@section('content')
<div class="container-fluid">

  <h4 class="fw-bold text-secondary mb-4">📍 Track Telat & Konfirmasi Izin</h4>

  <ul class="nav nav-tabs mb-3" id="trackTabs">
    <li class="nav-item">
      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabTelat">⏰ Telat</button>
    </li>
    <li class="nav-item">
      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabIzin">📝 Konfirmasi Izin</button>
    </li>
  </ul>

  <div class="tab-content">

    <div class="tab-pane fade show active" id="tabTelat">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold">Daftar Karyawan Telat</div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Selisih</th>
              </tr>
            </thead>
            <tbody id="tableTelat"></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="tabIzin">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold">Riwayat Konfirmasi Izin</div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Alasan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="tableIzin"></tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
function loadTrack() {
  const users = Object.keys(localStorage)
    .filter(k => k.startsWith("user__"))
    .map(k => JSON.parse(localStorage.getItem(k)));

  const presensiTelat = Object.keys(localStorage)
    .filter(k => k.startsWith("late__"))
    .map(k => JSON.parse(localStorage.getItem(k)));

  const izin = Object.keys(localStorage)
    .filter(k => k.startsWith("izin__"))
    .map(k => JSON.parse(localStorage.getItem(k)));

  const tbodyTelat = document.getElementById("tableTelat");
  tbodyTelat.innerHTML = presensiTelat.map(t => {
    const u = users.find(x => x.id == t.emp_id);
    return `<tr>
      <td>${u?.nama || "-"}</td>
      <td>${t.tanggal}</td>
      <td>${t.jam_masuk}</td>
      <td class="text-danger fw-bold">${t.selisih}</td>
    </tr>`;
  }).join('');

  const tbodyIzin = document.getElementById("tableIzin");
  tbodyIzin.innerHTML = izin.map(i => {
    const u = users.find(x => x.id == i.emp_id);
    const statusBadge = i.status === "diterima"
      ? `<span class="badge bg-success">Diterima</span>`
      : `<span class="badge bg-warning text-dark">Pending</span>`;

    return `<tr>
      <td>${u?.nama || "-"}</td>
      <td>${i.tanggal}</td>
      <td>${i.alasan}</td>
      <td>${statusBadge}</td>
    </tr>`;
  }).join('');
}

document.addEventListener("DOMContentLoaded", loadTrack);
</script>

@endsection
