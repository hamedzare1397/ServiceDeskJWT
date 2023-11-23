@extends('index')
@section('titlePage')سامانه مدیریت ارزیابی خبر@endsection
@section('header')
    @vite(['resources/js/app.js','resources/css/app.css'])
@endsection
@section('content')
    <div id="app">
        <router-view />
    </div>
@endsection
