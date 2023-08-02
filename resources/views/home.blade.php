@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    
@stop

@section('content')
    <p>Halo, {{ $user->name }}! Selamat datang di dashboard.</p>

    @if($user->role === 'admin')
        <!-- Tampilkan elemen khusus admin di sini -->
        <p>Anda masuk sebagai admin.</p>
    @endif

    @if($user->role === 'pimpinan')
        <!-- Tampilkan elemen khusus pimpinan di sini -->
        <p>Anda masuk sebagai pimpinan.</p>
    @endif

    @if($user->role === 'kasir')
        <!-- Tampilkan elemen khusus kasir di sini -->
        <p>Anda masuk sebagai kasir.</p>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

