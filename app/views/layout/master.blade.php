<!DOCTYPE html>

<html lang="en">

<head>
    <title>{{ isset($title) ? $title : 'Charity CMS' }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @section('styles')
        {{ HTML::style('css/style.min.css') }}
    @show
</head>

<body>

    <div id="wrapper">
        
        <header class="header">
            <nav class="nav wrapper">
                <a href="{{ URL::to('/') }}">
                    <img src="{{ asset('css/images/logo.png') }}" alt="Altruisco Logo" class="logo" />
                </a>
                @section('nav-bar')
                    @include('layout.main-nav')
                @show
            </nav>
        </header> <!-- .header -->

        <div id="main-content" class="wrapper">

            @include('layout._flash')

            <div class="grid-wrapper">        
                @yield('content')
            </div>

        </div> <!-- .wrapper -->

    </div>

    @include('layout.footer')

    @section('scripts')

    @show
</body>

</html>
