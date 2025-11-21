<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | Panel Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f9;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      background-color: #1d3557;
      color: white;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 13px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background-color: #457b9d;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    .navbar-name-small {
      font-size: 14px !important;
      font-weight: 600;
    }
    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .profile-img-navbar {
      width: 35px;
      height: 35px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ddd;
    }
  </style>

  @yield('head')
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column">
    <div class="text-center py-4 border-bottom border-light">
      <h4 class="fw-bold">Admin Panel</h4>
    </div>

    <a href="{{ url('/admin/dashboard') }}"><i class="fa fa-chart-line me-2"></i> Dashboard</a>
    <a href="{{ url('/admin/users') }}"><i class="fa fa-users me-2"></i> Data Pengguna</a>
    <a href="{{ url('/admin/presensi') }}"><i class="fa fa-calendar-check me-2"></i> Data Presensi</a>
    <a href="{{ url('/admin/track') }}"><i class="fa fa-list-check me-2"></i> Track Telat & Izin</a>
  </div>

  <!-- Content -->
  <div class="content">

    <nav class="navbar navbar-expand navbar-light mb-4">
      <div class="container-fluid">
        
        <!-- Nama + Foto di Kanan -->
        <div class="dropdown ms-auto">
          <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <img id="navbarPhoto" class="profile-img-navbar" src="https://via.placeholder.com/90?text=A">
            <span class="ms-2 text-primary navbar-name-small" id="navbarName">Admin</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ url('/admin/profile') }}"><i class="fa fa-user me-2"></i> Profil</a></li>
            <li><a class="dropdown-item text-danger" href="#" id="logoutBtn"><i class="fa fa-sign-out-alt me-2"></i> Keluar</a></li>
          </ul>
        </div>

      </div>
    </nav>

    @yield('content')

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const loggedAdmin = localStorage.getItem("loggedAdmin");
    if (!loggedAdmin) {
      alert("⚠️ Anda harus login terlebih dahulu!");
      window.location.href = "{{ url('/admin/login') }}";
      return;
    }

    const adminKey = "admin__" + loggedAdmin;
    const adminData = JSON.parse(localStorage.getItem(adminKey)) || {};

    document.getElementById("navbarName").textContent = adminData.fullname || "Admin";
    document.getElementById("navbarPhoto").src = adminData.photo || "https://via.placeholder.com/90?text=A";

    document.getElementById("logoutBtn").addEventListener("click", () => {
      if (confirm("Yakin ingin keluar?")) {
        localStorage.removeItem("loggedAdmin");
        window.location.href = "{{ url('/admin/login') }}";
      }
    });
  });
  </script>

  @yield('scripts')

</body>
</html>
