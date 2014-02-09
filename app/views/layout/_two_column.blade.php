@extends('layout.master')

@section('content')
    <aside class="sidebar one-third">
        @yield('sidebar')
    </aside>

    <section class="content two-thirds">
        @yield('content')
    </section>
@override
