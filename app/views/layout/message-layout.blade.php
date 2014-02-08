@extends('layout.master')

@section('content')
    @if(Session::has('message'))
        <div class="message">
            {{ Session::get('message') }}
        </div> <!-- .message -->
    @endif
    
    {{ $content }}

@stop
