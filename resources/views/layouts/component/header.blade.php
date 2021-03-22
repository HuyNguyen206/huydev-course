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
                <a class="btn btn-sm btn-white mr-4" data-toggle="modal" data-target="#login-form"
                   href="page-login.html">Hi {{auth()->user()->name}}</a>
            @endauth
        </div>

    </div>
</nav>
<!-- END Topbar -->


<!-- Header -->
<header class="header header-inverse h-fullscreen p-0 bg-primary overflow-hidden"
        style="background-image: linear-gradient(to right, #434343 0%, black 100%);">
    <canvas class="constellation"></canvas>

    <div class="container text-center">

        <div class="row h-full align-items-center">
            <div class="col-12 col-md-8 offset-md-2">

                <h1 class="display-4">NORA</h1>
                <br>
                <p class="lead text-white fs-20">Nora is an awesome web development learning subscription baseed SaaS
                    application powered with Vuejs and Laravel.</p>
                <br>
                <a class="btn btn-xl btn-round btn-primary" href="#">Start a project</a>
                <a class="btn btn-xl btn-round btn-outline-primary" href="#">Feature</a>

            </div>
        </div>

    </div>
</header>
<!-- END Header -->
