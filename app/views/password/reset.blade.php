<h2>Reset Password</h2>

@if (Session::has('error'))

    {{ Lang::get(Session::get('reason')) }}

@endif

@include('_errors')
 
{{ Form::open(array('route' => array('password.update', $token))) }}

    <ul class="form-fields">
        <li class="req">
            {{ Form::label('email', 'Email') }}
            {{ Form::text('email') }}
        </li>

        <li class="req">
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password') }}
        </li>

        <li class="req">
            {{ Form::label('password_confirmation', 'Password confirm') }}
            {{ Form::password('password_confirmation') }}
        </li>

        <li>
            {{ Form::submit('Submit') }}
        </li>

    </ul>

    {{ Form::hidden('token', $token) }}
{{ Form::close() }}
