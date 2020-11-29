<?php

namespace App\Imports;

use App\Models\NisnSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;

class NisnSiswaKeSekolahImport implements ToModel, WithStartRow
{
    public $sekolah_id;

    public function __construct($sekolah_id) {
        $this->sekolah_id = $sekolah_id;
    }

    public static function beforeImport(BeforeImport $event) {
        $worksheet = $event->reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g. 10

        if ($highestRow < 2) {
            $errMessage = 'Mohon pastikan file sudah berisi data yang akan diimport.';
            throw new \Exception($errMessage);
        }
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) {
        if(empty($row[0])){
            $errMessage = 'Mohon pastikan kolom NISN tidak kosong.';
            throw new \Exception($errMessage);
        }
        $sekolah = NisnSekolah::create([
            'sekolah_id' => $this->sekolah_id,
            'nisn' => $row[0]
        ]);
    }

    public function startRow(): int {
        return 2;
    }
}
