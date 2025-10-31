@extends('admin.layout')

@section('title', 'Data Pengguna')

@section('content')
<div class="container-fluid">
  
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">👥 Data Pengguna</h4>
    <button id="exportUserBtn" class="btn btn-success btn-sm">
      <i class="fa fa-file-excel me-1"></i> Ekspor Excel
    </button>
  </div>
  
  <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari berdasarkan Nama, Username, atau Tanggal Daftar...">
  </div>
  
  <table class="table table-hover table-bordered align-middle bg-white shadow-sm" id="userTable">
    <thead class="table-primary">
      <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Password</th>
        <th>Tanggal Daftar</th>
      </tr>
    </thead>
    <tbody id="userTableBody"></tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById('userTableBody');
    const exportBtn = document.getElementById('exportUserBtn');
    // Ambil elemen search input
    const searchInput = document.getElementById('searchInput'); 
    
    // 1. Ambil & simpan semua data user ke dalam array untuk mempermudah pencarian
    const userKeys = Object.keys(localStorage).filter(k => k.startsWith("user__"));
    let allUsers = []; 
    let i = 1; // Counter untuk No dan ID

    userKeys.forEach(key => {
        const data = JSON.parse(localStorage.getItem(key));
        const username = data.username || key.replace('user__', '');
        
        allUsers.push({
            no: i++,
            id: i - 1, // ID Numerik Sequential
            nama: data.fullname || '-',
            username: username,
            password: data.password || '-',
            tanggalDaftar: data.tanggalDaftar || 'Belum Terdaftar'
        });
    });

    // 2. Fungsi untuk me-render data ke tabel
    function renderTable(users) {
        tbody.innerHTML = ''; 
        if (users.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Tidak ada data pengguna ditemukan.</td></tr>`;
            return;
        }

        const rows = users.map(user => `
            <tr>
                <td>${user.no}</td>
                <td>${user.id}</td>
                <td>${user.nama}</td>
                <td>${user.username}</td>
                <td>${user.password}</td>
                <td>${user.tanggalDaftar}</td>
            </tr>
        `).join('');
        tbody.innerHTML = rows;
    }
    
    // Render data awal
    renderTable(allUsers);
    
    // Menonaktifkan tombol ekspor jika kosong
    exportBtn.disabled = (allUsers.length === 0);

    // 3. Fungsi Pencarian Real-time
    searchInput.addEventListener("input", (e) => {
        const keyword = e.target.value.toLowerCase();
        
        // Filter array allUsers
        const filteredUsers = allUsers.filter(user =>
            user.nama.toLowerCase().includes(keyword) ||
            user.username.toLowerCase().includes(keyword) ||
            user.tanggalDaftar.toLowerCase().includes(keyword)
        );
        
        // Render ulang tabel dengan data yang sudah difilter
        renderTable(filteredUsers);
    });

    // 4. Fungsi Ekspor ke Excel (Tidak ada perubahan pada logika ini)
    exportBtn.addEventListener("click", () => {
        if (allUsers.length === 0) {
            alert("Tidak ada data untuk diekspor.");
            return;
        }
        const table = document.getElementById("userTable");
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Data Pengguna");
        
        const date = new Date().toLocaleDateString('id-ID').replace(/\//g, '-');
        XLSX.writeFile(wb, `Data_Pengguna_${date}.xlsx`);
    });
});
</script>
@endsection