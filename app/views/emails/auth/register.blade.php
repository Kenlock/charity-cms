@extends('emails.master')

@section('body')
    <h1>Thank You</h1>
    <p>
        Hi {{ $user->getPresenter()->getName() }}, thank you for registering an account
        with us on Altruisco.<br />
        Your login username is: {{ $user->email }}, <br />
        and your password is the one you used to sign up.
    </p>
    <p>
        Don't worry if you've forgotten your password, you can reset it by clicking
        {{ URL::to('password/reset', 'here') }}
    </p>
@overwrite
