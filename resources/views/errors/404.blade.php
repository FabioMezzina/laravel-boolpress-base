@extends('layouts.main')

@section('content')
    <div class="container text-center">
      <h1>404</h1>
      <p>Page not found :(</p>
      <a class="btn btn-primary" href="{{ route('home') }}">Back to home</a>
    </div>
@endsection