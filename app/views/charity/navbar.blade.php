<ul>
    @if (count($pages) > 0)
        @foreach($pages as $page)
            <li>{{ HTML::link("{$url}/$page->page_id", $page->title) }}</li>
        @endforeach
    @endif
</ul>
@include('layout.login-nav')
