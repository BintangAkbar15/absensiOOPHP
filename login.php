<?php 
include "controllers/controllerData.php";
if(isset($_SESSION['login'])){
  header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid" style="height: 100vh;">
        <div class="container d-flex justify-content-center align-items-center my-auto" style="height: 100vh;">
            <div class="card" style="width: 30rem; height: max-content;">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-12">    
                            <h5>LOGIN</h5>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" required>
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
                                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                                    <a href="register.php">Don't have account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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