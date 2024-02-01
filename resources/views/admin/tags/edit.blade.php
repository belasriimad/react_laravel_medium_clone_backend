@extends('admin.layouts.app')

@section('title')
    Edit Tag
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
                            Edit Tag
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.tags.update', $tag)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="my-2">Name*</label>
                                    <input type="text" name="name"
                                        placeholder="Name*"
                                        value="{{$tag->name, old('name')}}"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <button class="btn btn-sm btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection