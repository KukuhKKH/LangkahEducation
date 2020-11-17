@extends('errors::illustrated-layout')

@section('title', __('Server Error'))
@section('image')
 <img class="img-fluid p-3"  src="{{asset('assets/img/500-illustration.svg')}}">
@endsection
@section('message', __('Server Error'))
