@section('sidebar')
    @include('users.sidebar')
@overwrite

<h1>{{ $charity->getPresenter()->name }} Dashboard</h1>

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
                            {{ HTML::link("edit/page/$page->page_id", 'edit', array('class' => 'btn')) }}
                        </td>
                        <td>
                            {{ HTML::link("delete/page/$page->page_id", 'delete', array('class' => 'delete btn')) }}
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
    <ul class="btn-list btn-links small rainbow">
        <li>{{ HTML::link("contributors/{$charity->name}", Lang::get('charity.administrators')) }}</li>
        <li>{{ HTML::link("edit/style/{$charity->charity_id}", Lang::get('charity.edit_colors')) }}</li>
        <li>{{ HTML::link("create/social-link/{$charity->charity_id}", Lang::get('charity.social_links')) }}</li>
        <li>{{ HTML::link("edit/charity/$charity->charity_id", Lang::get('charity.edit_charity')) }}</li>
        <li>{{ HTML::link("delete/charity/$charity->charity_id", Lang::get('charity.delete_charity'), array('class' => 'delete')) }}</li>
    </ul>

</section>
