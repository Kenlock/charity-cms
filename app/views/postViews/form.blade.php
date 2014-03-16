@if ($post->post_id < 1)
    {{ Form::open(array(
        'method' => 'GET'
    )) }}
    <ul class="form-fields inline">
        <li>
            {{ Form::label('change_post_view', 'Change Post Layout') }}
            {{ Form::select('change_post_view', PostView::getViewTitles()) }}
        </li>
        <li>
            {{ Form::submit('Change') }}
        </li>
    </ul>
    {{ Form::close() }}
@endif

<h2>
    {{ $post->post_id > 0 ? 'Edit' : 'New' }}
    {{ $page->title }} Post
</h2>

<ul class="form-errors">
    @foreach($errors->all() as $error)
       <li>{{ $error }}</li>
    @endforeach
</ul>

{{ Form::open(array('class'=>'form-signup', 'files' => true)) }}

    <ul class="form-fields">
        <li class="req">
            {{ Form::label('title', Lang::get('postViews.title')) }}
            {{ Form::text('title', $post->title) }}
        </li>
        {{ $view->getFormView($post) }}
        <li>{{ Form::submit(Lang::get("postViews.{$view->view}.send"), array('class'=>'btn')) }}</li>
    </ul>
    {{ Form::hidden('view_id', $view->post_view_id) }}

{{ Form::close() }}
