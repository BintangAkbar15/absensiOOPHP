const presensi = document.querySelector("#presensi");
const kehadiran = document.querySelector("#kehadiran");
const pengajar = document.querySelector("#pengajar");

presensi.addEventListener("click", function() {
    window.location.href = "../content/presensi.php";
})

kehadiran.addEventListener("click", function() {
    window.location.href = "content/log-kehadiran.php";
})

pengajar.addEventListener("click", function() {
    window.location.href = "content/pengajar.php";
})
