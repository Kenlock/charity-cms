@extends('layout._two_column')

@section('logo')
@overwrite

@section('nav-bar')
    @include('charity.navbar')
@overwrite


@section('sidebar')
    @include('charity.sidebar')
@overwrite
