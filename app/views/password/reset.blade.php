<h2>Reset Password</h2>

@if (Session::has('error'))

    {{ trans(Session::get('reason')) }}

@endif
 
{{ Form::open(array('route' => array('password.update', $token))) }}

    <ul>
        <li>
            {{ Form::label('email', 'Email') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::label('password', 'Password') }}
            {{ Form::text('password') }}
        </li>

        <li>
            {{ Form::label('password_confirmation', 'Password confirm') }}
            {{ Form::text('password_confirmation') }}
        </li>

        <li>
            {{ Form::submit('Submit') }}
        </li>

    </ul>

    {{ Form::hidden('token', $token) }}
{{ Form::close() }}
