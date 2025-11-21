<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demo Frontend</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/frontend/app.css') }}">
    </head>
    <body>
        <div id="app">
            <div v-if="preloader" class="loader">
                <div class="loader-icon">Loading...</div>
            </div>
            <frontend-index-component></frontend-index-component>
        </div>
        <script src="{{ mix('js/frontend/app.js') }}"></script>
    </body>
</html>