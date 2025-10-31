<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register User | Presensi Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #eef2f7;
      font-family: 'Roboto', sans-serif;
    }
    .register-card {
      max-width: 420px;
      margin: 80px auto;
      border: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 12px;
    }
  </style>
</head>
<body>
  <div class="card register-card p-4">
    <h4 class="text-center mb-3 text-success fw-semibold">Daftar Karyawan</h4>
    <p class="text-center text-muted mb-4">Buat akun untuk presensi</p>

    <form id="registerForm">
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" id="fullname" class="form-control" placeholder="Masukkan nama lengkap" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Buat username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Buat password" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Daftar</button>
      <p class="text-center mt-3 mb-0 text-muted">
        Sudah punya akun? <a href="{{ url('/login') }}" class="text-success">Login di sini</a>
      </p>
    </form>
  </div>

  <script>
  document.getElementById('registerForm').addEventListener('submit', e => {
    e.preventDefault();
    const fullname = document.getElementById('fullname').value.trim();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (localStorage.getItem('user__' + username)) {
      alert('❌ Username sudah digunakan!');
      return;
    }

    // MODIFIKASI: Mendapatkan tanggal hari ini dalam format DD/MM/YYYY
    const today = new Date().toLocaleDateString('id-ID', {
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric'
    }); 
    
    // Menambahkan tanggal daftar ke objek user
    const newUser = { 
        fullname, 
        username, 
        password,
        tanggalDaftar: today // <--- Data Tanggal Disimpan di sini
    };
    
    localStorage.setItem('user__' + username, JSON.stringify(newUser));
    alert('✅ Registrasi berhasil! Silakan login.');
    window.location.href = "{{ url('/login') }}";
  });
  </script>
</body>
</html>