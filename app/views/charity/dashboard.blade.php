@section('sidebar')
    @include('users.sidebar')
@overwrite

<section>
    {{ HTML::link('users/dashboard', '&larr; ' . Lang::get('dashboard.back')) }}

    <h2>Pages</h2>
    @if (count($charity->pages) > 0)
        <ul>
            @foreach ($charity->pages as $page)
                <li>{{ HTML::link("c/charity/{$charity->name}/$page->page_id", $page->title) }}</li>
            @endforeach
        </ul>
    @else
        No Pages
    @endif

    <ul>
        <li>{{ HTML::link("pages/create/{$charity->charity_id}", 'Create a page') }}</li>
    </ul>

    <h2>Settings</h2>
    <ul>
        <li>{{ HTML::link("delete/charity/$charity->charity_id", Lang::get('charity.delete_charity')) }}</li>
    </ul>

</section>
