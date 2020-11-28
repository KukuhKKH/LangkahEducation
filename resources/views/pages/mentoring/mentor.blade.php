@extends('layouts.dashboard-app')
@section('title', 'Daftar Siswa')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Daftar Siswa</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between mb-1">
         <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>Asal Sekolah</th>
                  <th>NISN</th>
                  <th width="10%">Aksi</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>Asal Sekolah</th>
                  <th>NISN</th>
                  <th width="10%">Aksi</th>
               </tr>
            </tfoot>
            <tbody>
               @forelse($mentor->siswa as $value)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $value->user->name }}</td>
                  <td>{{ $value->asal_sekolah }}</td>
                  <td>{{ $value->nisn }}</td>
                  <td>
                     <a href="{{ route('mentorig.mentoring', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Virtual Mentoring">
                        <i class="fas fa-fw fa-microphone"></i>
                     </a>
                     <a href="javascript:void(0)" onclick="detailTryout({{ $value->id }})" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Analisis hasil tryout">
                        <i class="fas fa-fw fa-desktop"></i>
                    </a>
                  </td>
               </tr>
               @empty
               <tr>
                  <td colspan="5" class="text-center">
                     Tidak ada data
                  </td>
               </tr>
               @endforelse
            </tbody>
         </table>
      </div>
   </div>
</div>

<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">List Tryout</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>Nama Siswa</th>
                     <th>Paket Tryout</th>
                     <th>Nilai</th>
                     <th>Tanggal Tryout</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody id="body_table">
                  
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
   <script src="{{ asset('assets/vendor/moment.js') }}"></script>
   <script>
      const URL = `{{ url('dashboard/hasiltryout/siswa') }}`
      async function detailTryout(id) {
         await new Promise((resolve, reject) => {
            fetch(`${URL}/${id}`)
            .then(response => response.json())
            .then((res) => {
               let data = res.data
               if(data.length > 0) {
                  let html = ``
                  data.forEach(element => {
                     let tgl = moment(element.created_at).format('D MMMM YYYY')
                     html += `<tr>
                              <td>${element.user.name}</td>
                              <td>${element.paket.nama}</td>
                              <td>${element.nilai_awal}</td>
                              <td>${tgl}</td>
                              <td><a href="${URL}/${element.id}/${element.paket.slug}/detail"><i class="fas fa-eye"></i></a></td>
                           </tr>`
                  })
                  $('#body_table').html(html)
                  $('#modalData').modal('show')
               } else {
                  $('#body_table').html(`<tr> <td colspan="5" class="text-center"> Belum melaksanakan tryout </td> </tr>`)
                  $('#modalData').modal('show')
               }
            })
         })
      }
   </script>
@endsection