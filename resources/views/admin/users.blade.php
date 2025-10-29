@extends('admin.layout')

@section('title', 'Data Pengguna')

@section('content')
<div class="container-fluid">
  <h4 class="fw-bold mb-4">👥 Data Pengguna</h4>
  <table class="table table-hover table-bordered align-middle bg-white shadow-sm">
    <thead class="table-primary">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Tanggal Daftar</th>
      </tr>
    </thead>
    <tbody id="userTableBody"></tbody>
  </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const tbody = document.getElementById('userTableBody');
  const userKeys = Object.keys(localStorage).filter(k => k.startsWith("user__"));
  let i = 1;
  userKeys.forEach(key => {
    const data = JSON.parse(localStorage.getItem(key));
    const row = `<tr>
      <td>${i++}</td>
      <td>${data.nama || '-'}</td>
      <td>${data.username || key.replace('user__', '')}</td>
      <td>${data.tanggalDaftar || '-'}</td>
    </tr>`;
    tbody.insertAdjacentHTML('beforeend', row);
  });
});
</script>
@endsection
