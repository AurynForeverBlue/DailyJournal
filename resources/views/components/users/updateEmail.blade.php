<form action="{{ route("updateEmail") }}" method="post">
    @csrf
    <input type="email" name="email" id="">
    <br>
    <input type="submit" value="Update Email">
</form>