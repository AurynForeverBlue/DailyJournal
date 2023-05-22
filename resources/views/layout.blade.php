<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DailyJournal | Share your daily story</title>
    <meta name="description" content="Do you want to share your daily story with the world. Here you can do so. You can even stay Anonymous">

    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
</head>
<body>
    <nav id="navbar">
        <div>
            <a href="/" id="page-title"><h1>DailyJournal</h1></a>
        </div>
        
        <div id="navbar-button">
            @auth
                <a href="/create/journal" class="btn btn-blue">Create Journal</a>
                <a href="/logout" class="btn btn-red">Logout</a>
            @endauth
            @guest
                <a href="/login" class="btn btn-blue">Login</a>
            @endguest
        </div>
    </nav>
    @yield('main')
</body>
</html>