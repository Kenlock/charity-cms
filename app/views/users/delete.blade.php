<h1>Delete Account</h1>
<p>
    Are you sure you want to delete your account? This is a permanent action
    which cannot be undone.
</p>

@include('_errors')

{{ Form::open() }}
    <ul class="form-fields">
        <li>
            {{ Form::label('confirm_delete', 'I want to delete my account') }}
            {{ Form::checkbox('confirm_delete', 'yes') }}
        </li>

        <li>
            {{ Form::submit('Confirm') }}
        </li>
    </ul>
{{ Form::close() }}
