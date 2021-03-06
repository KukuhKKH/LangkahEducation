<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if($request->get('keyword') != '') {
            $nama = $request->get('keyword');
            $bank = Bank::latest()->where('nama', 'LIKE', "%$nama%")->paginate(10);
        } else {
            $bank = Bank::latest()->paginate(10);
        }
        return view('pages.rekening-pembayaran.index', compact('bank', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nomer_rekening' => 'required',
            'alias' => 'required',
            'bayar' => 'required',
            'file' => 'nullable|mimes:jpg,jpeg,gif,png|max:2024'
        ]);
        try {
            if($request->hasFile('file')) {
                $foto_name = time().'.'.$request->file->extension();  
                $request->file->move(public_path('upload/bank/'), $foto_name);
                $request->file = $foto_name;
            } else {
                $request->file = null;
            }
            Bank::create([
                'nama' => $request->nama,
                'nomer_rekening' => $request->nomer_rekening,
                'alias' => $request->alias,
                'bayar' => $request->bayar,
                'logo' => $request->file
            ]);
            return redirect()->back()->with(['success' => 'Berhasil tambah rekening']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $bank = Bank::find($id);
            return view('pages.rekening-pembayaran.edit', compact('bank'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nomer_rekening' => 'required',
            'alias' => 'required',
            'bayar' => 'required',
            'file' => 'nullable|mimes:jpg,jpeg,gif,png|max:2024'
        ]);
        try {
            $bank = Bank::find($id);
            if($request->hasFile('file')) {
                if($bank->logo != '') {
                    if(file_exists(public_path('upload/bank/'.$bank->logo))){
                        unlink(public_path('upload/bank/'.$bank->logo));
                    }
                }
                $foto_name = time().'.'.$request->file->extension();  
                $request->file->move(public_path('upload/bank/'), $foto_name);
                $request->file = $foto_name;
            }
            $bank->update([
                'nama' => $request->nama,
                'nomer_rekening' => $request->nomer_rekening,
                'alias' => $request->alias,
                'bayar' => $request->bayar,
                'logo' => $request->file ?? $bank->logo
            ]);
            $bank->save();
            return redirect()->route('rekening.index')->with(['success' => 'Berhasil edit rekening']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $bank = Bank::find($id);
            if(file_exists(public_path('upload/bank/'.$bank->logo))){
                unlink(public_path('upload/bank/'.$bank->logo));
            }
            $bank->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus rekening bank"]);
        } catch(\Exception $e) {
            return \redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show_bank($id) {
        try {
            $bank = Bank::find($id);
            return response()->json(['error' => false, 'data' => $bank], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 500]);
        }
    }
}
