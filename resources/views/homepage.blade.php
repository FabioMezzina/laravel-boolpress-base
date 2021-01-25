@extends('layouts.main')

@section('content')
    <div class="container text-center mb-5">
        <h1 class="mb-3">Newspaper article management</h1>
        <a href="{{ route('articles.index') }}" class="btn btn-success">Show article list</a>
        <a href="{{ route('articles.create') }}" class="btn btn-primary">Add a new article</a>
    </div>
@endsection