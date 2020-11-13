<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MentorImport implements ToCollection, WithStartRow
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
            $errMessage = 'Mohon pastikan kolom Nama Mentor tidak kosong.';
            throw new \Exception($errMessage);
        }
        if(empty($row[1])){
            $errMessage = 'Mohon pastikan kolom Email tidak kosong.';
            throw new \Exception($errMessage);
        }
        if(empty($row[2])){
            $errMessage = 'Mohon pastikan kolom Pendidikan Terakhir tidak kosong.';
            throw new \Exception($errMessage);
        }
        $user = User::create([
            'name' => $row[0],
            'email' => $row[1],
            'password' => 123456,
            'is_active' => 1,
            'email_verified_at' => date('Y-m-d')
        ]);
        $user->mentor()->create([
            'pendidikan_terakhir' => $row[2]
        ]);
    }

    public function startRow(): int {
        return 2;
    }
}
