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
