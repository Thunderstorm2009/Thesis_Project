<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Pengguna | Presensi Karyawan</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f9;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      background-color: #1d3557;
      color: white;
      display: flex;
      flex-direction: column;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #457b9d;
    }
    .sidebar .header {
      text-align: center;
      padding: 20px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar .header h4 {
      margin: 0;
      font-weight: bold;
    }

    /* Main content */
    .content {
      margin-left: 250px;
      padding: 20px;
    }

    /* Navbar */
    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* Profile avatar di navbar */
    #navProfileImg {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background-color: #1d3557;
      color: #fff;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      background-size: cover;
      background-position: center;
      margin-right: 8px;
    }

    /* Card */
    .card {
      border: none;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
      border-radius: 16px;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #1d3557;
    }

    .btn-primary {
      background-color: #1d3557;
      border-color: #1d3557;
    }

    .btn-primary:hover {
      background-color: #457b9d;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="header">
      <h4>Panel Karyawan</h4>
    </div>
    <a href="{{ url('/') }}"><i class="fa fa-house me-2"></i> Dashboard</a>
    <a href="{{ url('/izin') }}"><i class="fa fa-user-times me-2"></i> Izin</a>
    <a href="{{ url('/telat') }}"><i class="fa fa-clock me-2"></i> Telat</a>
    <a href="{{ url('/tutorial') }}"><i class="fa fa-book me-2"></i> Tutorial</a>
    <a href="{{ url('/profile') }}" class="bg-primary"><i class="fa fa-user me-2"></i> Profil</a>
    <a href="#" id="logoutBtn" class="mt-auto border-top border-light"><i class="fa fa-sign-out-alt me-2"></i> Keluar</a>
  </div>

  <!-- Main content -->
  <div class="content">
    <nav class="navbar navbar-expand navbar-light mb-4">
      <div class="container-fluid d-flex justify-content-end align-items-center">
        <div class="d-flex align-items-center">
          <div id="navProfileImg">U</div>
          <span id="navProfileName" class="fw-semibold text-primary"></span>
        </div>
      </div>
    </nav>

    <div class="container">
      <h2 class="mb-4 text-center">👤 Profil Pengguna</h2>

      <div class="card p-4 mx-auto" style="max-width:600px;">
        <div class="text-center mb-4">
          <img id="profilePreview" class="profile-img" src="https://via.placeholder.com/120x120?text=Foto" alt="Foto Profil">
          <div class="mt-2">
            <input type="file" id="photoInput" accept="image/*" class="form-control mt-2" style="max-width:300px;margin:auto;">
          </div>
        </div>

        <form id="profileForm">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullname" placeholder="Masukkan nama lengkap" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">💾 Simpan Perubahan</button>
        </form>
      </div>
    </div>

    <footer class="text-center text-muted mt-5 mb-3">
      <small>© 2025 Aplikasi Presensi PT. Muncul Perdana Printindo</small>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const LS_LOGGED = 'loggedInUser';

    document.addEventListener("DOMContentLoaded", () => {
      const currentUser = localStorage.getItem(LS_LOGGED);
      if (!currentUser) {
        window.location.href = "{{ url('/login') }}";
        return;
      }

      const userKey = "user__" + currentUser;
      const userData = JSON.parse(localStorage.getItem(userKey)) || {};

      const fullnameInput = document.getElementById("fullname");
      const photoInput = document.getElementById("photoInput");
      const profilePreview = document.getElementById("profilePreview");
      const navProfileImg = document.getElementById("navProfileImg");
      const navProfileName = document.getElementById("navProfileName");

      fullnameInput.value = userData.fullname || currentUser;
      if (userData.photo) {
        profilePreview.src = userData.photo;
        navProfileImg.style.backgroundImage = `url(${userData.photo})`;
        navProfileImg.textContent = "";
      } else {
        navProfileImg.textContent = currentUser.charAt(0).toUpperCase();
      }

      navProfileName.textContent = userData.fullname || currentUser;

      // Ganti foto
      photoInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = evt => profilePreview.src = evt.target.result;
        reader.readAsDataURL(file);
      });

      // Simpan perubahan
      document.getElementById("profileForm").addEventListener("submit", (e) => {
        e.preventDefault();
        userData.fullname = fullnameInput.value.trim();
        userData.photo = profilePreview.src;
        localStorage.setItem(userKey, JSON.stringify(userData));

        alert("✅ Profil berhasil disimpan!");
        window.location.href = "{{ url('/') }}";
      });

      // Logout
      document.getElementById("logoutBtn").addEventListener("click", () => {
        if (confirm("Yakin ingin keluar?")) {
          localStorage.removeItem(LS_LOGGED);
          window.location.href = "{{ url('/login') }}";
        }
      });
    });
  </script>
</body>
</html>
