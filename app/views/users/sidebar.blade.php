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

<h2>Settings</h2>
<ul>
    <li>{{ HTML::link('users/update', 'Edit Account Details') }}</li>
</ul>
