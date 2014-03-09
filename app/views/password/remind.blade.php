<h2>Request Password Reminder</h2>

@if (Session::has('error'))
    {{ trans(Session::get('reason')) }}
@elseif (Session::has('success'))
    An email with the password reset has been sent.
@endif
 
{{ Form::open(array('route' => 'password.request')) }}
    <ul class="form-fields">
     
        <li>
            {{ Form::label('email', 'Email') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::submit('Submit') }}
        </li>
     
    </ul>
{{ Form::close() }}
