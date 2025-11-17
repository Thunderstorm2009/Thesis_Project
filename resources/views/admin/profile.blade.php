@extends('admin.layout')

@section('title', 'Profil')

@section('content')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>

<div class="container p-4">

  <div class="card shadow-sm border-0 p-4" style="max-width: 450px; margin:auto; border-radius:20px;">

    <div class="text-center mb-4">

      <!-- FOTO PROFIL + OVERLAY -->
      <div class="position-relative d-inline-block">
        <img id="profilePhoto" src="" 
             class="rounded-circle border shadow-sm"
             style="width: 120px; height: 120px; object-fit: cover;">

        <div id="photoOverlay"
             class="position-absolute top-0 start-0 w-100 h-100 rounded-circle d-flex 
                    justify-content-center align-items-center"
             style="background: rgba(0,0,0,0.4); opacity:0; transition: .2s; cursor:pointer;">
          <i class="bi bi-camera text-white fs-4"></i>
        </div>
      </div>

      <!-- TOMBOL UPLOAD -->
  <div>
    <button type="button"
            class="btn btn-outline-primary btn-sm"
            onclick="document.getElementById('uploadPhoto').click()">
      <i class="bi bi-upload"></i> Upload Foto
    </button>
  </div>

  <input type="file" id="uploadPhoto" accept="image/*" class="d-none">

  <h5 class="mt-3 fw-bold" id="profileName">Admin</h5>
</div>

    <!-- FORM PROFIL -->
    <form id="formProfile">
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" id="fullname" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" id="username" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Password Baru (Kosongkan jika tidak diganti)</label>
        <input type="password" id="password" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
    </form>

  </div>

</div>

<!-- MODAL CROP -->
<div class="modal fade" id="cropModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3" style="border-radius:15px;">
      <h5 class="fw-bold mb-2">Crop Foto Profil</h5>

      <div class="text-center">
        <img id="cropImage" 
             style="width:100%; max-height:350px; object-fit:contain; border-radius:12px;">
      </div>

      <div class="text-end mt-3">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button id="btnCrop" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>

@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {

  const loggedAdmin = localStorage.getItem("loggedAdmin");
  const adminKey = "admin__" + loggedAdmin;
  let adminData = JSON.parse(localStorage.getItem(adminKey)) || {};

  const profileImg = document.getElementById("profilePhoto");
  const navbarPhoto = document.getElementById("navbarPhoto");

  profileImg.src = adminData.photo || "https://via.placeholder.com/120?text=A";
  document.getElementById("fullname").value = adminData.fullname || "";
  document.getElementById("username").value = adminData.username || "";
  document.getElementById("profileName").textContent = adminData.fullname || "Admin";

  // HOVER OVERLAY
  const overlay = document.getElementById("photoOverlay");
  profileImg.parentElement.addEventListener("mouseenter", () => overlay.style.opacity = "1");
  profileImg.parentElement.addEventListener("mouseleave", () => overlay.style.opacity = "0");

  let cropper;

  // UPLOAD FOTO → BUKA CROP MODAL
  document.getElementById("uploadPhoto").addEventListener("change", function(){
    const file = this.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
      alert("Ukuran foto maksimal 2MB!");
      return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
      const img = document.getElementById("cropImage");
      img.src = e.target.result;

      new bootstrap.Modal(document.getElementById("cropModal")).show();

      img.onload = () => {
        if (cropper) cropper.destroy();
        cropper = new Cropper(img, {
          aspectRatio: 1,
          viewMode: 1,
          dragMode: "move",
          background: false,
          guides: false,
          movable: true,
          zoomable: true
        });
      };
    };

    reader.readAsDataURL(file);
  });

  // SIMPAN CROP
  document.getElementById("btnCrop").addEventListener("click", () => {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
      width: 400,
      height: 400,
    });

    const finalImage = canvas.toDataURL("image/png");

    profileImg.src = finalImage;
    if (navbarPhoto) navbarPhoto.src = finalImage;

    adminData.photo = finalImage;
    localStorage.setItem(adminKey, JSON.stringify(adminData));

    bootstrap.Modal.getInstance(document.getElementById("cropModal")).hide();
  });

  // SIMPAN PROFIL
  document.getElementById("formProfile").addEventListener("submit", (e) => {
    e.preventDefault();

    adminData.fullname = document.getElementById("fullname").value.trim();
    adminData.username = document.getElementById("username").value.trim();

    const newPass = document.getElementById("password").value.trim();
    if (newPass) adminData.password = newPass;

    localStorage.setItem(adminKey, JSON.stringify(adminData));
    alert("✔ Profil berhasil diperbarui!");
    location.reload();
  });

});
</script>
@endsection
