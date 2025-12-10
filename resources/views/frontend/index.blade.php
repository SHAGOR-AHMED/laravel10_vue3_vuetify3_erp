<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demo Frontend</title>
        <link rel="stylesheet" href="{{ asset('css/admin/common/preloader.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/common/button-color.css') }}">
    </head>
    <body>
        <div class="container-fluid" id="app">
            <frontend-index-component></frontend-index-component>
        </div>
         @vite(['resources/sass/app.scss', 'resources/js/components/frontend/js/app.js'])
    </body>
</html>