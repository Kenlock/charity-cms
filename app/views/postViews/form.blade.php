<h2>New {{ $page->title }} Post</h2>

<ul class="form-errors">
    @foreach($errors->all() as $error)
       <li>{{ $error }}</li>
    @endforeach
</ul>

{{ Form::open(array('url'=>"posts/create/{$page->page_id}", 'class'=>'form-signup', 'files' => true)) }}

    <ul class="form-fields">
        <li>
            {{ Form::label('title', Lang::get('postViews.title'), array('class' => 'req')) }}
            {{ Form::text('title', null) }}
        </li>
        {{ $view->getFormView() }}
        <li>{{ Form::submit(Lang::get("postViews.{$view->view}.send"), array('class'=>'btn')) }}</li>
    </ul>
    {{ Form::hidden('view_id', $view->post_view_id) }}

{{ Form::close() }}
