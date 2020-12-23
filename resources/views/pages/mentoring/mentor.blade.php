@extends('layouts.dashboard-app')
@section('title', 'Daftar Siswa')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Daftar Siswa</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
            <div class="text-center" id="loading" style="display: none">
                <div class="spinner-border text-primary spinner-border-lg" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="get">
            <div class="row mb-4 ">
                <div class="col-xl-6">
                    <input type="text" class="form-control my-1" name="keyword" placeholder="Masukkan Nama siswa">
                </div>
                <div class="col-xl-3">
                    <button type="submit" class="btn btn-primary my-1">Cari</button>
                    <a href="{{ route('mentorig.siswa') }}" class="btn btn-lght text-danger my-1">Reset Filter</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Asal Sekolah</th>
                        <th>NISN</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Asal Sekolah</th>
                        <th>NISN</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($mentor as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->user->name }}</td>
                        <td>{{ $value->asal_sekolah }}</td>
                        <td>{{ $value->nisn }}</td>
                        <td>
                            <a href="{{ route('mentorig.mentoring', $value->id) }}" class="btn btn-success my-1"
                                data-toggle="tooltip" data-placement="top" title="Virtual Mentoring">
                                <i class="fas fa-fw fa-comment"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="detailTryout({{ $value->user->id }})"
                                class="btn btn-primary my-1" data-toggle="tooltip" data-placement="top"
                                title="Analisis hasil tryout">
                                <i class="fas fa-fw fa-desktop"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Data</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $mentor->appends($data)->links() }}
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
                            <th>Tanggal Tryout Berakhir</th>
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
        $('#loading').show()
        await new Promise((resolve, reject) => {
            fetch(`${URL}/${id}`)
                .then(response => response.json())
                .then((res) => {
                    $('#loading').hide()
                    let data = res.data
                    console.log(data)
                    if (data.length > 0) {
                        let html = ``
                        data.forEach(element => {
                            let tgl = moment(element.created_at).format('D MMMM YYYY')
                            let tgl2 = moment(element.paket.tgl_akhir).format('D MMMM YYYY')
                            html += `<tr>
                              <td>${element.user.name}</td>
                              <td>${element.paket.nama}</td>
                              <td>${element.nilai_awal}</td>
                              <td>${tgl}</td>
                              <td>${tgl2}</td>
                              <td><a href="${URL}/${element.id}/${element.paket.slug}/detail?kelompok=${element.paket.temp[0].kelompok_passing_grade_id}&prodi-1=${element.paket.temp[0].passing_grade_id}&prodi-2=${element.paket.temp[1].passing_grade_id}"><i class="fas fa-eye"></i></a></td>
                           </tr>`
                        })
                        $('#body_table').html(html)
                        $('#modalData').modal('show')
                    } else {
                        $('#body_table').html(
                            `<tr> <td colspan="5" class="text-center"> Belum melaksanakan tryout </td> </tr>`
                            )
                        $('#modalData').modal('show')
                    }
                })
        })
    }

</script>
@endsection
