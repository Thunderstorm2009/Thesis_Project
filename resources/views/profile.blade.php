<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Pengguna | Presensi Karyawan</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fc;
      font-family: "Roboto", sans-serif;
    }
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
      border: 3px solid #4e73df;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand fw-semibold" href="{{ url('/') }}">
        <i class="bi bi-person-circle me-2"></i>Profil Pengguna
      </a>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link text-white">🏠 Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="#" id="logoutBtn" class="nav-link text-warning">🚪 Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main -->
  <div class="container mt-5">
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

    fullnameInput.value = userData.fullname || currentUser;
    if (userData.photo) profilePreview.src = userData.photo;

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
