@extends('emails.master')

@section('body')

    <h2>New Message:</h2>
    {{ isset($name) ? $name . ': ' : '' }}{{ $email }}
    has contacted you via the contact page on the website:

    <p>
        """

        {{ $content }}

        """
    <p>
@overwrite
