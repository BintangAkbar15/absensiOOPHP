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
                <a class="nav-link" href="log-kehadiran.php">Log-Kehadiran</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../controllers/logout.php">Log-Out</a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12 text-center p-5 pb-3">
              <h5>NOMOR SISWA - NAMA SISWA</h5>
            </div>
            <div class="col-12 d-flex justify-content-around pb-3 gap-2">
              <button class="btn btn-primary"><i class="fa-solid fa-door-open"></i> Absen Sekarang</button>
              <button class="btn btn-primary"><i class="fa-solid fa-print"></i> Print Kehadiran Anda</button>
            </div>
            <div class="col-8 mt-4">
              <table class="table text-center table-stripped">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>NO. GURU</th>
                    <th>NAMA</th>
                    <th>PELAJARAN</th>
                    <th>STATUS</th>
                    <th>KETERANGAN</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      1
                    </td>
                    <td>
                        G20201034
                    </td>
                    <td>
                        Dewi Nur Hikari
                    </td>
                    <td>
                        MTK
                    </td>
                    <td>
                      masuk
                    </td>
                    <td>
                      -
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    <div class="container d-grid justify-content-center align-items-center gap-3 mt-5">
<script src="../js/bootstrap.js"></script>
<script src="../js/popper.min.js"></script>
</body>
</html>