<!DOCTYPE html>

<html lang="en">

<head>
    <title>@yield('title', 'Charity CMS')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @section('styles')
        {{ HTML::style('css/style.min.css') }}
    @show
</head>

<body>

    <div id="wrapper">
        
        <nav class="nav">
            @section('nav-bar')
                @include('layout.main-nav')
            @show
        </nav>

        @include('layout._flash')

        <div class="grid-wrapper">        
            @yield('content')
        </div>
    </div>

    @section('scripts')

    @show
</body>

</html>
