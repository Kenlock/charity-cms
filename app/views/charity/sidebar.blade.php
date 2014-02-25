<?php
$heart_class = Auth::check() && Auth::user()->hasFavorited($charity) ? 'heart-large' : 'heart-grey-large';
?>

<div class="hearts">
    {{ HTML::image('css/images/heart.jpg', 'Heart Image') }}
    {{ $charity->getFavoriteCount() }}
</div>

<section class="sidebar-content">

    <figure>
        @if (isset($charity->image))
            {{ HTML::image($charity->image, 'Charity Logo') }}
        @else
            {{ HTML::image('', 'Default Image') }}
        @endif
    </figure>
    <h2>{{ $charity->name }}</h2>

    
    <a href="{{ URL::to("favorite/{$charity->name}") }}" class="{{ $heart_class }}" title="Favorite this Charity"></a>

</section> <!-- .sidebar-content -->
