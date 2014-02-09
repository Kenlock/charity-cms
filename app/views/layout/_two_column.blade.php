@extends('layout.master')

@section('content')
    <aside class="grid__item sidebar one-third palm-one-whole">
        <div class="container">
            {{ $sidebar }}
        </div>
    </aside><!--

    --><section class="grid__item content two-thirds palm-one-whole">
        <div class="container">
            {{ $content }}
        </div>
    </section>
@overwrite
