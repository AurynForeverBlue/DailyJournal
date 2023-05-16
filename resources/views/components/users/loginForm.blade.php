<form action="{{ route('authenticateUser') }}" method="post">
    @csrf

    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required><br>

    <input type="password" name="password" placeholder="Password" required><br>

    <input type="submit" value="Login">
</form>