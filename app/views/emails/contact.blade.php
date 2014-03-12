@extends('emails.master')

@section('body')
    {{ isset($name) ? $name . ': ' : '' }}{{ $email }}
    has contacted you via the contact page on the website:

    """

    {{ $content }}

    """
@overwrite
