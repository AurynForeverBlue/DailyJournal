@extends('pages.layout')
@section('main')
    <div id="journal-form">
        <h2>Create a Journal entry</h2>
        <hr>
        @include('components.journals.createForm')
    </div>
@endsection