<ul class="login-menu">
    @include('layout.login-nav')
</ul>

<ul>
    @if (count($pages) > 0)
        @foreach ($pages as $page)
            <li>{{ HTML::link("c/charity/{$charity->name}/{$page->page_id}", $page->title) }}</li>
        @endforeach
        <li>{{ HTML::link("c/about/{$charity->name}", "About") }}</li>
    @endif
</ul>
