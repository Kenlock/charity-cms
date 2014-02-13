{{ Form::open(array('url'=>'c/create', 'class'=>'form-create-charity')) }}
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
        {{ Form::label('name', Lang::get('forms.charity_name'), array('class' => 'req')) }}
        <p>
            {{ Lang::get('forms.charity_name_hint') }}
        </p>
        {{ Form::text('name', null, [
            'placeholder'=> Lang::get('forms.charity_name')
        ]) }}
    </li>
    <li>
        {{ Form::label('address1', Lang::get('forms.charity_address'), array('class' => 'req')) }}
        <p>
            {{ Lang::get('forms.charity_address_hint') }}
        </p>
        <div class="address">
            {{ Form::text('address', null, [
                'placeholder'=> Lang::get('forms.charity_address1')
            ]) }}
            {{ Form::text('address1', null, [
                'placeholder'=> Lang::get('forms.charity_address2')
            ]) }}
            {{ Form::text('address2', null, [
                'placeholder'=> Lang::get('forms.charity_address3')
            ]) }}
        </div>
    </li>
    <li>
        {{ Form::label('description', Lang::get('forms.charity_description'), array('class' => 'req')) }}
        <p>
            {{ Lang::get('forms.charity_description_hint') }}
        </p>
        {{ Form::textarea('description', null, [
            'placeholder' => Lang::get('forms.charity_description')
        ]) }}
    </li>
    <li>
        {{ Form::label('charity_category_id', Lang::get('forms.charity_category'), array('class' => 'req')) }}
        <p>
            {{ Lang::get('forms.charity_category_hint') }}
        </p>
        {{ Form::select('charity_category_id', CharityCategory::getTitles()) }}
    </li>
 
   <li>{{ Form::submit(Lang::get('forms.charity_create_button'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
