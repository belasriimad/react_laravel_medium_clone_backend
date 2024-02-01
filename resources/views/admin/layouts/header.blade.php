<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <div class="navbar-brand col-md-4 col-lg-3 me-0 px-3">
        <a href="#" class="text-decoration-none text-white">
            <i class="fas fa-user-tie"></i>
            {{ auth()->guard('admin')->user()->name }}
        </a>
        <a onclick="document.getElementById('adminLogout').submit()" class="text-decoration-none text-white mx-3" 
            href="#" >
            <i class="fas fa-sign-out"></i> 
            Sign out
        </a>
        <form id="adminLogout" action="{{route('admin.logout')}}" method="post">
            @csrf
        </form>
    </div>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>        
</header>