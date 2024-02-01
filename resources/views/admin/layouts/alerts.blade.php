<div class="row my-5">
    <div class="col-md-6 mx-auto mt-5">
       @session('error')
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
       @endsession
       @session('success')
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
       @endsession
    </div>
</div>