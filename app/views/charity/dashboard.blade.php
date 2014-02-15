<section>
    <h2>Pages</h2>
    @if (count($pages) > 0)
        <ul>
            @foreach ($pages as $page)
                <li>{{ $page->title }}</li>
            @endforeach
        </ul>
    @else
        No Pages
    @endif

    <ul>
        <li>{{ HTML::link("pages/create/{$charity->charity_id}", 'Create a page') }}</li>
    </ul>
</section>
