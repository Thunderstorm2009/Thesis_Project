<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin | Presensi Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Roboto', sans-serif;
    }
    .login-card {
      max-width: 400px;
      margin: 80px auto;
      border: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 12px;
    }
  </style>
</head>
<body>
  <div class="card login-card p-4">
    <h4 class="text-center mb-3 text-primary fw-semibold">Login Admin</h4>
    <p class="text-center text-muted mb-4">Masuk ke dashboard administrator</p>

    <form id="loginForm">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Masukkan username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Masuk</button>
      <p class="text-center mt-3 mb-0 text-muted">
        Belum punya akun? <a href="{{ url('/admin/register') }}" class="text-primary">Daftar di sini</a>
      </p>
    </form>
  </div>

  <script>
  document.getElementById('loginForm').addEventListener('submit', e => {
    e.preventDefault();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    const adminData = JSON.parse(localStorage.getItem('admin__' + username));

    if (!adminData) return alert('Akun tidak ditemukan!');
    if (adminData.password !== password) return alert('Password salah!');

    localStorage.setItem('loggedAdmin', username);
    alert('✅ Login berhasil!');
    window.location.href = "{{ url('/admin/dashboard') }}";
  });
  </script>
</body>
</html>
