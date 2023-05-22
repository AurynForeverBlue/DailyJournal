@extends('layout')
@section('main')
    <x-authenticate-card>
        <h2>Register</h2>

        @include('components.users.registerForm')

        <p>Already have an account, <a href="/login">login here</a></p>
    </x-authenticate-card>
@endsection