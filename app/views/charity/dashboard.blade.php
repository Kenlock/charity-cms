<section>
    {{ HTML::link('users/dashboard', '&larr; ' . Lang::get('dashboard.back')) }}

    <h2>Pages</h2>
    @if (count($pages) > 0)
        <ul>
            @foreach ($pages as $page)
                <li>{{ HTML::link("c/charity/{$charity->name}/$page->page_id", $page->title) }}</li>
            @endforeach
        </ul>
    @else
        No Pages
    @endif

    <ul>
        <li>{{ HTML::link("pages/create/{$charity->charity_id}", 'Create a page') }}</li>
    </ul>
</section>
