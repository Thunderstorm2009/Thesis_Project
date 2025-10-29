<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Aplikasi Presensi Karyawan</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fc;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: "Roboto", sans-serif;
    }
    .login-card {
      width: 100%;
      max-width: 400px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 30px;
    }
    .btn-primary {
      background-color: #4e73df;
      border-color: #4e73df;
    }
    .btn-primary:hover {
      background-color: #375ac3;
    }
  </style>
</head>
<body>

  <div class="login-card text-center">
    <h4 class="fw-bold text-primary mb-3">
      <i class="fa-solid fa-calendar-check me-2"></i>Login Presensi
    </h4>
    <p class="text-muted mb-4">Masuk ke sistem presensi PT. Muncul Perdana Printindo</p>

    <form id="loginForm">
      <div class="mb-3 text-start">
        <label class="form-label fw-semibold">Nama Pengguna</label>
        <input type="text" id="username" class="form-control" placeholder="Masukkan nama pengguna" required>
      </div>
      <div class="mb-3 text-start">
        <label class="form-label fw-semibold">Kata Sandi</label>
        <input type="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
      </div>
      <button type="submit" id="loginButton" class="btn btn-primary w-100 mb-3">
        <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
      </button>
      <p class="text-muted">Belum punya akun? <a href="{{ url('/register') }}" class="text-primary fw-semibold">Daftar di sini</a></p>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const LS_LOGGED = 'loggedInUser';
    const LS_USERS_PREFIX = 'user__';

    document.addEventListener('DOMContentLoaded', () => {
      // Jika sudah login, langsung arahkan ke dashboard
      const currentUser = localStorage.getItem(LS_LOGGED);
      if (currentUser) {
        window.location.href = "{{ url('/') }}";
      }
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const username = document.getElementById('username').value.trim();
      const password = document.getElementById('password').value.trim();

      if (!username || !password) {
        alert('Silakan isi semua kolom!');
        return;
      }

      // Ambil data user dari localStorage
      const savedUser = localStorage.getItem(LS_USERS_PREFIX + username);
      if (!savedUser) {
        alert('Akun tidak ditemukan! Silakan daftar terlebih dahulu.');
        return;
      }

      const userData = JSON.parse(savedUser);
      if (userData.password !== password) {
        alert('Kata sandi salah!');
        return;
      }

      // Simpan sesi login
      localStorage.setItem(LS_LOGGED, username);

      // Arahkan ke dashboard (welcome)
      window.location.href = "{{ url('/') }}";
    });
  </script>

</body>
</html>
