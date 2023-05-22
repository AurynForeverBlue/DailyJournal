<form action="{{ route('authenticateUser') }}" method="post">
    @csrf

    <label for="username">Username</label>
    <input type="text" name="username" value="{{ old('username') }}" required>
    
    <label for="password">Password</label>
    <input type="password" name="password" required>

    <input type="submit" value="Login" class="btn btn-blue">
</form>