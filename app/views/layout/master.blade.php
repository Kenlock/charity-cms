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
        
        @include('layout._flash')

        @yield('content')
    </div>

    @section('scripts')

    @show
</body>

</html>
