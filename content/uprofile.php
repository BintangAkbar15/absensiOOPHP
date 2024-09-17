<?php

class DataSource {
    public function source() {
        $getdata = file_get_contents('../data/data.json');
        $data = json_decode($getdata, true);
        return $data;
    }

    public function saveData($data) {
        file_put_contents('../data/data.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}


class DataBump extends DataSource {
    private $dataSiswa;
    // Load student by no_siswa
    public function loadStudentByNoSiswa($no_siswa) {
        $data = $this->source();
        foreach ($data as $block) {
            if ($block['status'] == 200 && isset($block['data'])) {
                // Search for the student with the matching no_siswa
                foreach ($block['data'] as $student) {
                    if (isset($student['no_siswa']) && $student['no_siswa'] == $no_siswa) {
                        return $student;
                    }
                }
            }
        }
        return null;
    }

    // Update student by no_siswa
    public function updateStudentByNoSiswa($no_siswa, $updatedData) {
        $data = $this->source();
        foreach ($data as &$block) {
            if ($block['status'] == 200 && isset($block['data'])) {
                // Search for the student with the matching no_siswa
                foreach ($block['data'] as &$student) {
                    if (isset($student['no_siswa']) && $student['no_siswa'] == $no_siswa) {
                        // Update the student's data
                        $student = $updatedData;
                        $this->saveData($data);
                        return true; // Return true if update is successful
                    }
                }
            }
        }
        return false; // Return false if no student with the given no_siswa was found
    }

    public function getSiswaByNoSiswa($no_siswa) {
        $data = $this->source();
        foreach ($data as $block) {
            if ($block['status'] == 200 && isset($block['data'])) {
                // Search for the student with the matching no_siswa
                foreach ($block['data'] as $student) {
                    if (isset($student['no_siswa'])== $no_siswa) {
                        return $student;
                    }
                }
            }
        }
        return null;  // Return null jika siswa tidak ditemukan
    }
}

$obj = new DataBump();
$data  = $obj->loadStudentByNoSiswa($_COOKIE['no_siswa']);


// Handle form submission
if (isset($_POST['update'])) {
    $no_siswa = $_POST['no_siswa']; // Use no_siswa instead of index
    $updatedData = [
        'nama' => $_POST['username'],
        'password' => $_POST['password'],
        'kelas' => $_POST['kelas'],
        'no_siswa' => $_POST['no_siswa'],
        'gender' => $_POST['gender'],
        'tanggal_lahir' => $_POST['tgl_lahir']
    ];

    
    if ($obj->updateStudentByNoSiswa($no_siswa, $updatedData)) {
        header("Location: profile.php"); // Redirect to main page after update
        exit;
    }
}

if (isset($_POST['back'])) {
    header("Location: index.php"); // Redirect to main page
    exit;
}

$no_siswa = $_COOKIE['no_siswa']; 
$student = $obj->loadStudentByNoSiswa($no_siswa);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../js/bootstrap.js">
    <link rel="stylesheet" href="../js/popper.min.js">
</head>
<body class="d-flex flex-column align-items-center justify-content-center vh-100">
    <?php if ($student): ?>
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
        <div class="container d-flex justify-content-center align-items-center my-3  p-2">
            <div class="card" style="width: 30rem; height: max-content;">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-12">    
                            <h5>Edit Data Siswa</h5>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?= $student['nama'] ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <input type="text" name="kelas" id="kelas" class="form-control" value="<?= $student['kelas'] ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="no_siswa" id="no_siswa" class="form-control" value="<?= $_COOKIE['no_siswa'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-select form-select-md mb-3" required>
                                        <option value="">Gender</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" value="<?= $student['tanggal_lahir'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" value="<?= $student['password'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="checkbox" id="checkbox" >
                                    <label for="password" class="h6">Show Password</label>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="submit" id="update" name="update" class="btn btn-primary w-100">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <p>Student data not found.</p>
    <?php endif; ?>
    <script>
        const check = document.getElementById("checkbox");
        check.addEventListener("click", function() {
            const pass = document.getElementById("password");
            if(check.checked){
                pass.setAttribute("type", "text");
            }else{
                pass.setAttribute("type", "password");
            }
        })
    </script>

</body>
</html>