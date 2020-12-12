<?php

namespace App\Http\Controllers\Web;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimoniRequest;

class TestimoniController extends Controller
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
            $testimoni = Testimoni::latest()->where('nama', 'LIKE', "%$nama%")->paginate(10);
        }else{
            $testimoni = Testimoni::latest()->paginate(10);
        }
        return view('pages.halaman.testimonial.index', compact('testimoni'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestimoniRequest $request)
    {
        try {
            if($request->hasFile('file')) {
                $foto_name = time().'.'.$request->file->extension();  
                $request->file->move(public_path('upload/testimoni/'), $foto_name);
                $request->merge([
                    'foto' => $foto_name
                ]);
            }
            Testimoni::create([
                'foto' => $foto_name ?? '',
                'nama' => $request->nama,
                'role' => $request->role,
                'status' => $request->status,
                'testimoni' => $request->testimoni
            ]);
            return redirect()->back()->with(['success' => 'Berhasil tambah testimoni']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
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
            $testimoni = Testimoni::find($id);
            return view('pages.halaman.testimonial.edit', compact('testimoni'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestimoniRequest $request, $id)
    {
        try {
            $testimoni = Testimoni::find($id);
            if($request->hasFile('file')) {
                $foto_name = time().'.'.$request->file->extension();  
                $request->file->move(public_path('upload/testimoni/'), $foto_name);
            }
            $testimoni->update([
                'foto' => $foto_name ?? $testimoni->foto,
                'nama' => $request->nama,
                'role' => $request->role,
                'status' => $request->status,
                'testimoni' => $request->testimoni
            ]);
            return redirect()->route('testimoni.index')->with(['success' => 'Berhasil update testimoni']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
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
            Testimoni::find($id)->delete();
            return redirect()->back()->with(['success' => 'Berhasil hapus testimoni']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function set_status($id, $status) {
        try {
            $testimoni = Testimoni::find($id);
            $testimoni->update([
                'status' => $status
            ]);
            if($status == 1) {
                $result = 'tampilkan';
            } else {
                $result = 'sembunyikan';
            }
            return redirect()->back()->with(['success' => "Berhasil $result testimoni"]);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
}
