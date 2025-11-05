@extends('admin.layout')

@section('title', 'Profil')

@section('content')
<div class="container p-4">

  <div class="card shadow-sm border-0 p-4" style="max-width: 450px; margin:auto;">
    
    <div class="text-center mb-4">
      <label for="uploadPhoto" style="cursor:pointer;">
        <img id="profilePhoto" src="" class="rounded-circle border shadow-sm"
          style="width: 100px; height: 100px; object-fit: cover;">
      </label>
      <input type="file" id="uploadPhoto" accept="image/*" class="d-none">
      <h5 class="mt-3 fw-bold" id="profileName">Admin</h5>
    </div>

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
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {

  const loggedAdmin = localStorage.getItem("loggedAdmin");
  const adminKey = "admin__" + loggedAdmin;
  let adminData = JSON.parse(localStorage.getItem(adminKey)) || {};

  document.getElementById("fullname").value = adminData.fullname || "";
  document.getElementById("username").value = adminData.username || "";
  document.getElementById("profileName").textContent = adminData.fullname || "Admin";

  const profileImg = document.getElementById("profilePhoto");
  profileImg.src = adminData.photo || "https://via.placeholder.com/90?text=A";

  document.getElementById("uploadPhoto").addEventListener("change", function(){
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
      profileImg.src = e.target.result;
      adminData.photo = e.target.result;
      localStorage.setItem(adminKey, JSON.stringify(adminData));
      document.getElementById("navbarPhoto").src = e.target.result;
    };
    reader.readAsDataURL(file);
  });

  document.getElementById("formProfile").addEventListener("submit", (e) => {
    e.preventDefault();
    adminData.fullname = document.getElementById("fullname").value.trim();
    adminData.username = document.getElementById("username").value.trim();
    const newPass = document.getElementById("password").value.trim();
    if (newPass) adminData.password = newPass;
    localStorage.setItem(adminKey, JSON.stringify(adminData));
    alert("✅ Profil berhasil diperbarui!");
    location.reload();
  });

});
</script>
@endsection
