<form action="{{ route("updateUsername") }}" method="post">
    @csrf
    <input type="text" name="username" id="">
    <br>
    <input type="submit" value="Update Username">
</form>