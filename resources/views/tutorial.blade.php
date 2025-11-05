<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tutorial Penggunaan | Aplikasi Presensi Karyawan</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fc;
      font-family: "Roboto", sans-serif;
    }
    .card {
      border: none;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
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

  <div class="container mt-5 mb-4">
    <div class="card p-4">
      <div class="text-center mb-4">
        <h4 class="text-primary fw-bold"><i class="fa-solid fa-book me-2"></i>Tutorial Penggunaan</h4>
        <p class="text-muted mb-0">Panduan singkat untuk menggunakan aplikasi presensi PT. Muncul Perdana Printindo.</p>
      </div>

      <div class="accordion" id="tutorialAccordion" style="max-width:700px;margin:auto;">

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#step1">
              1. Registrasi Akun
            </button>
          </h2>
          <div id="step1" class="accordion-collapse collapse show" data-bs-parent="#tutorialAccordion">
            <div class="accordion-body">
              Klik menu <b>Registrasi</b>, isi nama dan kata sandi Anda, lalu tekan <b>Daftar Akun</b>. 
              Setelah berhasil, lanjutkan ke menu <b>Masuk</b>.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#step2">
              2. Login ke Sistem
            </button>
          </h2>
          <div id="step2" class="accordion-collapse collapse" data-bs-parent="#tutorialAccordion">
            <div class="accordion-body">
              Masuk ke menu <b>Masuk</b>, isi nama dan kata sandi yang sudah didaftarkan, lalu tekan tombol <b>Masuk ke Dashboard</b>.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#step3">
              3. Gunakan Sistem Presensi
            </button>
          </h2>
          <div id="step3" class="accordion-collapse collapse" data-bs-parent="#tutorialAccordion">
            <div class="accordion-body">
              Setelah login, Anda akan pergi ke menu sistem presensi dan akan melihat dua tombol utama: <b>Check In</b> dan <b>Check Out</b> untuk mencatat jam masuk dan keluar.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#step4">
              4. Mengajukan Izin
            </button>
          </h2>
          <div id="step4" class="accordion-collapse collapse" data-bs-parent="#tutorialAccordion">
            <div class="accordion-body">
              Pilih menu <b>Izin</b>, tulis alasan Anda (misal: sakit, urusan keluarga), lalu tekan tombol <b>Kirim</b>.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#step5">
              5. Melaporkan Keterlambatan
            </button>
          </h2>
          <div id="step5" class="accordion-collapse collapse" data-bs-parent="#tutorialAccordion">
            <div class="accordion-body">
              Jika Anda datang terlambat, buka menu <b>Telat</b>, tulis alasan keterlambatan, dan kirim formulirnya.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#step6">
              6. Logout
            </button>
          </h2>
          <div id="step6" class="accordion-collapse collapse" data-bs-parent="#tutorialAccordion">
            <div class="accordion-body">
              Klik foto profil di kanan atas dan pilih <b>Keluar</b> untuk menutup sesi Anda.
            </div>
          </div>
        </div>

      </div>

      <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="btn btn-secondary">
          <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Aplikasi
        </a>
      </div>
    </div>
  </div>

  <footer class="text-center text-muted mb-3">
    <small>© 2025 Aplikasi Presensi PT. Muncul Perdana Printindo | Dibangun dengan Bootstrap 5</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
