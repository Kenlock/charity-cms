<?php $url = "c/charity/$charity->name"; ?>

@section('nav-bar')
    @include('charity.navbar', $pages)
@overwrite

<section class="content-block">
    <h2>{{ $title }}</h2>
    {{ isset($content) ? $content : Lang::get("strings.nothing_here") }}
</section>
