<li>
    {{ Form::label('content', Lang::get('postViews.announcement.content'), array('class' => 'req')) }}
    {{ Form::textarea('content', $post->content) }}
</li>
