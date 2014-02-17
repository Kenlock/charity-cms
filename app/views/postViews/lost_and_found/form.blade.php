<li>
    {{ Form::label('animal_name', Lang::get('postViews.lost_and_found.animal_name'), array('class' => 'req')) }}
    {{ Form::text('animal_name', null) }}
</li>
<li>
    {{ Form::label('contact', Lang::get('postViews.lost_and_found.contact'), array('class' => 'req')) }}
    {{ Form::text('contact', null) }}
</li>
<li>
    {{ Form::label('last_seen', Lang::get('postViews.lost_and_found.last_seen'), array('class' => 'req')) }}
    {{ Form::textarea('last_seen', null) }}
</li>
<li>
    {{ Form::label('extra_info', Lang::get('postViews.lost_and_found.extra_info')) }}
    {{ Form::textarea('extra_info', null) }}
</li>
<li>
    {{ Form::label('image', Lang::get('postViews.lost_and_found.image')) }}
    {{ Form::file('image') }}
</li>
