<li>
    {{ Form::label('animal_name', Lang::get('postViews.lost_and_found.animal_name'), array('class' => 'req')) }}
    {{ Form::text('animal_name', $post->animal_name) }}
</li>
<li>
    {{ Form::label('contact', Lang::get('postViews.lost_and_found.contact'), array('class' => 'req')) }}
    {{ Form::text('contact', $post->contact) }}
</li>
<li>
    {{ Form::label('last_seen', Lang::get('postViews.lost_and_found.last_seen'), array('class' => 'req')) }}
    {{ Form::textarea('last_seen', $post->last_seen) }}
</li>
<li>
    {{ Form::label('extra_info', Lang::get('postViews.lost_and_found.extra_info')) }}
    {{ Form::textarea('extra_info', $post->extra_info) }}
</li>
<li class="req">
    {{ Form::label('image', Lang::get('postViews.lost_and_found.image')) }}
    @if ($post->image != '')
        {{ HTML::image($post->image, 'Post Image') }}
    @endif
    {{ Form::file('image') }}
</li>
