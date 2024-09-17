<?php
session_start();

interface User{
    public function login($nama, $pass);
}
class Absensi {
    protected $jsondata;
    
    public function __construct() {
        // Memuat data dari file JSON
        $this->jsondata = json_decode(file_get_contents('data/data.json'));
    }
    
    // Method untuk mendapatkan data siswa
    public function getSiswaData() {
        return $this->jsondata;
    }

    public function saveData($data) {
        file_put_contents('data/Absen.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}

class Akun extends Absensi implements User {
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

    public function login($nama, $pass) {
        if (!$this->dataSiswa) {
            return false;  // Jika data belum di-load dengan benar
        }

        // Periksa tiap siswa dalam data siswa
        foreach ($this->dataSiswa as $siswa) {
            if ($siswa->nama == $nama && $siswa->password == $pass) {
                return true;
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

    public function generateId(){
        $id =  2311;
        $id .= rand(00000000,99999999);
        $existingId = [];

        foreach ($this->dataSiswa as $siswa) {
            $existingId[] = $siswa->no_siswa;
        }
        
        do{
            $id =  2311;
            $id .= rand(00000000,99999999);
        }while(in_array($id, $existingId));

        return $id;
    }

    public function tambahSiswa($nama, $password, $kelas, $no_siswa, $gender, $tanggal_lahir) {
        // Membersihkan data dari spasi di awal dan akhir
        $nama = trim($nama);
        $password = trim($password);
        $kelas = trim($kelas);
        $no_siswa = trim($no_siswa);
        $gender = trim($gender);
        $tanggal_lahir = trim($tanggal_lahir);
    
        // Cek apakah salah satu data kosong
        if (empty($nama) || empty($password) || empty($kelas) || empty($no_siswa) || empty($gender) || empty($tanggal_lahir)) {
            return false; // Data tidak valid, tidak melakukan penyimpanan
        }
    
        // Membuat objek siswa baru
        $siswaBaru = [
            'nama' => $nama,
            'password' => $password,
            'kelas' => $kelas,
            'no_siswa' => $no_siswa,
            'gender' => $gender,
            'tanggal_lahir' => $tanggal_lahir
        ];
    
        // Membaca data dari file JSON
        $data = json_decode(file_get_contents('data/data.json'), true); // Decode sebagai array associative
        if (!$data) {
            echo "Data tidak ditemukan atau gagal dibaca.";
            return false;
        }
    
        // Menambahkan siswa baru ke dalam data siswa yang memiliki status 200 dan message "Success"
        $updated = false;
        foreach ($data as &$item) { // Gunakan referensi &
            if ($item['status'] == 200 && $item['message'] == "Success") {
                $item['data'][] = $siswaBaru; // Tambahkan siswa baru
                $updated = true;
                break; // Keluar dari loop setelah diperbarui
            }
        }
    
        if (!$updated) {
            echo "Objek dengan status 200 dan message 'Success' tidak ditemukan.";
            return false;
        }
    
        // Simpan perubahan ke file JSON
        $this->dataSiswa = $data; // Set data yang diperbarui ke property dataSiswa
        return $this->simpanData();
    }

    public function deleteDataByNoSiswa($no_siswa) {
        $data = json_decode(file_get_contents('data/data.json'));
        
        // Check if data exists and iterate through the data
        foreach ($data as &$item) {
            if ($item['status'] == 200 && isset($item['data'])) {
                // Search for the student with the matching no_siswa
                foreach ($item['data'] as $key => $student) {
                    if (isset($student['no_siswa']) && $student['no_siswa'] == $no_siswa) {
                        // Delete the student if found
                        unset($item['data'][$key]);
                        
                        // Reindex the array after deletion
                        $item['data'] = array_values($item['data']);
                        
                        // Save the updated data back to the file
                        $this->saveData($data);
                        
                        return true; // Return true to indicate successful deletion
                    }
                }
            }
        }
        
        return false; // Return false if no student with the given no_siswa was found
    }
    
    public function showSuccess() {
        return $this->simpanData();
    }
    
    private function simpanData() {
        // Encode data siswa kembali menjadi JSON
        if ($this->dataSiswa !== null) {
            $jsonData = json_encode($this->dataSiswa, JSON_PRETTY_PRINT);
        
            // Tulis kembali ke file JSON
            if (file_put_contents('data/data.json', $jsonData)) {
                return true;
            } else {
                return false;  // Jika terjadi kesalahan saat menyimpan
            }
        }
        return false;
    }
    
}
$getdata = new Akun();
$getdata->loadData();

if (isset($_POST['login'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>alert('Data Tidak Boleh Kosong')</script>";
    } else {
        $nama = $_POST['username'];
        $pass = $_POST['password'];
        $login = $getdata->login($nama, $pass);
        
        if (trim($nama) !== "" && trim($pass) !== "") {
            if ($login) {
                $_SESSION['login'] = true;
                setcookie('username', $nama);
                header("location: index.html");
            } else {
                echo "<script>alert('Login Gagal : Username/Password salah')</script>";
            }
        } else {
            echo "<script>alert('Masukkan Username dan Password dengan benar')</script>";
        }
    }
}
?>
