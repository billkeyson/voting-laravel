@include('dashboard.partial._header')

<body class="theme-orange">

<!-- Top Bar -->
@include('dashboard.partial._nav')

<!-- Left Sidebar -->
@include('dashboard.partial._sidebar')


<section class="content">
    @yield('content')

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <p class="m-b-0">© {{date("Y")}} Nuset Admin by <a href="#" target="black">ThemeMakker</a> </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Jquery Core Js --> 
@include('dashboard.partial._footer')

</body>
</html>