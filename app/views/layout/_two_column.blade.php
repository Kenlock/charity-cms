@extends('layout.master')

@section('content')
    <aside class="sidebar">
        @yield('sidebar')
    </aside>

    <section class="content">
        @yield('content')
    </section>
@override
