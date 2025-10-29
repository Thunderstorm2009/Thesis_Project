<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Out - Presensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container text-center mt-5">
    <div class="card shadow p-5 mx-auto" style="max-width:500px;">
      <h4 class="text-secondary fw-bold mb-3"><i class="fa-solid fa-door-open me-2"></i>Check Out</h4>
      <p class="mb-4">Silakan lakukan presensi keluar di sini.</p>
      <form action="{{ url('/checkout/store') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-secondary">
          <i class="fa-solid fa-save me-2"></i>Simpan Waktu Check Out
        </button>
      </form>
      <a href="{{ url('/') }}" class="btn btn-link mt-3">⬅️ Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
