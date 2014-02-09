@extends('layout.master')

@section('content')
    <div class="grid__item one-whole single-column">
        <section class="content">
            {{ isset($content) ? $content : '' }}
        </section>
    </div>
@overwrite
