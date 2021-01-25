@extends('layouts.main')

@section('content')
<div class="container">
  <table class="table table-dark">
    <thead>
      <tr>
        <th scope="col">#ID</th>
        <th scope="col">Title</th>
        <th scope="col">Author</th>
        <th scope="col">Body</th>
        <th scope="col">Last update</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($articles as $article)
      <tr>
        <td>{{ $article->id }}</td>
        <td>{{ $article->title }}</td>
        <td>{{ $article->author }}</td>
        <td>{{ $article->body }}</td>
        <td>{{ $article->updated_at->diffForHumans() }}</td>
        <td><a href="{{ route('articles.show', $article->slug) }}" class="btn btn-primary">View</a></td>
        <td><a href="{{ route('articles.edit', $article->slug) }}" class="btn btn-success">Edit</a></td>
        <td><a href="" class="btn btn-danger">Delete</a></td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="text-center">No records found</td>
      </tr>
      @endforelse
    </tbody>
  </table>

</div>
@endsection