@extends('layouts.main')

@section('content')
    <div class="container alert alert-dark">
      <h2>{{ $article->title }}</h2>
      <small>Author: {{ $article->author }}</small>
      <p>{{ $article->body }}</p>
      @if (!empty($article->path_img))
          <img src="{{ asset('storage/' . $article->path_img) }}" alt="">
      @endif
    </div>
@endsection