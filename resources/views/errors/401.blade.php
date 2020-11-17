@extends('errors::illustrated-layout')

@section('title', __('Unauthorized'))
@section('image')
 <img class="img-fluid p-3"  src="{{asset('assets/img/401-illustration.svg')}}">
@endsection
@section('message', __('Unauthorized'))
