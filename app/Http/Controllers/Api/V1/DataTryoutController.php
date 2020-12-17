<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KelompokPassingGrade;
use App\Models\PassingGrade;
use Illuminate\Http\Request;

class DataTryoutController extends Controller
{
    // Get Prodi by kelompok dan universitas
    public function get_prodi($kelompok_id, $universitas_id) {
        try {
            $kelompok = KelompokPassingGrade::find($kelompok_id);
            if($kelompok->nama == 'campuran') {
                $passing_grade = PassingGrade::where('universitas_id', $universitas_id)->get();
            } else {
                $passing_grade = PassingGrade::where('kelompok_id', $kelompok_id)->where('universitas_id', $universitas_id)->get();
            }
            return response()->json(['error' => false, 'data' => $passing_grade], 200);
        }catch(\Exception $e)      {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
