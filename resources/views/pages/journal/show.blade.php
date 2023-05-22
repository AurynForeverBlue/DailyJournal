@extends('layout')
@section('main')
    <h2>{{ $journal->title }}</h2>
    <p>{{ $journal->body }}</p>

    @if ($journal->user_id == $user_id)
        <a href="/{{ $journal->journal_id }}/edit/journal">Update</a>
        <a href="/{{ $journal->journal_id }}/delete/journal">Delete</a>
    @endif
@endsection