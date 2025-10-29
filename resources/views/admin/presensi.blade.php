@extends('admin.layout')

@section('title', 'Data Presensi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">📅 Daftar Presensi</h5>
  <button id="exportBtn" class="btn btn-success btn-sm">
    <i class="fa fa-file-excel me-1"></i> Ekspor Excel
  </button>
</div>

<div class="mb-3">
  <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari berdasarkan nama, kegiatan, atau alasan...">
</div>

<table class="table table-bordered table-hover align-middle">
  <thead class="table-success text-center">
    <tr>
      <th style="width: 5%">No</th>
      <th style="width: 20%">Nama</th>
      <th style="width: 15%">Kegiatan</th>
      <th style="width: 25%">Waktu</th>
      <th style="width: 35%">Alasan</th>
    </tr>
  </thead>
  <tbody id="presensiTable"></tbody>
</table>

<!-- SheetJS (untuk ekspor Excel) -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const tbody = document.getElementById("presensiTable");
  const searchInput = document.getElementById("searchInput");
  const exportBtn = document.getElementById("exportBtn");

  // Ambil semua data presensi dari localStorage
  const presensiKeys = Object.keys(localStorage).filter(k => k.startsWith("presensi__"));
  let presensiData = [];

  presensiKeys.forEach((key, index) => {
    const [_, nama] = key.split("__");
    const record = JSON.parse(localStorage.getItem(key));
    if (record) {
      presensiData.push({
        no: index + 1,
        nama,
        kegiatan: record.action,
        waktu: record.time,
        alasan: record.reason || "-"
      });
    }
  });

  // Fungsi render tabel
  function renderTable(data) {
    if (data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>`;
      return;
    }
    tbody.innerHTML = data.map(d => `
      <tr>
        <td class="text-center">${d.no}</td>
        <td>${d.nama}</td>
        <td class="text-center">${d.kegiatan}</td>
        <td>${d.waktu}</td>
        <td>${d.alasan}</td>
      </tr>
    `).join("");
  }

  // Render awal
  renderTable(presensiData);

  // 🔍 Pencarian realtime
  searchInput.addEventListener("input", (e) => {
    const keyword = e.target.value.toLowerCase();
    const filtered = presensiData.filter(d =>
      d.nama.toLowerCase().includes(keyword) ||
      d.kegiatan.toLowerCase().includes(keyword) ||
      d.alasan.toLowerCase().includes(keyword)
    );
    renderTable(filtered);
  });

  // 📤 Ekspor ke Excel
  exportBtn.addEventListener("click", () => {
    if (presensiData.length === 0) {
      alert("Tidak ada data untuk diekspor.");
      return;
    }

    const worksheet = XLSX.utils.json_to_sheet(presensiData);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Data Presensi");

    const now = new Date().toLocaleDateString("id-ID").replace(/\//g, "-");
    XLSX.writeFile(workbook, `Data_Presensi_${now}.xlsx`);
  });
});
</script>
@endsection
