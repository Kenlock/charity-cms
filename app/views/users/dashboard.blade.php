<?php $myCharities = Auth::user()->getCharities(); ?>

@section('sidebar')
    <h2>Favorite Charities</h2>
    <ul class="heart-list">
        @if (isset($myFavoriteCharities) and count($myFavoriteCharities) > 0)
            @foreach ($myFavoriteCharities as $charity)
                <li>{{ HTML::link("c/charity/{$charity->name}", $charity->name) }}</li>
            @endforeach
        @else
            <li>You have not favorited any charities</li>
        @endif
    </ul>
@overwrite

<h1>Dashboard</h1>
 
<section>

    @if (count($myCharities) > 0)
        <h2>My Charities</h2>
        <ul>
            @foreach($myCharities as $charity)
                <li>
                    {{ HTML::link("c/charity/{$charity->name}", $charity->name) }}
                    ({{ HTML::link("c/dashboard/{$charity->name}", 'Dashboard') }})
                </li>
            @endforeach
        </ul>
    @endif

    <h2>Other Actions</h2>
    <ul>
        <li>{{ HTML::link('c/create', 'Create a charity') }}</li>
        <li>{{ HTML::link('c/', 'View all charities') }}</li>
    </ul>

</section>
