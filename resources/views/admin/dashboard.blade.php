@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
  <h4 class="fw-bold mb-4">📊 Dashboard Statistik</h4>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="fa fa-users fa-2x text-primary mb-2"></i>
          <h5>Total Pengguna</h5>
          <p class="fs-3 fw-bold text-dark" id="totalUsers">0</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="fa fa-calendar-check fa-2x text-success mb-2"></i>
          <h5>Total Presensi</h5>
          <p class="fs-3 fw-bold text-dark" id="totalPresensi">0</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const users = Object.keys(localStorage).filter(k => k.startsWith("user__"));
  const presensi = Object.keys(localStorage).filter(k => k.startsWith("presensi__"));
  
  document.getElementById("totalUsers").textContent = users.length;
  document.getElementById("totalPresensi").textContent = presensi.length;
});
</script>
@endsection
