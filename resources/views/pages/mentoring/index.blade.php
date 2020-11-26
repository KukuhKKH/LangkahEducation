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
                        <h6 class="ml-3 font-weight-bold text-dark">Nama Mentor</h6>
                    </div>
                    <div class="col-2 text-right">
                        <button class="btn btn-light"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="mentoring">
                <div class="chat other-chat">
                    <div class="font-weight-bold mb-1">Nama Mentor</div>
                    <p>Lorem ipsum dolor sit amet.</p>
                    <div class="send-time">
                        5:16
                    </div>
                </div>
                <div class="chat your-chat">
                    <div class="font-weight-bold mb-1">Kamu</div>
                    <p>Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.</p>
                    <div class="send-time">
                        5:16
                    </div>
                </div>
                <div class="chat other-chat">
                    <div class="font-weight-bold mb-1">Nama Mentor</div>
                    <p>Lorem ipsum dolor sit amet.</p>
                    <div class="send-time">
                        5:16
                    </div>
                </div>
                <div class="chat your-chat">
                    <div class="font-weight-bold mb-1">Kamu</div>
                    <p>Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.</p>
                    <div class="send-time">
                        5:16
                    </div>
                </div>
                <div class="chat other-chat">
                    <div class="font-weight-bold mb-1">Nama Mentor</div>
                    <p>Lorem ipsum dolor sit amet.</p>
                    <div class="send-time">
                        5:16
                    </div>
                </div>
                <div class="chat your-chat">
                    <div class="font-weight-bold mb-1">Kamu</div>
                    <p>Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.</p>
                    <div class="send-time">
                        5:16
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <input type="text" class="form-control mr-2" placeholder="Tulis Pesan">
                    <button class="btn btn-langkah">Kirim</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
