{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}
    <h2 class="form-signup-heading">Create a Charity</h2>
    <p>
        {{ Lang::get('forms.charity_create_description') }}
    </p>
 
   <ul class="form-errors">
      @foreach($errors->all() as $error)
         <li>{{ $error }}</li>
      @endforeach
   </ul>

<ul class="form-fields">
    <li>
        {{ Form::label('charity_name', Lang::get('forms.charity_name'), array('class' => 'req')) }}
        <p>
            {{ Lang::get('forms.charity_name_hint') }}
        </p>
        {{ Form::text('charity_name', null, [
            'placeholder'=> Lang::get('forms.charity_name')
        ]) }}
    </li>
    <li>
        {{ Form::label('charity_description', Lang::get('forms.charity_description'), array('class' => 'req')) }}
        <p>
            {{ Lang::get('forms.charity_description_hint') }}
        </p>
        {{ Form::textarea('charity_description', null, [
            'placeholder' => Lang::get('forms.charity_description')
        ]) }}
    </li>
 
   <li>{{ Form::submit(Lang::get('forms.charity_create_button'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
