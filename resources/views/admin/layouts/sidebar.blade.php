<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('admin.index')) active @endif" aria-current="page" href="{{route('admin.index')}}">
                    <i class="fas fa-dashboard"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('admin.tags.index')) active @endif" aria-current="page" href="{{route('admin.tags.index')}}">
                    <i class="fas fa-tags"></i>
                    Tags
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('admin.articles.index')) active @endif" aria-current="page" href="{{route('admin.articles.index')}}">
                    <i class="fas fa-pencil"></i>
                    Articles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('admin.users.index')) active @endif" aria-current="page" href="{{route('admin.users.index')}}">
                    <i class="fas fa-users"></i>
                    Users
                </a>
            </li>
        </ul>
    </div>
</nav>