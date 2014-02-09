{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}
   <h2 class="form-signup-heading">Please Register</h2>
 
   <ul class="form-errors">
      @foreach($errors->all() as $error)
         <li>{{ $error }}</li>
      @endforeach
   </ul>
<ul class="form-fields">
    <li>
        {{ Form::label('firstname', 'First Name') }}
        {{ Form::text('firstname', null, [
            'class'=>'input-block-level',
            'placeholder'=>'First Name'
        ]) }}
    </li>
    <li>
        {{ Form::label('lastname', 'Last Name') }}
        {{ Form::text('lastname', null, [
            'class'=>'input-block-level',
            'placeholder'=>'Last Name'
        ]) }}
    </li>
    <li>
        {{ Form::label('email', 'Email Address') }}
        {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
    </li>
    <li>
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
    </li>
    <li>
        {{ Form::label('password_confirmation', 'Confirm Password') }}
        {{ Form::password('password_confirmation', [
            'class'=>'input-block-level',
            'placeholder'=>'Confirm Password'
        ]) }}
    </li>
    <li>
        {{ Form::label('description', 'About Your Charity') }}
        {{ Form::textarea('description', null, [
            'class'=>'input-block-level',
            'placeholder'=>'About your Charity'
        ]) }}
    </li>
 
   <li>{{ Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block')) }}</li>
</ul>
{{ Form::close() }}
