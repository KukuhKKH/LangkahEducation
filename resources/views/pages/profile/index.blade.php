@extends('layouts.dashboard-app')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Profil</h1>

<div class="card shadow mb-4">
    <div class="card-header text-right">
        <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12 text-center">
                @if ($user->foto)
                <img id="img-profile" class="img-fluid img-cover" src="{{ asset("upload/users/$user->foto") }}"
                    alt="foto-{{ $user->name }}">
                @else
                <img class="img-fluid" width="100px" src="{{ asset("assets/img/undraw_profile.svg") }}"
                    alt="foto-{{ $user->name }}">
                @endif
            </div>
            <div class="col-md-12">
                <div class="text-center">
                    <h3 class="h3 mt-3"><strong>{{ $user->name }}</strong></h3>
                    <h6 class="h6 font-italic">{{ $user->email }}</h6>
                </div>

                <div class="d-flex justify-content-center">
                  <div class="row text-center w-50">
                     <div class="col-xl-12">
                         {{-- Role Siswa --}}
                         @role('siswa')
                         <p class="text-center">NISN : {{ $user->siswa->nisn }}</p>
                         @if (count($user->siswa->sekolah) > 0)
                         <p><strong>Asal Sekolah : {{ $user->siswa->sekolah[0]->nama }}</strong></p>
                         @else
                         <p class="badge badge-warning text-dark p-2">Anda tidak tergabung pada sekolah</p>
                         @endif
                         <form action="{{ route('profil.kode_referal', $user->siswa->id) }}" method="POST">
                             @csrf
                             <div class="row">
                                 <div class="col-xl-10">
                                     <div class="form-group">
                                         <input type="text" class="form-control"
                                             placeholder="Masukkan Kode Referal Sekolah" name="kode_referal" required>
                                     </div>
                                 </div>
                                 <div class="col-xl-2">
                                     <button class="btn btn-primary">Kirim</button>
                                 </div>
                             </div>
                         </form>
                         @endrole
                         {{-- End Role Siswa --}}
                     </div>
                 </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

