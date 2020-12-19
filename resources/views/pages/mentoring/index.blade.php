@extends('layouts.dashboard-app')
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- <h6 class="m-0 font-weight-bold text-dark">Virtual Mentoring</h6> --}}
                <div class="row">
                    <div class="col-10 d-flex flex-row align-items-center">
                        <img src="{{asset('assets/img/undraw_profile.svg')}}" alt="profil-mentor" style="height:40px">
                        <h6 class="ml-3 font-weight-bold text-dark">{{ $user->siswa->mentor->first()->user->name }}</h6>
                    </div>
                    <div class="col-2 text-right">
                        <button onclick="window.location.reload()" class="btn btn-light"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="mentoring">

                @forelse ($chat as $value)
                @if ($value->pengirim == 'siswa')
                    <div class="chat your-chat">
                        <div class="font-weight-bold mb-1">Kamu</div>
                        <p>{{ $value->pesan }}</p>
                        <div class="send-time">
                            {{ Carbon\Carbon::parse($value->created_at)->format('d F Y H:i:s') }}
                        </div>
                    </div>
                @else
                    <div class="chat other-chat">
                        <div class="font-weight-bold mb-1">{{ $user->siswa->mentor->first()->user->name }}</div>
                        <p>{{ $value->pesan }}</p>
                        <div class="send-time">
                            {{ Carbon\Carbon::parse($value->created_at)->format('d F Y H:i:s') }}
                        </div>
                    </div>
                @endif
                    
                @empty
                    <div class="text-center">
                        <p>Chat Kosong</p>
                    </div>
                @endforelse

            </div>
            <div class="card-footer">
                <form action="{{ route('kirim_pesan', ['siswa_id' => $user->siswa->id, 'mentor_id' => $user->siswa->mentor->first()->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="pengirim" value="siswa">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                       <input type="text" name="pesan" class="form-control mr-2" placeholder="Tulis Pesan">
                       <button type="submit" class="btn btn-langkah">Kirim</button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function getMessages(letter) {
    var div = $("#mentoring");
    div.scrollTop(div.prop('scrollHeight'));
    }

    $(function() {
        getMessages();
    });

</script>
@endsection
