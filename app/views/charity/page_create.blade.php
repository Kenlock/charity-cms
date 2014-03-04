{{ Form::open(array('url'=>"pages/create/{$charity->charity_id}", 'class'=>'form-signup')) }}
    <h2>Create a Page</h2>
    <p>
        {{ Lang::get('forms.page_form_description') }}
    </p>
 
   <ul class="form-errors">
      @foreach($errors->all() as $error)
         <li>{{ $error }}</li>
      @endforeach
   </ul>

<ul class="form-fields">
    @include('pages/_form')
 
   <li>{{ Form::submit(Lang::get('forms.page_create'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
