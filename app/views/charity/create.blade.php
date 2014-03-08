{{ Form::open(array('url'=>'c/create', 'class'=>'form-create-charity', 'files' => true)) }}
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

    @include('charity.form._fields')
 
   <li>{{ Form::submit(Lang::get('forms.charity_create_button'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
