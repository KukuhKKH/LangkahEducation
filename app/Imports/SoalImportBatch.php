<?php

namespace App\Imports;

use App\Models\TryoutSoal;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;

class SoalImportBatch implements ToModel, WithStartRow
{
    public $paket_id;

    public function __construct($paket_id) {
        $this->paket_id = $paket_id;
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
            $errMessage = 'Mohon pastikan kolom ID Kategori tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[1])){
            $errMessage = 'Mohon pastikan kolom Soal tidak kosong.';
            throw new \Exception($errMessage);
        }
        
        // if(empty($row[2])){
        //     $errMessage = 'Mohon pastikan kolom Pembahasan tidak kosong.';
        //     throw new \Exception($errMessage);
        // }

        if(empty($row[3])){
            $errMessage = 'Mohon pastikan kolom Jawaban A tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[4])){
            $errMessage = 'Mohon pastikan kolom Jawaban B tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[5])){
            $errMessage = 'Mohon pastikan kolom Jawaban C tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[6])){
            $errMessage = 'Mohon pastikan kolom Jawaban D tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[7])){
            $errMessage = 'Mohon pastikan kolom Jawaban E tidak kosong.';
            throw new \Exception($errMessage);
        }

        if(empty($row[8])){
            $errMessage = 'Mohon pastikan kolom Option yang benar tidak kosong.';
            throw new \Exception($errMessage);
        }

        // if(empty($row[9])){
        //     $errMessage = 'Mohon pastikan kolom Nilai salah tidak kosong.';
        //     throw new \Exception($errMessage);
        // }

        if($row[9] < 0 || trim($row[9]) == '') {
            $errMessage = 'Pastikan nilai salah tidak boleh bernilai negatif atau kosong.';
            throw new \Exception($errMessage);
        }
        
        $soal = TryoutSoal::updateOrCreate([
            'tryout_paket_id' => $this->paket_id,
            'tryout_kategori_soal_id' => $row[0],
            'soal' => $row[1],
        ],[
            'user_id' => Auth::user()->id,
            'pembahasan' => $row[2] ?? '',
            'benar' => 4,
            'salah' => $row[9],
        ]);

        $soal->jawaban()->updateOrCreate([
            'jawaban' => $row[3],
            'benar' => (strtoupper(trim($row[8])) == "A") ? 1 : 0
        ]);

        $soal->jawaban()->updateOrCreate([
            'jawaban' => $row[4],
            'benar' => (strtoupper(trim($row[8])) == "B") ? 1 : 0
        ]);

        $soal->jawaban()->updateOrCreate([
            'jawaban' => $row[5],
            'benar' => (strtoupper(trim($row[8])) == "C") ? 1 : 0
        ]);

        $soal->jawaban()->updateOrCreate([
            'jawaban' => $row[6],
            'benar' => (strtoupper(trim($row[8])) == "D") ? 1 : 0
        ]);

        $soal->jawaban()->updateOrCreate([
            'jawaban' => $row[7],
            'benar' => (strtoupper(trim($row[8])) == "E") ? 1 : 0
        ]);
    }

    public function startRow(): int {
        return 2;
    }
}
