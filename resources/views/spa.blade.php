@extends('index')
@section('titlePage')سامانه مدیریت ارزیابی خبر اداره کل حراست شرکت ارتباطات زیرساخت@endsection
@section('header')
    @vite(['resources/js/app.js','resources/css/app.scss'])
@endsection
@section('content')
    <div id="app">
        <router-view />
    </div>
@endsection
