<?php

namespace App\Imports;

use App\Models\PassingGrade;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;

class PassingGradeImport implements ToModel, WithStartRow
{
    public $univ_id;

    public function __construct($univ_id) {
        $this->univ_id = $univ_id;
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
            $errMessage = 'Mohon pastikan kolom Nama Prodi tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[1])){
            $errMessage = 'Mohon pastikan kolom Kelompok Passing Grade tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[2])){
            $errMessage = 'Mohon pastikan kolom Passing Grade tidak kosong.';
            throw new \Exception($errMessage);
        }

        $passing_grade = PassingGrade::updateOrCreate([
            'prodi' => $row[0],
        ], [
            'universitas_id' => $this->univ_id,
            'kelompok_id' => $row[1],
            'passing_grade' => trim($row[2])
        ]);
    }

    public function startRow(): int {
        return 2;
    }
}
