<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PembayaranExport implements FromView
{
    use Exportable;
    public $data;
    public function __construct($data){
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = $this->data;
        return view('export.pembayaran', compact('data'));
    }
}
