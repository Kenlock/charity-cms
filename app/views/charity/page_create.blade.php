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
    <li>
        {{ Form::label('title', Lang::get('forms.page_title'), array('class' => 'req')) }}
        {{ Form::text('title', null) }}
    </li>
    <li>
        {{ Form::label('default_view_id', Lang::get('forms.page_type'), array('class' => 'req')) }}
        {{ Form::select('default_view_id', PostView::getViewTitles()) }}
    </li>
    <li>
            {{ Form::label('open_to_all', Lang::get('forms.page_open_to_all'), array('class' => 'req')) }}
            {{ Form::checkbox('open_to_all', 1, false) }}
    </li>
 
   <li>{{ Form::submit(Lang::get('forms.page_create'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
