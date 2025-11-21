<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 10 + Vue 3</title>
    <link rel="stylesheet" href="{{ asset('css/admin/common/preloader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/common/button-color.css') }}">
</head>
<body>
    <div id="app">
        <index-component authuser="{{ Auth::user() }}"></index-component>
    </div>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</body>
</html>