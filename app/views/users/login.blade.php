{{ Form::open(array('url'=>'users/signin', 'class'=>'form-signin')) }}
   <h2 class="form-signin-heading">Please Login</h2>
 
    <ul class="form-fields">
        <li>
            {{ Form::label('email', Lang::get('forms.email')) }}
            {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
        </li>
        <li>
            {{ Form::label('password', Lang::get('forms.password')) }}
            {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
        </li>
        <li>
            {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}
        </li>
    </ul>
{{ Form::close() }}
