<?php
session_start();
// print_r($data);

$getdata = new masukk();
$getdata->getData();

class absensi{
    public $jsondata;
    public function __construct(){
        $jsonconnect = json_decode(file_get_contents('data/data.json'));
        $this->jsondata = $jsonconnect;
    }
}

class masukk extends absensi{
    private $dataSiswa;
    public function getData(){
        foreach ($this->jsondata as $value) {
            if($value->status == 200 && $value->message == "Success"){
                foreach ($value->data as $value) {
                    return $this->dataSiswa = $value;
                }
            }
            else{
                return $value->message;
            }
        }
    }
    
    // public function datasiswa(){
    //     foreach($this->dataSiswa as $value){
    //         echo $value ."<br>";
    //     }
    // }

    public function login($nama,$pass){
        $dataSiswa = $this->dataSiswa;
        if($dataSiswa->nama == $nama && 
        $dataSiswa->password == $pass){
            return true;
        }
        return false;
    }
}


if(isset($_POST['login'])){
    if(empty($_POST['username']) || empty($_POST['password'])){
        echo "<script>alert('Data Tidak Boleh Kosong')</script>";
    }
    else{
        $nama = $_POST['username'];
        $pass = $_POST['password'];
        $login = $getdata->login($nama,$pass);
        if(trim($nama) !== "" && trim($pass) !== ""){
            if($login == true){
                $_SESSION['login'] = true;
                header("location: index.html");
            } 
            else{
                echo "<script>alert('Login Gagal')</script>";
            }
        }
        else{
            echo "<script>alert('Masukkan Username dan Password dengan benar')</script>";
        }
    }
}
?>
