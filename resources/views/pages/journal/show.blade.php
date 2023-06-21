@extends('pages.layout')
@section('main')
    <div id="location-page-container">
        @if (!empty($journal))
            <h2>{{ $journal->title }}</h2>
            <p>{{ $journal->body }}</p>

            @if ($journal->user_id == $user_id)
                <a href="/update/{{ $journal->journal_id }}">Update</a>
                <a href="/burninfire/{{ $journal->journal_id }}">Delete</a>
            @endif
        @else
            <h2>There are no Journals</h2>
        @endif
    </div>
@endsection