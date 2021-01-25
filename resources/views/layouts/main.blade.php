<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Newspaper db</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
      {{-- Header navbar --}}
      @include('partials.header')

      {{-- Main section --}}
      <main>
        @yield('content')
      </main>

      {{-- Footer --}}
      @include('partials.footer')
    </body>
</html>
