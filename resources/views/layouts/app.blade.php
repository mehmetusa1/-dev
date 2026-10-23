<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mehmet'in Blogu</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
<main>
    <header>
        <h1><a href="{{ route('posts.index') }}">Mehmet'in Blogu</a></h1>
        <hr>
    </header>
    @if(session('success'))
        <p class="message">{{ session('success') }}</p>
    @endif
    @if($errors->any())
        <div class="message error" role="alert">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    @yield('content')
    <footer>Mehmet'in Blogu — Tüm hakları saklıdır.</footer>
</main>
</body>
</html>
