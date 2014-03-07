@extends('layout._two_column')

@section('styles')
    {{ HTML::style('css/default.min.css') }}
    @if (isset($charity))
        @include('charity.styles', array('styles' => $charity->getStyles()))
    @endif
@overwrite

@section('logo')
@overwrite

@section('nav-bar')
    @include('charity.navbar')
@overwrite


@section('sidebar')
    @include('charity.sidebar')
@overwrite
