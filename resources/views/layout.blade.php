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
        <a href="/" id="page-title"><h1>DailyJournal</h1></a>
        
        @auth
        <p>fuck</p>
        @endauth
        @guest
            <a href="/login" class="btn btn-blue">Login</a>
        @endguest
    </nav>
    @yield('main')
</body>
</html>