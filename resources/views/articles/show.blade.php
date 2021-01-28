@extends('layouts.main')

@section('content')
    <div class="container alert alert-dark">
      <h2>{{ $article->title }}</h2>
      @foreach ($tags as $tag)
          @if ($article->tags->contains($tag))
            <span class="badge badge-danger">
              {{$tag->name}}
            </span>
          @endif
      @endforeach
      <p>Author: {{ $article->author }}</p>
      <p>{{ $article->body }}</p>
      @if (!empty($article->path_img))
          <img src="{{ asset('storage/' . $article->path_img) }}" alt="">
      @endif
    </div>
@endsection