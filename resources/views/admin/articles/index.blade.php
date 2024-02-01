@extends('admin.layouts.app')

@section('title')
    Articles
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
    </div>
    <main class="col-md-4 ms-sm-auto col-lg-10 px-md-4">
        <div class="row my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h3 class="mt-2">
                            Articles ({{ $articles->count() }})
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Preview</th>
                                    <th>Published</th>
                                    <th>By</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{$article->id}}</td>
                                        <td>{{$article->title}}</td>
                                        <td>
                                            <img src="{{asset($article->image)}}" alt="{{$article->title}}" 
                                                width="60"
                                                height="60"
                                                class="rounded">
                                        </td>
                                        <td>
                                            @if ($article->published)
                                                <span class="badge bg-success">
                                                    Live
                                                </span>
                                            @else 
                                                <span class="badge bg-warning">
                                                    Under Review
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $article->user->name }}
                                        </td>
                                        <td>
                                            {{ $article->created_at }}
                                        </td>
                                        <td>
                                            @if ($article->published)
                                                <a href="{{route('admin.articles.edit', ['article' => $article, 'published' => 0])}}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-eye-slash"></i>
                                                </a>
                                            @else 
                                                <a href="{{route('admin.articles.edit', ['article' => $article, 'published' => 1])}}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            <a onclick="deleteItem({{$article->id}})" class="btn btn-sm btn-danger" 
                                                href="#" >
                                                <i class="fas fa-trash"></i> 
                                            </a>
                                            <form id="{{$article->id}}" action="{{route('admin.articles.destroy', $article)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection