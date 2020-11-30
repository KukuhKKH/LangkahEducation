@extends('layouts.dashboard-app')
@section('title', 'Pembayaran')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Pembayaran</h1>
<div class="row">
    <div class="col-xl-4 col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h6 class="m-0 font-weight-bold text-dark">Pilih Metode Pembayaran</h6>
                <hr>
                <form action="">
                    <div class="row">
                        @foreach ($rekening as $value)
                            <div class="col-lg-6 form-group">
                                <input class="mr-3 mt-3" type="radio" name="listBank" value="{{ $value->id }}">
                                <img class="img-fluid w-50" src="{{asset("upload/bank/$value->logo")}}" alt="">
                            </div>
                        @endforeach

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-xl-12 pl-5">
                        <small>Invoice No.</small>
                        <h3 class="text-success font-weight-bold">#123</h4>
                    </div> --}}
                </div>
                <hr>
                <div id="bankNotSelected" class="text-center p-3">
                    <img class="w-25" src="{{asset('assets/img/payment-illustration.svg')}}" alt="Pilih Bank">
                    <h4>Pilih Metode Pembayaran terlebih dahulu</h4>
                </div>
                <div id="rekeningBank" class="row">
                    <div class="col-xl-8 p-5">
                        <h4 id="nmBank" class="text-dark font-weight-bold"></h4>
                        <small></small>
                        <h1 id="noRekBank" class="text-langkah font-weight-bold "></h1>
                        <h6>a/n <span id="aliasBank"></span></h6>
                    </div>
                    <div class="col-xl-4 d-flex align-items-center">
                        <img id="imgBank" class="img-fluid w-75" src="" alt="Logo Bank">
                    </div>
                </div>
                <table class="table">
                    <tr>
                        <td>
                            Pembayaran Try Out - {{ $pembayaran->gelombang->nama }}
                        </td>
                        <td>
                            RP. {{ number_format($pembayaran->gelombang->harga) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kode Unik
                        </td>
                        <td>
                            {{ $pembayaran->kode_transfer }}
                        </td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td>
                            Total
                        </td>
                        <td>
                            <?php $total = $pembayaran->kode_transfer + $pembayaran->gelombang->harga ?>
                            RP. {{ number_format($total) }}
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="mt-4">
                    <h6 class="font-weight-bold">Petunjuk Transfer Bank :</h6>
                    <ol type="1">
                        <li>
                            Pilih Jenis Transaksi: Pilih “Transfer”
                        </li>
                        <li>
                            Pilih Bank Tujuan Transfer
                        </li>
                        <li>
                            Masukkan Nominal Uang
                            <small>Masukkan Nominal sampai 3 digit terakhir atau konfirmasi pembayaran tidak dapat
                                diproses</small>
                        </li>
                        <li>
                            Simpan struk pembayaran sebagai bukti transfer
                        </li>
                        <li>
                            Upload bukti transfer <a href="{{ route('pembayaran.siswa.show', ['pembayaran_id' => $pembayaran->id, 'slug' => $pembayaran->gelombang->slug]) }}">disini</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    const URL = `{{ url('dashboard/bank') }}`
    const URL_ASSET = `{{ asset('upload/bank') }}`
    $(document).ready(function() {
        if (!$('input[type=radio][name=listBank]:checked').val() ) {
            $('#rekeningBank').hide();
            $('#bankNotSelected').show();
        }
    });
    $('input[type=radio][name=listBank]').change(function () {
        $('#rekeningBank').show();
        $('#bankNotSelected').hide();
        $.ajax({
            url: `${URL}/${this.value}`,
            method: 'get',
            dataType: 'JSON',
            success: function(res) {
                let data = res.data
                $("#nmBank").text(data.nama);
                $("#noRekBank").text(data.nomer_rekening);
                $("#aliasBank").text(data.alias);
                $("#imgBank").attr("src", `${URL_ASSET}/${data.logo}`);
            }
        })
        // if (this.value == '0') {
        //     $("#nmBank").text("Bank BNI Syariah");
        //     $("#noRekBank").text("0123 456 78900");
        //     $("#aliasBank").text("BNI Langkah");
        //     $("#imgBank").attr("src", "{{asset('assets/img/bni.png')}}");
        // } else if (this.value == '1') {
        //     $("#nmBank").text("Bank BRI");
        //     $("#noRekBank").text("9999 9999 9999");
        //     $("#aliasBank").text("BRI Langkah");
        //     $("#imgBank").attr("src", "{{asset('assets/img/bri.png')}}");
        // }
    });

</script>
@endsection
