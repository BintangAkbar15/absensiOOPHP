<?php 
include "controllers/controllerData.php";
if(!isset($_SESSION['login'])){
  header("location: login.php");
}

if ($getdata->loadData()) {
  // Contoh mencari siswa berdasarkan nama "Virgianto"
  $siswa = $getdata->getSiswaByNama($_COOKIE['username']);
  setcookie('no_siswa', $siswa->no_siswa);
  setcookie('kelas', $siswa->kelas);

} else {
  echo "Data siswa gagal dimuat.";
}

if(isset($_POST['delete'])){
  $deleting = $getdata->deleteDataByNoSiswa($_COOKIE['no_siswa']);
}
              

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="asset/logo_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid p-0" style="height: 100vh;">
      <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
        <a class="navbar-brand" href="#"><img src="asset/logo_nav.png" alt="" width="170px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav w-100">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="content/log-kehadiran.php">Log-Kehadiran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="controllers/logout.php">Log-Out</a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container d-grid justify-content-center align-items-center gap-3 mt-5">
        <div class="row mt-3">
          <div class="col-12 d-grid justify-content-center">
            <h2 class="text-center">Presensi</h2>
            <hr class="mt-0" style="border: 3px solid grey; border-radius: 5px;">
          </div>
        </div>
        <div class="row">
          <div class="col-12">
          <div class="container d-flex flex-wrap justify-content-center align-items-center my-auto gap-3">
            <div class="card bg-primary" id="presensi" style="width: 12rem; height: max-content;">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center gap-2 text-light">    
                            <i class="fa-solid fa-door-open" style="color:white; font-size: 5rem"></i>
                            <h5 class="text-center">PRESENSI</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-primary" id="kehadiran" style="width: 12rem; height: max-content;">
              <div class="card-body">
                  <div class=" row">
                      <div class="col-12 d-flex flex-column justify-content-center align-items-center gap-2 text-light">    
                        <i class="fa-solid fa-clipboard-user" style="color:white; font-size: 5rem"></i>
                          <h5 class="text-center">Log-Kehadiran</h5>
                      </div>
                  </div>
              </div>
            </div>
            <div class="card bg-primary" id="profile" style="width: 12rem; height: max-content;">
              <div class="card-body">
                  <div class=" row">
                      <div class="col-12 d-flex flex-column justify-content-center align-items-center gap-2 text-light">    
                        <i class="fas fa-user" style="color:white; font-size: 5rem"></i>
                          <h5 class="text-center">Profile</h5>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 justify-content-center d-flex">
          <form action="" id="deleteForm" onsubmit="return submitForm(event)" method="post">
            <button type="submit" name="delete" id="deleteBtn" class="btn btn-primary">
              <i class="fa-solid fa-trash"></i> Hapus Akun
            </button>
          </form>
        </div>
      </div>
      </div>
  </div>
<script src="js/bootstrap.js"></script>
<script src="js/popper.min.js"></script>
<script src="index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Menangani event klik pada tombol delete
    function submitForm(event) {
      event.preventDefault(); // Mencegah submit form secara langsung
      
      // Tampilkan SweetAlert untuk konfirmasi penghapusan
      Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Akun Anda tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus akun!"
      }).then((result) => {
        if (result.isConfirmed) {
          // Jika pengguna mengkonfirmasi penghapusan
          
          // Menggunakan fetch API untuk mengirimkan request ke server tanpa reload
          fetch("", {
            method: "POST",
            body: new URLSearchParams({
              "delete": true // Mengirimkan data delete ke server
            })
          })
          .then(response => response.text())
          .then(data => {
            // Tampilkan pesan sukses dengan SweetAlert
            Swal.fire({
              title: "Dihapus!",
              text: "Akun Anda berhasil dihapus.",
              icon: "success"
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "controllers/logout.php";
              }
            });
          })
          .catch(error => {
            console.error("Terjadi kesalahan:", error);
          });
        }
      });
    }
</script>

</body>
</html>