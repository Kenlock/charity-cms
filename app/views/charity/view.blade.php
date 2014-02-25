<?php $url = "c/charity/$charity->name"; ?>

@section('nav-bar')
    @include('charity.navbar')
@overwrite

<section class="posts">
    @if (isset($page) and !Auth::guest() and Auth::user()->canPostTo($page))
        {{ HTML::link("posts/create/{$page->page_id}", 'New Post', array('class' => 'create-btn btn')) }}
    @endif

    <h1>{{ $title }}</h1>
    {{ isset($content) ? $content : Lang::get("strings.nothing_here") }}
</section>
