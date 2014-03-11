{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup', 'files' => true)) }}
    <h2 class="form-signup-heading">Please Register</h2>
    <p>
        {{ Lang::get('forms.register_description') }}
    </p>
 
   <ul class="form-errors">
      @foreach($errors->all() as $error)
         <li>{{ $error }}</li>
      @endforeach
   </ul>

<script>
    var model = "User";
</script>

<ul class="form-fields">
    <li>
        {{ Form::label('firstname', Lang::get('forms.firstname'), array('class' => 'req')) }}
        {{ Form::text('firstname', null, [
            'placeholder'=>'First Name',
        ]) }}
    </li>
    <li>
        {{ Form::label('lastname', Lang::get('forms.lastname'), array('class' => 'req')) }}
        {{ Form::text('lastname', null, [
            'placeholder'=>'Last Name'
        ]) }}
    </li>
    <li>
        {{ Form::label('email', Lang::get('forms.email'), array('class' => 'req')) }}
        {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
    </li>
    <li>
        {{ Form::label('password', Lang::get('forms.password'), array('class' => 'req')) }}
        {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
    </li>
    <li>
        {{ Form::label('password_confirmation', Lang::get('forms.password_confirmation'), array('class' => 'req')) }}
        {{ Form::password('password_confirmation', [
            'placeholder'=>'Confirm Password'
        ]) }}
    </li>
    <li>
        {{ Form::label('description', Lang::get('forms.about')) }}
        {{ Form::textarea('description', null, [
            'placeholder'=>Lang::get('forms.about')
        ]) }}
    </li>
    <li>
        {{ Form::label('image', Lang::get('forms.user_image')) }}
        {{ Form::file('image') }}
    </li>
 
   <li>{{ Form::submit(Lang::get('buttons.register'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
