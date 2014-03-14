<?php
$heart_class = Auth::check() && Auth::user()->hasFavorited($charity) ? 'heart-large' : 'heart-grey-large';
?>

<div class="hearts">
    {{ HTML::image('css/images/heart.jpg', 'Heart Image') }}
    {{ $charity->getFavoriteCount() }}
</div>

<section class="sidebar-content">

    <figure>
        {{ HTML::image($charity->getPresenter()->image, 'Charity Logo') }}
    </figure>
    <h2>{{ $charity->name }}</h2>

    @if (isset($page))
        <section class="contributors">
            <h2>Contributors</h2>
            <ul>
                @if ($page->open_to_all)
                    All Users
                @else
                    @foreach ($page->getContributors() as $contributor)
                        <li>{{ $contributor->getPresenter()->getName() }}</li>
                    @endforeach
                @endif
            </ul>
        </section>
    @endif
    
    <ul class="social">
        <li>
            <a href="{{ URL::to("favorite/{$charity->name}") }}" class="{{ $heart_class }}" title="Favorite this Charity"></a>
        </li>
        @foreach ($charity->socialLinks as $link)
            @if ($link->url != "")
                <li>
                    <a href="{{ URL::to($link->url) }}" title="{{ $link->service }}"><img src="{{ asset("css/images/social/{$link->service}.png") }}" /></a>
                </li>
            @endif
        @endforeach
    </ul>
    <div class="donate-button">
        @include('paypal.donate_button', array('charity' => $charity))
        @include('google-translate')
    </div>

</section> <!-- .sidebar-content -->
