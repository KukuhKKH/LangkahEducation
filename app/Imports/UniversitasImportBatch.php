<?php

namespace App\Imports;

use App\Models\Universitas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;

class UniversitasImportBatch implements ToModel, WithStartRow
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
            $errMessage = 'Mohon pastikan kolom Nama Universitas tidak kosong.';
            throw new \Exception($errMessage);
        }
        
        if(empty($row[1])){
            $errMessage = 'Mohon pastikan kolom Nama Prodi tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[2])){
            $errMessage = 'Mohon pastikan kolom Passing Grade tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[3])){
            $errMessage = 'Mohon pastikan kolom ID Kelompok tidak kosong.';
            throw new \Exception($errMessage);
        }

        $universitas = Universitas::updateOrCreate([
            'nama' => trim($row[0]),
        ], [
            'nama' => trim($row[0]),
        ]);
        
        $universitas->passing_grade()->updateOrCreate([
            'prodi' => trim($row[1]),
        ],[
            'prodi' => trim($row[1]),
            'passing_grade' => $row[2],
            'kelompok_id' => $row[3],
        ]);
    }

    public function startRow(): int {
        return 2;
    }
}
