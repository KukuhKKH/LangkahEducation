<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $superadmin = \Spatie\Permission\Models\Role::create([ 'name' => 'superadmin' ]);
        $admin = \Spatie\Permission\Models\Role::create([ 'name' => 'admin' ]);
        $siswa = \Spatie\Permission\Models\Role::create([ 'name' => 'siswa' ]);
        $sekolah = \Spatie\Permission\Models\Role::create([ 'name' => 'sekolah' ]);
        $mentor = \Spatie\Permission\Models\Role::create([ 'name' => 'mentor' ]);

        $permission = [
            'create siswa', 'read siswa', 'update siswa', 'delete siswa', 'create mentor', 'read mentor', 'update mentor', 'delete mentor', 'create sekolah', 'read sekolah', 'update sekolah', 'delete sekolah', 'create admin', 'read admin', 'update admin', 'delete admin', 'create superadmin', 'read superadmin', 'update superadmin', 'delete superadmin', 'create role', 'read role', 'update role', 'delete role', 'create permission', 'read permission', 'update permission', 'delete permission', 'attach permission', 'integrasi mentor ke siswa', 'insert batch siswa', 'try out', 'konfirmasi bayar', 'bayar try out', 'create blog', 'read blog', 'update blog', 'delete blog', 'create kategori', 'read kategori', 'update kategori', 'delete kategori', 'komentar try out', 'create data univ'
        ];

        foreach ($permission as $key => $value) {
            Permission::create([
                'name' => $value
            ]);
        }

        $superadmin->syncPermissions([
            'create superadmin', 'read superadmin', 'update superadmin', 'delete superadmin', 'create role', 'read role', 'update role', 'delete role', 'create permission', 'read permission', 'update permission', 'delete permission', 'attach permission', 'create admin', 'read admin', 'update admin', 'delete admin', 'read blog',
        ]);

        $admin->syncPermissions([
            'create siswa', 'read siswa', 'update siswa', 'delete siswa', 'create mentor', 'read mentor', 'update mentor', 'delete mentor', 'create sekolah', 'read sekolah', 'update sekolah', 'delete sekolah', 'integrasi mentor ke siswa', 'insert batch siswa', 'konfirmasi bayar', 'create blog', 'read blog', 'update blog', 'delete blog', 'create kategori', 'read kategori', 'update kategori', 'delete kategori', 'create data univ'
        ]);

        $siswa->syncPermissions([
            'read siswa', 'update siswa', 'try out', 'bayar try out', 'read blog',
        ]);

        $sekolah->syncPermissions([
            'integrasi mentor ke siswa', 'insert batch siswa', 'create siswa', 'read siswa', 'update siswa', 'delete siswa', 'read blog',
        ]);

        $mentor->syncPermissions([
            'read siswa', 'komentar try out', 'read blog',
        ]);
    }
}
