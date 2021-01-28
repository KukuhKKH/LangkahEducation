<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
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
            $role = Role::where('name', 'LIKE', "%$nama%")->paginate(10);
        }else{
            $role = Role::paginate(10);
        }
        
        return view('pages.role.index', compact('role'));
    }

    public function permission(Request $request) {
        $data = $request->all();

        if($request->get('keyword') != '') {
            $nama = $request->get('keyword');
            $permission = Permission::where('name', 'LIKE', "%$nama%")->paginate(10);
        }else{
            $permission = Permission::paginate(10);
        }
        
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
            return redirect()->route('role.index')->with(['success' => 'Sukses tambah role']);
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
        try {
            $role = Role::find($id);
            return view('pages.role.edit_role', compact('role'));
        } catch (\Exception $e) {
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
        try {
            $role = Role::find($id);
            $role->update([
                'name' => $request->name
            ]);
            return redirect()->route('role.index')->with(['success' => 'Sukses update role']);
        } catch (\Exception $e) {
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
            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->back()->with(['success' => 'Role: <strong>' . $role->name . '</strong> dihapus']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function attach($id) {
        $role = Role::find($id);
        $hasPermission = DB::table('role_has_permissions')
                    ->select('permissions.name')
                    ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('role_id', $role->id)->get()->pluck('name')->all();
        $permissions = Permission::all()->pluck('name');
        return view('pages.role.attach', compact('role', 'hasPermission', 'permissions'));
    }

    public function setRolePermission(Request $request, $role) {
        $role = Role::findByName($role);
        $role->syncPermissions($request->permission);
        return redirect()->route('role.index')->with(['success' => "Berhasil attach permission"]);
    }
    
    public function edit_permission($id) {
        try {
            $permission = Permission::find($id);
            return view('pages.role.edit_permission', compact('permission'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function update_permission(Request $request, $id) {
        try {
            $permission = Permission::find($id);
            $permission->update([
                'name' => $request->name
            ]);
            return redirect()->route('role.permission')->with(['success' => 'Sukses update permission']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy_permission($id)
    {
        try {
            $permission = Permission::find($id);
            $permission->delete();
            return redirect()->back()->with(['success' => 'Permission: <strong>' . $permission->name . '</strong> dihapus']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
