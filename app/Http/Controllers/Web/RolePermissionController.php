<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::paginate(5);
        return view('pages.role.index', compact('role'));
    }

    public function permission() {
        $permission = Permission::paginate(5);
        return view('pages.role.permission', compact('permission'));
    }

    public function create(Request $request) {
        $total = $request->total;
        return view('pages.role.create_permission', compact('total'));
    }

    public function store_permission(Request $request) {
        try {
            foreach ($request->permission as $value) {
                Permission::create([
                    'name' => $value
                ]);
            }
            return redirect()->route('role.permission')->with(['success' => "Berhasil tambah permission"]);
        } catch (\Exception $e) {
            return redirect()->route('role.permission')->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            Role::create([
                'name' => $request->role
            ]);
            return redirect()->route('kategori.index')->with(['success' => 'Sukses Tambah Role']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function attach() {
        return view('pages.role.attach');
    }
}
