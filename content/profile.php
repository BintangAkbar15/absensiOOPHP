<?php 


class connect{
  protected $jsondata;
  public function __construct() {
      $this->jsondata = json_decode(file_get_contents('../data/data.json'));
  }

  public function getSiswaData() {
    return $this->jsondata;
  }
}

class profile extends connect{
  private $dataSiswa;

  public function loadData() {
    // Mendapatkan data siswa dari class Absensi
    $data = $this->getSiswaData();
    // Memastikan data JSON valid
    if ($data) {
        foreach ($data as $value) {
            if ($value->status == 200 && $value->message == "Success") {
                $this->dataSiswa = $value->data;
                return true;
            }
        }
    }
    return false;
  }

  public function getSiswaByNama($nama) {
    if (!$this->dataSiswa) {
        return null;  // Jika data belum di-load dengan benar
    }

    // Cari data siswa berdasarkan nama
    foreach ($this->dataSiswa as $siswa) {
        if ($siswa->nama == $nama) {
            return $siswa;  // Mengembalikan data lengkap siswa jika ditemukan
        }
    }
    return null;  // Return null jika siswa tidak ditemukan
  }
}

$prof = new profile();
$prof->loadData();
$siswa = $prof->getSiswaByNama($_COOKIE['username']);
$gendere;
if($siswa->gender = 'L'){
  $gendere = 'Laki-laki';
}else{
  $gendere = 'Perempuan';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-kehadiran</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="../asset/logo_icon.png" type="image/x-icon">
</head>
<body>
    <div class="container-fluid p-0" style="height: 100vh;">
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
          <a class="navbar-brand" href="#"><img src="../asset/logo_nav.png" alt="" width="170px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100">
              <li class="nav-item active">
                <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Log-Kehadiran</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../controllers/logout.php">Log-Out</a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="container">
          <div class="row justify-content-center p-3">
            <div class="card p-3" style="width: 30rem; height: max-content;">
              <div class="card-body">
                <div class="container d-flex justify-content-center">
                  <div class="card mb-4 rounded-circle" style="width: 14.5rem;height: 14.5rem">
                    <div class="card-body d-flex flex-column justify-content-center gap-3">
                      <i class="fa-regular fa-user" style="font-size: 100px; text-align: center"></i>
                      <h6 class="card-title text-center"><?= $siswa->no_siswa ?> - <?= $siswa->nama ?></h6>
                    </div>
                  </div>
                </div>
                <p class="card-text">Kelas : <?= $siswa->kelas ?></p>
                <p class="card-text">tanggal_lahir : <?= $siswa->tanggal_lahir ?></p>
                <p class="card-text">Gender : <?= $gendere ?></p>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-center mt-3">
              <button class="btn btn-primary w-25"><a href="uprofile.php" class="nav-link">Edit Profile</a></button>
            </div>
        </div>
    </div>
<script src="../js/bootstrap.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../index.js"></script>
</body>
</html>