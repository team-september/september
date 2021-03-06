<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    @stack('styles')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    @stack('scripts')
</head>
<body class="antialiased body">

@include('includes.header')

@if ($errors->any())
    <div class="container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="list-unstyled text-center">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
    </div>
@endif

@if (session('message'))
<div class="container">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p class="text-center m-auto">{{ session('message') }}</p>
        <button class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
</div>
@endif

<main class="main">
    @yield('content')
</main>

@include('includes.footer')
@yield('js')
</body>
</html>

