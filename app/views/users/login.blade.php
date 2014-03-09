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

<small>{{ HTML::linkRoute('password.remind', 'Forgotten your password?') }}</small>

<h4>or sign in with:</h4>
<ul class="btn-list">
    <li>{{ HTML::link('oauth/google', 'Google+', array('class' => 'google-plus-btn')) }}</li>
    <li>{{ HTML::link('oauth/facebook', 'Facebook', array('class' => 'facebook-btn')) }}</li>
</ul>
