
<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Quiz App - @yield('title')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @livewireStyles
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
        <!-- The "defer" attribute is important to make sure Alpine waits for Livewire to load first. -->
    </head>

    <body class="min-h-screen flex flex-col">
    @include('shared.navbar')

    <!-- Add your site or application content here -->
    @yield('content')

    @livewireScripts
    </body>
</html>
