@extends('layouts.main')

@section('content')
<div class="container">
  {{-- errors handling --}}
  @if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
  </div>
  @endif

  {{-- Input form for new article creation --}}
  <h2>Edit article: {{ $article->title }}</h2>
  <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    {{-- Article title --}}
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $article->title) }}">
    </div>
    {{-- Article body --}}
    <div class="form-group">
      <label for="body">Body</label>
      <textarea class="form-control" id="body" name="body">{{ old('body', $article->body) }}</textarea>
    </div>
    {{-- Article author --}}
    <div class="form-group">
      <label for="author">Author</label>
      <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $article->author) }}">
    </div>
    {{-- Article image --}}
    <div class="form-group">
      <label for="image">Image</label><br>
      @if (!empty($article->path_img))
          <img width="150px" src="{{ asset('storage/' . $article->path_img) }}" alt="">
      @endif
      <input type="file" class="form-control" accept="image/*" name="path_img">
    </div>
    {{-- Submit article --}}
    <input type="submit" value="Edit article" class="btn btn-primary">
  </form>
</div>
@endsection