<h1>Dashboard</h1>
 
<section>

    @if (count($myCharities) > 0)
        <h2>My Charities</h2>
        <ul>
            @foreach($myCharities as $charity)
                <li>{{ HTML::link("c/dashboard/{$charity->name}", $charity->name) }}</li>
            @endforeach
        </ul>
    @endif

    <h2>Other Actions</h2>
    <ul>
        <li>{{ HTML::link('c/create', 'Create a charity') }}</li>
        <li>{{ HTML::link('c/', 'View all charities') }}</li>
    </ul>

</section>
