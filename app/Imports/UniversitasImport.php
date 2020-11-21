<?php

namespace App\Imports;

use App\Models\Universitas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;

class UniversitasImport implements ToModel, WithStartRow
{
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
            $errMessage = 'Mohon pastikan kolom Nama Universitas Siswa tidak kosong.';
            throw new \Exception($errMessage);
        }

        $universitas = Universitas::create([
            'nama' => $row[0],
        ]);
    }

    public function startRow(): int {
        return 2;
    }
}
