<?php 
session_start();
setcookie("username","",time()-3600,"/");
setcookie("no_siswa","",time()-3600,"/");
setcookie("kelas","",time()-3600,"/");
session_destroy();
header("location: ../login.php");
?>