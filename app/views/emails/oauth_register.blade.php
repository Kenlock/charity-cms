@extends('emails.master')

@section('body')

<p>
    Hi {{ $firstname }} {{ $lastname }},
</p>

<p>
    Thank you for registering an account with us at Altruisco using the {{ $provider }}
    service.<br />
    You can continue logging into the site using {{ $provider }}, however, if you wish
    to login without this service, your details are as follows:
</p>

<p>
    <strong>Email</strong>: {{ $email }}
    <strong>Password</strong>: {{ $password }}
</p>

<p>
    We recommend that you change this password when you get a chance to a more
    memorable one!
</p>

<p>
    Thank you for using Altruisco, have a wonderful day!
    ~Altruisco Team
</p>

@overwrite
