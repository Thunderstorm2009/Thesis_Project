<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Formulir Izin | Presensi Karyawan</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f7f9fc;
      font-family: "Google Sans", "Roboto", sans-serif;
    }
    .form-container {
      background: #fff;
      border-radius: 10px;
      padding: 2rem 2.5rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      max-width: 700px;
      margin: 50px auto;
    }
    .form-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1a73e8;
      margin-bottom: 1rem;
      text-align: center;
    }
    .form-description {
      text-align: center;
      color: #5f6368;
      margin-bottom: 2rem;
    }
    .form-label {
      font-weight: 500;
    }
    .btn-primary {
      background-color: #1a73e8;
      border-color: #1a73e8;
    }
    .btn-primary:hover {
      background-color: #0c5ed9;
    }
    input, textarea {
      border-radius: 6px !important;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-container">
      <div class="form-title">
        <i class="fa-solid fa-user-times me-2"></i>Formulir Pengajuan Izin
      </div>
      <p class="form-description">
        Silakan isi data izin Anda dengan lengkap seperti pada contoh formulir Google Form.
      </p>

      <form id="izinForm">
        <!-- ID Karyawan -->
        <div class="mb-3">
          <label class="form-label" for="izinId">ID Karyawan</label>
          <input type="text" class="form-control" id="izinId" placeholder="Masukkan ID karyawan Anda" required>
        </div>

        <!-- Nama -->
        <div class="mb-3">
          <label class="form-label" for="izinName">Nama Lengkap</label>
          <input type="text" class="form-control" id="izinName" placeholder="Masukkan nama lengkap Anda" required>
        </div>

        <!-- Jabatan -->
        <div class="mb-3">
          <label class="form-label" for="izinPosition">Jabatan</label>
          <input type="text" class="form-control" id="izinPosition" placeholder="Masukkan jabatan Anda" required>
        </div>

        <!-- Alasan -->
        <div class="mb-3">
          <label class="form-label" for="izinReason">Alasan Izin</label>
          <textarea class="form-control" id="izinReason" rows="4" placeholder="Contoh: sakit, urusan keluarga, dll" required></textarea>
        </div>

        <!-- Rentang Tanggal -->
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="izinStart">Mulai Tanggal</label>
            <input type="datetime-local" class="form-control" id="izinStart" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="izinFinish">Selesai Tanggal</label>
            <input type="datetime-local" class="form-control" id="izinFinish" required>
          </div>
        </div>

        <!-- Upload Bukti -->
        <div class="mb-3">
          <label class="form-label" for="izinProof">Upload Bukti (Wajib)</label>
          <input type="file" class="form-control" id="izinProof" accept="image/*">
          <div class="text-center mt-2">
            <img id="previewImg" src="" alt="" style="max-width: 200px; display:none; border-radius:10px; margin-top:10px;">
          </div>
        </div>

        <!-- Tombol -->
        <div class="d-flex justify-content-between mt-4">
          <a href="{{ url('/') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-paper-plane me-2"></i>Kirim Izin
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const LS_LOGGED = "loggedInUser";
    const userLogged = localStorage.getItem(LS_LOGGED);

    // Preview gambar bukti
    const proofInput = document.getElementById("izinProof");
    const previewImg = document.getElementById("previewImg");

    proofInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (evt) => {
          previewImg.src = evt.target.result;
          previewImg.style.display = "block";
        };
        reader.readAsDataURL(file);
      } else {
        previewImg.style.display = "none";
      }
    });

    // Simpan ke localStorage
    document.getElementById("izinForm").addEventListener("submit", (e) => {
      e.preventDefault();

      if (!userLogged) {
        alert("Silakan login terlebih dahulu.");
        window.location.href = "/";
        return;
      }

      const id = document.getElementById("izinId").value.trim();
      const name = document.getElementById("izinName").value.trim();
      const position = document.getElementById("izinPosition").value.trim();
      const reason = document.getElementById("izinReason").value.trim();
      const start = document.getElementById("izinStart").value;
      const finish = document.getElementById("izinFinish").value;
      const proof = previewImg.src || null;

      if (!id || !name || !position || !reason || !start || !finish) {
        alert("Semua data wajib diisi.");
        return;
      }

      const now = new Date().toLocaleString("id-ID");
      const recordId = `izin_${Date.now()}`;
      const record = {
        id,           // ID karyawan
        recordId,     // ID unik izin
        action: "Izin",
        name,
        position,
        reason,
        start,
        finish,
        proof,
        timeSubmitted: now
      };

      localStorage.setItem(`presensi__${userLogged}__${recordId}`, JSON.stringify(record));
      alert(`✅ Izin berhasil dikirim pada ${now}.`);
      window.location.href = "/";
    });
  </script>
</body>
</html>
