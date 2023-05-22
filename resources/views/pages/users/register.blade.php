@extends('layout')
@section('main')
    <x-authenticate-card>
        @include('components.users.registerForm')

        <p>Already have an account, <a href="/login">login here</a></p>
    </x-authenticate-card>
@endsection