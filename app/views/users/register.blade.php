{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup', 'files' => true)) }}
    <h2 class="form-signup-heading">Please Register</h2>
    <p>
        {{ Lang::get('forms.register_description') }}
    </p>
 
@include('_errors')

<ul class="form-fields">
    @include('charity.form._fields')
 
    <li>{{ Form::submit(Lang::get('buttons.register'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
