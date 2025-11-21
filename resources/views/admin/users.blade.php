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
    <input type="text" id="searchInput" class="form-control"
      placeholder="🔍 Cari berdasarkan Nama, Username, atau Tanggal Daftar...">
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
        <th class="text-center">Aksi</th>
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
    const searchInput = document.getElementById('searchInput');

    const userKeys = Object.keys(localStorage).filter(k => k.startsWith("user__"));
    let allUsers = [];
    let index = 1;

    userKeys.forEach(key => {
        const data = JSON.parse(localStorage.getItem(key));
        const username = data.username || key.replace('user__', '');

        allUsers.push({
            key: key,
            no: index++,
            id: index - 1,
            nama: data.fullname || '-',
            username: username,
            password: data.password || '-',
            tanggalDaftar: data.tanggalDaftar || 'Belum Terdaftar'
        });
    });

    function renderTable(users) {
        tbody.innerHTML = '';
        if (users.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Tidak ada data pengguna ditemukan.</td></tr>`;
            return;
        }

        tbody.innerHTML = users.map(user => `
            <tr>
                <td>${user.no}</td>
                <td>${user.id}</td>
                <td>${user.nama}</td>
                <td>${user.username}</td>
                <td>${user.password}</td>
                <td>${user.tanggalDaftar}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-primary me-1" onclick="editUser('${user.key}')">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-danger" onclick="deleteUser('${user.key}')">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
            </tr>
        `).join('');
    }

    renderTable(allUsers);
    exportBtn.disabled = (allUsers.length === 0);

    searchInput.addEventListener("input", e => {
        const keyword = e.target.value.toLowerCase();
        const filtered = allUsers.filter(user =>
            user.nama.toLowerCase().includes(keyword) ||
            user.username.toLowerCase().includes(keyword) ||
            user.tanggalDaftar.toLowerCase().includes(keyword)
        );
        renderTable(filtered);
    });

    exportBtn.addEventListener("click", () => {
        if (allUsers.length === 0) return alert("Tidak ada data untuk diekspor.");
        const table = document.getElementById("userTable");
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Data Pengguna");
        const date = new Date().toLocaleDateString('id-ID').replace(/\//g, '-');
        XLSX.writeFile(wb, `Data_Pengguna_${date}.xlsx`);
    });

    // ---- DELETE USER ----
    window.deleteUser = function(key) {
      if (!confirm("Yakin ingin menghapus data pengguna ini?")) return;
      localStorage.removeItem(key);
      location.reload();
    }

    // ---- EDIT USER (redirect / modal) ----
    window.editUser = function(key) {
      // contoh redirect ke halaman edit
      window.location.href = `/admin/user/edit/${key.replace('user__','')}`;
    }
});
</script>
@endsection
