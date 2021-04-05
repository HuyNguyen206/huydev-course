<!-- Topbar -->
<nav class="topbar topbar-inverse topbar-expand-sm">
    <div class="container">

        <div class="topbar-left">
            <a class="topbar-brand" href="{{route('home')}}">
                <img class="logo-default" src="{{asset('assets/img/logo.png')}}" alt="logo">
                <img class="logo-inverse" src="{{asset('assets/img/logo-light.png')}}" alt="logo">
            </a>
        </div>


        <div class="topbar-right">
            <a class="btn btn-sm btn-white mr-4"
               href="{{route('home')}}">Home</a>
            @guest
                <a class="btn btn-sm btn-outline btn-white hidden-sm-down" data-toggle="modal" data-target="#login-form"
                   href="page-login.html">Login</a>
                <a class="btn btn-sm btn-outline btn-white hidden-sm-down" href="page-register.html">Register</a>
            @endauth
            @auth
                @admin
                    <a class="btn btn-sm btn-white mr-4"
                       href="{{route('series.index')}}">View all series</a>
                    <a class="btn btn-sm btn-white mr-4"
                       href="{{route('series.create')}}">Create series</a>
                @endadmin
                <a class="btn btn-sm btn-white mr-4"
                   href="{{route('profile', auth()->user()->username)}}">Hi {{auth()->user()->name}}</a>
                <a class="btn btn-sm btn-white mr-4"
                   href="{{route('show-subscribe')}}">Subcribe</a>
                <a class="btn btn-sm btn-white mr-4"
                   href="{{url('logout')}}">Logout</a>
            @endauth
        </div>

    </div>
</nav>
<!-- END Topbar -->



