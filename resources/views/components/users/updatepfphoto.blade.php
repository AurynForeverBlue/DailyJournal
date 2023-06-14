<form action="{{ route("updatePfphoto") }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="pfphoto" id="">
    <br>
    <input type="submit" value="Update Profile Photo">
</form>