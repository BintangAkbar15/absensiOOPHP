<?php 
session_start();
class Absensi {
    protected $jsondata;
    
    public function __construct() {
        // Memuat data dari file JSON
        $this->jsondata = json_decode(file_get_contents('../data/Absen.json'));
    }
    
    // Method untuk mendapatkan data siswa
    public function getSiswaData() {
        return $this->jsondata;
    }
}

class siswa extends Absensi{
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
    
    public function getSiswaById($no_siswa) {
        if (!$this->dataSiswa) {
            return null;
        }
    
        $result = [];
    
        foreach ($this->dataSiswa as $siswa) {
            if ($siswa->no_siswa == $no_siswa) {
                $result[] = $siswa;
            }
        }
    
        if (count($result) > 0) {
            return $result;
        } else {
            return null;
        }
    }

    public function tambahSiswa($no_siswa, $kelas, $tanggal, $status, $keterangan,$jam_masuk) {
        // Membersihkan data dari spasi di awal dan akhir
        $no_siswa = trim($no_siswa);
        $kelas = trim($kelas);
        $tanggal = trim($tanggal);
        $status = trim($status);
        $keterangan = trim($keterangan);
        $jam_masuk = trim($jam_masuk);
    
        // Cek apakah salah satu data kosong
        if (empty($status) || empty($tanggal) || empty($kelas) || empty($no_siswa) || empty($keterangan)) {
            return false; // Data tidak valid, tidak melakukan penyimpanan
        }
    
        // Membuat objek siswa baru
        $siswaBaru = [
            "no_siswa"=> $no_siswa,
            "kelas"=> $kelas,
            "tanggal"=> $tanggal,
            "jam_masuk"=> $jam_masuk,
            "status"=> $status,
            "keterangan"=> $keterangan
        ];
    
        // Membaca data dari file JSON
        $data = json_decode(file_get_contents('../data/absen.json'), true); // Decode sebagai array associative
        if (!$data) {
            echo "Data tidak ditemukan atau gagal dibaca.";
            return false;
        }
    
        // Menambahkan siswa baru ke dalam data siswa yang memiliki status 200 dan message "Success"
        $updated = false;
        foreach ($data as &$item) {
            if ($item['status'] == 200 && $item['message'] == "Success") {
                $item['data'][] = $siswaBaru;
                $updated = true;
                break;
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
    

    public function showSuccess(){
        return $this->simpanData();
    }
    
    private function simpanData() {
        // Encode data siswa kembali menjadi JSON
        if($this->dataSiswa !== null){
            $jsonData = json_encode($this->dataSiswa, JSON_PRETTY_PRINT);
        
            // Tulis kembali ke file JSON
            if (file_put_contents('../data/absen.json', $jsonData)) {
                return true;
            } else {
                return false;  // Jika terjadi kesalahan saat menyimpan
            }
        }
        return false;
    }
    
}

$absensi = new siswa();
$absensi->loadData();
?>