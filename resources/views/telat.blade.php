<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulir Telat | Presensi Karyawan</title>
  
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f1f3f4;
      font-family: 'Roboto', sans-serif;
    }
    .form-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 640px;
      margin: 40px auto;
    }
    .form-title {
      color: #f4b400;
      font-weight: 700;
      text-align: center;
    }
    textarea, input[type="text"], input[type="file"] {
      border: 1px solid #dadce0;
      border-radius: 8px;
      transition: 0.2s;
    }
    textarea:focus, input:focus {
      border-color: #4285f4;
      box-shadow: 0 0 0 3px rgba(66,133,244,0.2);
    }
    .img-preview {
      display: block;
      margin: 10px auto;
      max-height: 180px;
      border-radius: 10px;
      border: 2px dashed #ddd;
      object-fit: cover;
    }
    .btn-submit {
      background-color: #f4b400;
      border: none;
    }
    .btn-submit:hover {
      background-color: #e2a600;
    }
  </style>
</head>
<body>

  <div class="form-card">
    <h3 class="form-title mb-3"><i class="fa-solid fa-clock me-2"></i>Formulir Keterlambatan</h3>
    <p class="text-muted text-center mb-4">Lengkapi data berikut untuk mencatat keterlambatan Anda.</p>

    <form id="telatForm">
      <div class="mb-3">
        <label class="form-label fw-semibold">Nama Lengkap</label>
        <textarea id="namaTelat" class="form-control" rows="1" placeholder="Masukkan nama Anda" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Jabatan</label>
        <textarea id="jabatanTelat" class="form-control" rows="1" placeholder="Masukkan jabatan Anda" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Alasan Keterlambatan</label>
        <textarea id="alasanTelat" class="form-control" rows="4" placeholder="Contoh: macet, urusan keluarga, dll" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Bukti Foto / Gambar</label>
        <input type="file" id="buktiTelat" accept="image/*" class="form-control" required>
        <img id="previewTelat" class="img-preview d-none" alt="Preview Bukti">
      </div>

      <div class="d-flex justify-content-between mt-4">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
          <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
        <button type="submit" class="btn btn-submit text-white">
          <i class="fa-solid fa-paper-plane me-2"></i>Kirim Telat
        </button>
      </div>
    </form>
  </div>

  <script>
    const LS_LOGGED = 'loggedInUser';
    const user = localStorage.getItem(LS_LOGGED);

    const buktiTelat = document.getElementById('buktiTelat');
    const previewTelat = document.getElementById('previewTelat');

    // Preview gambar
    buktiTelat.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = evt => {
          previewTelat.src = evt.target.result;
          previewTelat.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
      }
    });

    // Simpan data ke localStorage
    document.getElementById('telatForm').addEventListener('submit', (e) => {
      e.preventDefault();

      if (!user) {
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/';
        return;
      }

      const nama = document.getElementById('namaTelat').value.trim();
      const jabatan = document.getElementById('jabatanTelat').value.trim();
      const alasan = document.getElementById('alasanTelat').value.trim();
      const bukti = previewTelat.src;
      const now = new Date().toLocaleString('id-ID');

      if (!nama || !jabatan || !alasan || bukti === '') {
        alert('Mohon lengkapi semua data sebelum mengirim.');
        return;
      }

      const record = {
        action: 'Telat',
        nama,
        jabatan,
        alasan,
        bukti,
        time: now
      };

      localStorage.setItem(`telat__${user}__${Date.now()}`, JSON.stringify(record));
      alert(`✅ Data keterlambatan berhasil disimpan!\n\nNama: ${nama}\nJabatan: ${jabatan}\nWaktu: ${now}`);
      window.location.href = '/';
    });
  </script>

</body>
</html>
