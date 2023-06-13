<form action="{{ route("updatePassword") }}" method="post">
    @csrf
    <input type="password" name="password" id=""><br>
    <label for="">Confirm Password</label><br>
    <input type="password" name="password_confirmation" id="">
    <br>
    <input type="submit" value="Update Password">
</form>