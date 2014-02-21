<?php $url = "c/charity/$charity->name"; ?>

@section('nav-bar')
    @include('charity.navbar')
@overwrite

<section class="posts">
    <h1>{{ $title }}</h1>
    {{ isset($content) ? $content : Lang::get("strings.nothing_here") }}
</section>
