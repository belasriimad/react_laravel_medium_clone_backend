@extends('admin.layouts.app')

@section('title')
    Tags
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
    </div>
    <main class="col-md-4 ms-sm-auto col-lg-10 px-md-4">
        <div class="row my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h3 class="mt-2">
                            Tags ({{ $tags->count() }})
                        </h3>
                        <a href="{{route('admin.tags.create')}}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $tag)
                                    <tr>
                                        <td>{{$tag->id}}</td>
                                        <td>{{$tag->name}}</td>
                                        <td>{{$tag->slug}}</td>
                                        <td>
                                            <a href="{{route('admin.tags.edit', $tag)}}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteItem({{$tag->id}})" class="btn btn-sm btn-danger" 
                                                href="#" >
                                                <i class="fas fa-trash"></i> 
                                            </a>
                                            <form id="{{$tag->id}}" action="{{route('admin.tags.destroy', $tag)}}" method="post">
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