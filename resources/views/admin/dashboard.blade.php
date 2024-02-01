@extends('admin.layouts.app')

@section('title')
    Dashboard
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
                            Dashboard
                        </h3>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center text-secondary">
                            Welcome back {{ auth()->guard('admin')->user()->name }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection