<form action="{{ route("storeJournal") }}" method="post">
    @csrf
    <label for="title">Title</label><br>
    <input type="text" name="title" id="title"><br>

    <label for="body">Body</label><br>
    <textarea name="body" id="body"></textarea><br>

    <input type="submit" value="Post journal entry" class="btn btn-blue">
</form>