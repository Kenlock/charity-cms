@extends('emails.master')

@section('body')
    <h2>New Comment on {{ $charity->name }}</h2>
    <p>
        Hi {{ $charity->name }}, <br />
        Someone commented on your post '{{ $post->title }}'.
    </p>
    <p>
        Click {{ HTML::link($post->getLink(), 'here') }} to view it
    </p>
@overwrite
