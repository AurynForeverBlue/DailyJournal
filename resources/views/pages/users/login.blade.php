@extends('layout')
@section('main')
    <x-authenticate-card>
        <h2>Login</h2>

        @include('components.users.loginForm')
        
        <p>Don't have an account, <a href="/register">register here</a></p>
    </x-authenticate-card>
@endsection