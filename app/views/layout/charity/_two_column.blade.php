@extends('layout._two_column')

@section('logo')
@overwrite

@section('nav-bar')
    <ul>
        @foreach ($pages as $page)
            <li>{{ HTML::link("c/charity/{$charity->name}/{$page->page_id}", $page->title) }}</li>
        @endforeach
        <li>{{ HTML::link("c/about/{$charity->name}", "About") }}</li>
    </ul>
@overwrite

@section('sidebar')
    @include('charity.sidebar')
@overwrite
