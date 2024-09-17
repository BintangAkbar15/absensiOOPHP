<?php 
include "controllers/controllerData.php";
// session_start(); // Jangan lupa untuk memulai session jika belum

if(isset($_SESSION['login'])){
    header("location: index.php");
    exit();
}


if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $kelas = $_POST['kelas'];
    $no_siswa = $_POST['no_siswa'];
    $gender = $_POST['gender'];
    $tanggal_lahir = $_POST['tgl_lahir'];
    
    $namates = trim($username);
    $passwordtes = trim($password);
    $kelastes = trim($kelas);
    $no_siswates = trim($no_siswa);
    $gendertes = trim($gender);
    $tanggal_lahirtes = trim($tanggal_lahir);
    
    if($namates == "" || $passwordtes == "" || $kelastes == "" || $no_siswates == "" || $gendertes == "" || $tanggal_lahirtes == ""){
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Data Tidak Boleh Kosong',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
    } else {
        $success = $getdata->tambahSiswa($username, $password, $kelas, $no_siswa, $gender, $tanggal_lahir);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container-fluid" style="height: 100vh;">
        <div class="container d-flex justify-content-center align-items-center my-auto" style="height: 100vh;">
            <div class="card" style="width: 30rem; height: max-content;">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-12">    
                            <h5>Register</h5>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Kelas</label>
                                    <input type="text" name="kelas" id="kelas" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="no_siswa" id="no_siswa" class="form-control" value="<?= $getdata->generateId() ?>" required>
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
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="checkbox" id="checkbox" >
                                    <label for="password" class="h6">Show Password</label>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="submit" id="register" name="register" class="btn btn-primary w-100">Register</button>
                                    <a href="login.php">Already have account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const regis = document.getElementById("register");
        regis.addEventListener("click", function() {
            const card = document.getElementById("card");
            card.style.display = "none";
        });

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if(isset($_POST['register'])&&$getdata->showSuccess()):?>
            
            Swal.fire({
            title: 'The Internet?',
            text: 'That thing is still around?',
            icon: 'success'
            }).then((result) => {
            if(result.isConfirmed){
                window.location.href = 'login.php';
                }
            });

        <?php endif ?>
    </script>
</body>
</html>