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
      padding: 10px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #457b9d;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
  </style>
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
    <a href="#" id="logoutAdmin"><i class="fa fa-sign-out-alt me-2"></i> Keluar</a>
  </div>

  <!-- Main Content -->
  <div class="content">
    <nav class="navbar navbar-expand navbar-light mb-4">
      <div class="container-fluid">
        <span class="navbar-text fw-semibold text-primary" id="adminName">Admin</span>
      </div>
    </nav>

    @yield('content')
  </div>

  <script>
  // --- Proteksi login admin
  document.addEventListener('DOMContentLoaded', () => {
    const loggedAdmin = localStorage.getItem('loggedAdmin');
    if (!loggedAdmin) {
      alert('⚠️ Anda harus login terlebih dahulu!');
      window.location.href = "{{ url('/admin/login') }}";
      return;
    }
    const adminData = JSON.parse(localStorage.getItem('admin__' + loggedAdmin));
    if (adminData && adminData.fullname) {
      document.getElementById('adminName').textContent = adminData.fullname;
    }

    document.getElementById('logoutAdmin').addEventListener('click', () => {
      if (confirm('Yakin ingin keluar dari akun admin?')) {
        localStorage.removeItem('loggedAdmin');
        window.location.href = "{{ url('/admin/login') }}";
      }
    });
  });
  </script>
</body>
</html>
