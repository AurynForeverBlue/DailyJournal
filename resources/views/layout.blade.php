<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DailyJournal | Share your daily story</title>
    <meta name="description" content="Do you want to share your daily story with the world. Here you can do so. You can even stay Anonymous">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">

    {{-- js --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @yield('js')
</head>
<body>
    <nav id="navbar">
        <div>
            <a href="/" id="page-title"><h1>DailyJournal</h1></a>
        </div>
        
        <div id="navbar-button">
            @auth
                <a href="/write" class="btn btn-blue">Create Journal</a>
                <a href="/settings" class="btn btn-gray">Settings</a>
                <a href="/logout" class="btn btn-red">Logout</a>
            @endauth
            @guest
                <a href="/login" class="btn btn-blue">Login</a>
            @endguest
        </div>
    </nav>

    @if ($errors->any() || session('error'))
        <div id="error-container">
            <ul>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="">{{ $error }}</li>
                    @endforeach
                @endif
                @if (session('error'))
                    <li class="">{{ session('error') }}</li>
                @endif
            </ul>
        </div>
    @endif

    @if (session('succes'))
        <div id="succes-container">
            <ul>
                <li class="">{{ session('succes') }}</li>
            </ul>
        </div>
    @endif

    @yield('main')
</body>
</html>