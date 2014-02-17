<li>
    {{ Form::label('animal_name', Lang::get('postViews.adoption.animal_name'), array('class' => 'req')) }}
    {{ Form::text('animal_name', null) }}
</li>
<li>
    {{ Form::label('animal_description', Lang::get('postViews.adoption.animal_description'), array('class' => 'req')) }}
    {{ Form::textarea('animal_description', null) }}
</li>
<li>
    {{ Form::label('contact', Lang::get('postViews.adoption.contact'), array('class' => 'req')) }}
    {{ Form::text('contact', null) }}
</li>
<li>
    {{ Form::label('image', Lang::get('postViews.adoption.image'), array('class' => 'req')) }}
    {{ Form::file('image') }}
</li>
