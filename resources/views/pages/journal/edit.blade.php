@extends('pages.layout')
@section('main')
    <div id="journal-form">
        <h2>Update your journal entry</h2>
        <hr>
        @include('components.journals.editForm')
    </div>
@endsection