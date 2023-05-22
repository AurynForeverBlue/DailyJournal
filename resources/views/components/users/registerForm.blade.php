<form action="{{ route('createUser') }}" method="post">
    @csrf
    
    <label for="email">Email</label>
    <input type="email" name="email" required><br>

    <label for="username">Username</label>
    <input type="text" name="username" required><br>

    <label for="password">Password</label>
    <input type="password" name="password" required><br>

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" required><br>
    <input type="submit" value="Register" class="btn btn-blue">
</form>