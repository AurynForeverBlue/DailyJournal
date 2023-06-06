<form action="{{ route("updatePassword") }}" method="post">
    <input type="password" name="updated_password" id=""><br>
    <label for="">Confirm Password</label><br>
    <input type="password" name="confirm_updated_password" id="">
    <br>
    <input type="submit" value="Update Password">
</form>