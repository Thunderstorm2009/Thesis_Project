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
      font-family: "Poppins", sans-serif;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.10);
    }

    h4 {
      font-weight: 700;
    }

    /* Warna berbeda saat step dibuka */
    button[data-bs-target="#step1"].accordion-button:not(.collapsed),
    #step1.accordion-collapse.show .accordion-body {
      background-color:#4e73df !important; color:white !important;
    }

    button[data-bs-target="#step2"].accordion-button:not(.collapsed),
    #step2.accordion-collapse.show .accordion-body {
      background-color:#1cc88a !important; color:white !important;
    }

    button[data-bs-target="#step3"].accordion-button:not(.collapsed),
    #step3.accordion-collapse.show .accordion-body {
      background-color:#36b9cc !important; color:white !important;
    }

    button[data-bs-target="#step4"].accordion-button:not(.collapsed),
    #step4.accordion-collapse.show .accordion-body {
      background-color:#f6c23e !important; color:white !important;
    }

    button[data-bs-target="#step5"].accordion-button:not(.collapsed),
    #step5.accordion-collapse.show .accordion-body {
      background-color:#e74a3b !important; color:white !important;
    }

    button[data-bs-target="#step6"].accordion-button:not(.collapsed),
    #step6.accordion-collapse.show .accordion-body {
      background-color:#858796 !important; color:white !important;
    }

    /* Smooth animation */
    .accordion-button, .accordion-body {
      transition: background-color 0.3s ease, color 0.3s ease;
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
              Masukkan username dan password lalu klik <b>Masuk ke Dashboard</b>.
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
              Gunakan tombol <b>Check In</b> untuk mencatat jam masuk dan <b>Check Out</b> untuk mencatat jam pulang.
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
              Masuk ke menu <b>Izin</b> lalu isi sebab izin seperti sakit atau urusan keluarga.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#step5">
              5. Melaporkan Telat
            </button>
          </h2>
          <div id="step5" class="accordion-collapse collapse" data-bs-parent="#tutorialAccordion">
            <div class="accordion-body">
              Masuk ke menu <b>Telat</b> untuk mengajukan alasan keterlambatan.
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
              Klik foto profil di kanan atas dan pilih <b>Keluar</b>.
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
