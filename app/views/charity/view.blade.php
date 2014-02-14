@section('nav-bar')
    <ul>
        <li>{{ HTML::link('#', 'Home') }}</li>
    </ul>
    @include('layout.login-nav')
@overwrite

<section class="content-block">

    <h2>{{ $charity->name }}</h2>

    About Us:
    <p>
        {{ $charity->description }}
    </p>

</section>
