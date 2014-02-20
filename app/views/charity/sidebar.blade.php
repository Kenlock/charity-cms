@if (isset($charity->image))
    {{ HTML::image($charity->image, 'Charity Logo') }}
@endif

<h2>{{ $charity->name }}</h2>

@if (isset($page) and !Auth::guest() and Auth::user()->canPostTo($page))
    {{ HTML::link("posts/create/{$page->page_id}", 'New Post', array('class' => 'btn')) }}
@endif
