<form action="{{ route("updateJournal") }}" method="post">
    @csrf
    <input type="hidden" name="journal_id" value="{{ $journal->journal_id }}">

    <label for="title">Title</label><br>
    <input type="text" name="title" id="title" value="{{ $journal->title }}"><br>

    <label for="body">Body</label><br>
    <textarea name="body" id="body">{{ $journal->body }}</textarea><br>

    <input type="submit" value="Update Journal" class="btn btn-blue">
</form>