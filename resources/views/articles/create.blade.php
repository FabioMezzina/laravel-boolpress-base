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
  <h2>Create new article</h2>
  <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    {{-- Article title --}}
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
    </div>
    {{-- Article body --}}
    <div class="form-group">
      <label for="body">Body</label>
      <textarea class="form-control" id="body" name="body">{{ old('body') }}</textarea>
    </div>
    {{-- Article author --}}
    <div class="form-group">
      <label for="author">Author</label>
      <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}">
    </div>
    {{-- Article image --}}
    <div class="form-group">
      <label for="image">Image</label>
      <input type="file" class="form-control" accept="image/*" name="path_img">
    </div>
    {{-- Tag section --}}
    <div class="form-group">
      <label>Select one or more tags for your article</label>
      @foreach ($tags as $tag)
      <div class="form-check">
        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}">
        <label for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
      </div>
      @endforeach
    </div>
    {{-- Submit article --}}
    <input type="submit" value="Create article" class="btn btn-primary">
  </form>
</div>
@endsection