<?php
    $charities = Charity::getPopular(5);
?>

<ul class="heart-list">
    @foreach ($charities as $charity)
        <li>
            {{ $charity->num_favorites }}
            {{ HTML::link("c/charity/{$charity->name}", $charity->name) }}
        </li>
    @endforeach
</ul>
