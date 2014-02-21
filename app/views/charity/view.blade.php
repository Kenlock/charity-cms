<?php $url = "c/charity/$charity->name"; ?>

@section('styles')
    {{ HTML::style('css/default.min.css') }}
@overwrite

@section('nav-bar')
    @include('charity.navbar', $pages)
@overwrite

<section class="posts">
    <h1>{{ $title }}</h1>
    {{ isset($content) ? $content : Lang::get("strings.nothing_here") }}
</section>
