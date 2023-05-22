<form action="{{ route('createUser') }}" method="post">
    @csrf
    
    <input type="email" name="email" placeholder="Email" required><br>

    <input type="text" name="username" placeholder="Username" required><br>

    <input type="password" name="password" placeholder="Password" required><br>

    <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>
    <input type="submit" value="Login">
</form>