<form action="{{ route("updateBanner") }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" id="">
    <br>
    <input type="submit" value="Update Banner Photo">
</form>