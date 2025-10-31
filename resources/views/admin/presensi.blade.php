@extends('admin.layout')

@section('title', 'Data Presensi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">📅 Daftar Presensi</h5>
        <div class="d-flex gap-2">
            <select id="monthFilter" class="form-select form-select-sm" style="width: 150px;">
                <option value="">Semua Bulan</option>
            </select>
            
            <button id="exportBtn" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel me-1"></i> Ekspor Excel
            </button>
        </div>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari berdasarkan nama, kegiatan, atau alasan...">
    </div>

    <table class="table table-bordered table-hover align-middle" id="presensiTable">
        <thead class="table-success text-center">
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 5%">ID</th> 
                <th style="width: 13%">Nama</th>
                <th style="width: 12%">Kegiatan</th>
                <th style="width: 13%">Bulan</th> <th style="width: 25%">Waktu</th>
                <th style="width: 27%">Alasan</th>
            </tr>
        </thead>
        <tbody id="presensiTableBody"></tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("presensiTableBody");
    const searchInput = document.getElementById("searchInput");
    const monthFilter = document.getElementById("monthFilter");
    const exportBtn = document.getElementById("exportBtn");

    const presensiKeys = Object.keys(localStorage).filter(k => k.startsWith("presensi__"));
    let allPresensiRecords = [];
    
    // Array nama bulan untuk konversi indeks bulan (0-11) ke nama bulan
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];


    // Helper function untuk memproses data dari localStorage
    presensiKeys.forEach((key, index) => {
        // key: presensi__nama__recordId
        const [_, username] = key.split("__"); 
        const record = JSON.parse(localStorage.getItem(key));
        
        if (record) {
            // Mengambil ID Karyawan
            const idKaryawan = record.id || record.idKaryawan || username; 

            // Mengambil waktu. Format: DD/MM/YYYY HH:MM:SS
            const waktuString = record.timeSubmitted || record.time || "01/01/1970 00:00:00"; 
            
            const parts = waktuString.split(' ')[0].split('/');
            // Membuat objek Date: new Date(YYYY, MM-1, DD)
            const date = new Date(parts[2], parts[1] - 1, parts[0]); 
            
            // Mengambil indeks bulan (0-11) dan nama bulan
            const monthIndex = isNaN(date.getMonth()) ? -1 : date.getMonth();
            const monthName = monthIndex >= 0 ? months[monthIndex] : 'Tidak Valid';
            
            allPresensiRecords.push({
                no: index + 1,
                id: idKaryawan, 
                nama: record.name || username,
                kegiatan: record.action,
                waktu: waktuString,
                alasan: record.reason || "-",
                // Data untuk Filtering dan Kolom Bulan
                dateObject: date,
                month: monthIndex, 
                monthName: monthName // NAMA BULAN UNTUK DITAMPILKAN DI KOLOM
            });
        }
    });

    // 1. Mengisi Dropdown Filter Bulan
    months.forEach((name, index) => {
        // Nilai (value) adalah indeks bulan (0-11)
        monthFilter.insertAdjacentHTML('beforeend', `<option value="${index}">${name}</option>`);
    });

    // Fungsi untuk me-render data ke tabel
    function renderTable(data) {
        // Kolom di tabel sekarang 7 (No, ID, Nama, Kegiatan, Bulan, Waktu, Alasan)
        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Tidak ada data presensi ditemukan.</td></tr>`;
            return;
        }
        
        // Perbarui nomor urut setelah filtering
        data = data.map((d, index) => ({...d, no: index + 1}));

        tbody.innerHTML = data.map(d => `
            <tr>
                <td class="text-center">${d.no}</td>
                <td class="text-center">${d.id}</td>
                <td>${d.nama}</td>
                <td class="text-center">${d.kegiatan}</td>
                <td class="text-center">${d.monthName}</td> <td>${d.waktu}</td>
                <td>${d.alasan}</td>
            </tr>
        `).join("");
    }

    // Fungsi Filtering Utama
    function filterAndRender() {
        const keyword = searchInput.value.toLowerCase();
        const selectedMonth = monthFilter.value;
        
        let filtered = allPresensiRecords;

        // 1. Filter berdasarkan Search Input
        if (keyword) {
            filtered = filtered.filter(d =>
                d.nama.toLowerCase().includes(keyword) ||
                d.kegiatan.toLowerCase().includes(keyword) ||
                d.alasan.toLowerCase().includes(keyword)
            );
        }

        // 2. Filter berdasarkan Bulan
        if (selectedMonth !== "") {
            const monthIndex = parseInt(selectedMonth);
            filtered = filtered.filter(d => d.month === monthIndex);
        }
        
        renderTable(filtered);
    }

    // Render awal
    renderTable(allPresensiRecords);

    // Event Listeners untuk Search dan Filter
    searchInput.addEventListener("input", filterAndRender);
    monthFilter.addEventListener("change", filterAndRender);

    // 📤 Ekspor ke Excel
    exportBtn.addEventListener("click", () => {
        // Mengambil data yang sedang ditampilkan (sudah difilter) dari tabel HTML
        const table = document.getElementById("presensiTable");
        const ws = XLSX.utils.table_to_sheet(table); 
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, ws, "Data Presensi");

        const now = new Date().toLocaleDateString("id-ID").replace(/\//g, "-");
        XLSX.writeFile(workbook, `Data_Presensi_Bulan_Terfilter_${now}.xlsx`);
    });
});
</script>
@endsection