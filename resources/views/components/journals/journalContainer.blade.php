<div id="journal-container">
    @foreach ($journals as $journal)
        @include('components.journals.item')
    @endforeach
</div>