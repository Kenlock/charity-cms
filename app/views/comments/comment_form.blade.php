{{ Form::open(array('url'=>"comments/create/{$post->post_id}")) }}
    <h2>Add Comment</h2>
    <ul class="form-errors">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

<ul class="form-fields">
    <li>
        {{ Form::label('comment', Lang::get('forms.comment'), array('class' => 'req')) }}
        {{ Form::textarea('comment', null) }}
    </li>
    <li>{{ Form::submit(Lang::get('forms.comment_submit'), array('class'=>'btn')) }}</li>
</ul>
{{ Form::close() }}
