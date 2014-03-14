@extends('layout._two_column')

@section('styles')
    {{ HTML::style('css/default.min.css') }}
    @if (isset($charity))
        @include('charity.styles', array('styles' => $charity->getStyles()))
    @endif
    <meta name="google-translate-customization" content="bfde03812030233a-6c46fc9f5003a0b1-gd0b861def04713fe-16"></meta>
@overwrite

@section('logo')
@overwrite

@section('nav-bar')
    @include('charity.navbar')
@overwrite


@section('sidebar')
    @include('charity.sidebar')
@overwrite
