@extends('layouts.main')

@section('content')
<div class="container">
  @if (session('ref'))
  <div class="alert alert-warning">L'articolo: {{ session('ref') }} è stato eliminato!</div>
  @endif
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
        <td>
          <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" class="btn btn-danger" value="Delete">
          </form>
        </td>
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