@extends('layout._two_column')

@section('styles')
    {{ HTML::style('css/default.min.css') }}
@overwrite

@section('logo')
@overwrite

@section('nav-bar')
    @include('charity.navbar')
@overwrite


@section('sidebar')
    @include('charity.sidebar')
@overwrite
