<li>
    {{ Form::label('animal_name', Lang::get('postViews.lost_and_found.animal_name'), array('class' => 'req')) }}
    {{ Form::text('animal_name', null) }}
</li>
<li>
    {{ Form::label('contact', Lang::get('postViews.lost_and_found.contact'), array('class' => 'req')) }}
    {{ Form::text('contact', null) }}
</li>
