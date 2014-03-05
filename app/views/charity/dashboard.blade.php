@section('sidebar')
    @include('users.sidebar')
@overwrite

<section>
    {{ HTML::link('users/dashboard', '&larr; ' . Lang::get('dashboard.back')) }}

    <h2>Pages</h2>
    @if (count($charity->pages) > 0)
        <table>
            <tr>
                <th>Page Title</th>
                <th>Posts</th>
                <th colspan="2">Actions</th>
            </tr>
            @foreach ($charity->pages as $page)
                <tr>
                    <td data-label="Page Title">
                    {{ HTML::link("c/charity/{$charity->name}/$page->page_id", $page->title) }}
                    </td>
                    <td data-label="Posts">
                        {{ $page->posts()->count() }}
                    </td>
                    @if (Auth::user()->canDelete($page))
                        <td data-label="Actions">
                            {{ HTML::link("edit/page/$page->page_id", 'edit') }}
                        </td>
                        <td>
                            {{ HTML::link("delete/page/$page->page_id", 'delete', array('class' => 'delete')) }}
                        </td>
                    @else
                        <td colspan="2">N/A</td>
                    @endif
                </tr>
            @endforeach
        </table>
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
