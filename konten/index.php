<?php
$data = json_decode(file_get_contents('../data/data.json'));

// print_r($data);

$getdata = new absensi($data);
print_r($getdata->getData());

class absensi{
    public $data;
    public function __construct($data){
        $this->data = $data;
    }

    public function getData(){
        foreach ($this->data as $value) {
            if($value->status == 200 && $value->message == "Success"){
                return $value->data;
            }
            else{
                return $value->message;
            }
        }

    }

}
?>
