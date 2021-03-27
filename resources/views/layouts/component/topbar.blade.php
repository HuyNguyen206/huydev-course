<!-- Topbar -->
<nav class="topbar topbar-inverse topbar-expand-sm">
    <div class="container">

        <div class="topbar-left">
            <a class="topbar-brand" href="index.html">
                <img class="logo-default" src="{{asset('assets/img/logo.png')}}" alt="logo">
                <img class="logo-inverse" src="{{asset('assets/img/logo-light.png')}}" alt="logo">
            </a>
        </div>


        <div class="topbar-right">
            @guest
                <a class="btn btn-sm btn-outline btn-white hidden-sm-down" data-toggle="modal" data-target="#login-form"
                   href="page-login.html">Login</a>
                <a class="btn btn-sm btn-outline btn-white hidden-sm-down" href="page-register.html">Register</a>
            @endauth
            @auth
                    <a class="btn btn-sm btn-white mr-4"
                       href="{{route('series.index')}}">View all series</a>
                    <a class="btn btn-sm btn-white mr-4"
                       href="{{route('series.create')}}">Create series</a>
                <a class="btn btn-sm btn-white mr-4" data-toggle="modal" data-target="#login-form"
                   href="page-login.html">Hi {{auth()->user()->name}}</a>
            @endauth
        </div>

    </div>
</nav>
<!-- END Topbar -->



