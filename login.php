<?php 
include "controllers/controllerData.php";
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
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>