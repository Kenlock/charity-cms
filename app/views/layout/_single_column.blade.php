@extends('layout.master')

@section('content')
    <section class="content">
        {{ isset($content) ? $content : '' }}
    </section>
@overwrite
