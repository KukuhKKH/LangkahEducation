@extends('layouts.dashboard-app')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Profile</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">{{ $user->name }}</h6>
         {{-- <div class="float-right">
            <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
         </div> --}}
      </div>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            @if ($user->foto)
            <img class="img-fluid w-25" src="{{ asset("upload/users/$user->foto") }}" alt="foto-{{ $user->name }}">
            @else
            <img src="{{ asset("assets/img/undraw_profile.svg") }}" alt="foto-{{ $user->name }}">
            @endif
         </div>
         <div class="col-md-8">
            <h2>{{ $user->name }}</h2>
            <h4>{{ $user->email }}</h4>
            {{-- Role Siswa --}}
            @role('siswa')
            <p>NISN : {{ $user->siswa->nisn }}</p>
            @if (count($user->siswa->sekolah) > 0)
               <p>Nama Sekolah anda{{ $user->siswa->sekolah[0]->nama }}</p>
            @else
               <p class="badge badge-warning text-dark p-2">Anda tidak tergabung pada sekolah</p>
               <form action="{{ route('profil.kode_referal', $user->siswa->id) }}" method="POST">
                  @csrf
                  <div class="form-group">
                     <label for="">Kode Referal Sekolah</label>
                     <input type="text" class="form-control" placeholder="Kode Referal" name="kode_referal" required>
                  </div>
                  <button class="btn btn-success">Simpan</button>
               </form>
            @endif
            @endrole
            {{-- End Role Siswa --}}

            @role('mentor')
               @if (count($user->mentor->siswa) > 0)
                  <ol>
                     @forelse ($user->mentor->siswa as $value)
                        <li>{{ $value->user->name }}</li>
                     @empty
                        <li>Tidak mempunyai siswa</li>
                     @endforelse
                  </ol>
               @endif
            @endrole

         </div>
      </div>
   </div>
</div>
@endsection