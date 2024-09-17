<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: page/Login.html");
    exit;
}

class DataSource {
    public function source() {
        $getdata = file_get_contents('../data/Absen.json');
        $data = json_decode($getdata, true);
        return $data;
    }

    public function saveData($data) {
        file_put_contents('../data/Absen.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}

class DataBump extends DataSource {
    // Add a method to load a specific student's data by index
    public function loadStudent($index) {
        $data = $this->source();
        foreach ($data as $block) {
            if ($block['status'] == 200 && isset($block['data'][$index])) {
                return $block['data'][$index];
            }
        }
        return null;
    }

    // Method to save updated student data
    public function updateStudent($index, $updatedData) {
        $data = $this->source();
        foreach ($data as &$block) {
            if ($block['status'] == 200 && isset($block['data'][$index])) {
                $block['data'][$index] = $updatedData;
                $this->saveData($block['data'][$index]);
                return true;
            }
        }
        return false;
    }
}

$obj = new DataBump();

// Handle form submission
if (isset($_POST['update'])) {
    $index = $_POST['index'];
    
    $tanggal = $_GET['tanggal'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];
    $updatedData = [
        "no_siswa" => $_COOKIE['no_siswa'],
        "kelas" => $_COOKIE['kelas'],
        "tanggal" => $_GET['tanggal'],
        "jam_masuk" => $_GET['jam_masuk'],
        "status" => $status,
        "keterangan" => $keterangan
    ];
    
    if ($obj->updateStudent($index, $updatedData)) {
        header("Location: log-kehadiran.php"); // Redirect to main page after update
        exit;
    }
    else{
        echo"GAGAL weh";
    }
}

// Load data for the student to edit
$index = ($_GET['index']) - 1;
$student = $obj->loadStudent($index);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid" style="height: 100vh;">
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
            <a class="navbar-brand" href="#"><img src="../asset/logo_nav.png" alt="" width="170px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav w-100">
                <li class="nav-item active">
                  <a class="nav-link" href="../index.php">Home</a>
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
        <div class="container d-flex justify-content-center align-items-center my-5 p-5">
            <div class="card" style="width: 30rem; height: max-content;">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-12">    
                            <h5>Absensi</h5>
                            <form action="" method="post">
                                <input type="hidden" value="G30SPKL" name="id" id="id" class="form-control">
                                <div class="form-group">
                                    <label for="no_siswa">No Siswa</label>
                                    <input type="text" name="no_siswa" id="no_siswa" class="form-control" value="<?= $_COOKIE['no_siswa'] ?>" readonly required>
                                </div>
                                <div class="form-group d-grid">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" onchange="valKeterangan()" class="form-select form-select-md mb-3">
                                        <option value="">Status</option>
                                        <option value="H">Hadir</option>
                                        <option value="I">Izin</option>
                                        <option value="S">Sakit</option>
                                        <option value="A">Alpha</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" readonly required>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="submit" name="submit" class="btn btn-primary">Absen</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/poppermin.js"></script>
    <script>
        function valKeterangan(){
            const status = document.getElementById('status').value;
            console.log(status)
            switch(status){
                case 'H':
                    document.getElementById('keterangan').value = 'Siswa Hadir';
                    break;
                case 'I':
                    document.getElementById('keterangan').value = 'Siswa Izin';
                    break;
                case 'S':
                    document.getElementById('keterangan').value = 'Siswa Sakit';
                    break;
                case 'A':
                    document.getElementById('keterangan').value = 'Siswa Tidak Hadir';
                    break;
                default:
                    document.getElementById('keterangan').value = 'Siswa Tidak Hadir';
            }
        }
    </script>
</body>
</html>