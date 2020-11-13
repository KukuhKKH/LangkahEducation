<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;

class SiswaImport implements ToModel, WithStartRow
{
    private $asal_sekolah;

    function __construct($asal_sekolah){
        $this->asal_sekolah = $asal_sekolah;
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
            $errMessage = 'Mohon pastikan kolom Nama Siswa tidak kosong.';
            throw new \Exception($errMessage);
        }
        if(empty($row[1])){
            $errMessage = 'Mohon pastikan kolom Email tidak kosong.';
            throw new \Exception($errMessage);
        }
        if(empty($row[2])){
            $errMessage = 'Mohon pastikan kolom NISN tidak kosong.';
            throw new \Exception($errMessage);
        }
        if(empty($row[3])){
            $errMessage = 'Mohon pastikan kolom Tanggal Lahir tidak kosong.';
            throw new \Exception($errMessage);
        }
        if(empty($row[4])){
            $errMessage = 'Mohon pastikan kolom Nomer HP tidak kosong.';
            throw new \Exception($errMessage);
        }
        $tgl = explode('/',$row[3]);
        $tgl_lahir = "$tgl[1]/$tgl[0]/$tgl[2]";
        $user = User::create([
            'name' => $row[0],
            'email' => $row[1],
            'password' => $row[2],
            'is_active' => 1,
            'email_verified_at' => date('Y-m-d')
        ]);
        $user->siswa()->create([
            'nisn' => $row[2],
            'asal_sekolah' => $this->asal_sekolah,
            'tanggal_lahir' => $tgl_lahir,
            'nomor_hp' => $row[4],
            'batch' => 1
        ]);
    }

    public function startRow(): int {
        return 2;
    }
}
