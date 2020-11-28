<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemberitahuanController extends Controller
{
    public function index() {
        return view('pages.pemberitahuan.index');
    }
}
