@section('nav-bar')
    <ul>
        <li>{{ HTML::link('#', 'Home') }}</li>
        @if (count($pages) > 0)
            <?php $url = "c/view/$charity->name"; ?>
            @foreach($pages as $page)
                <li>{{ HTML::link("{$url}/$page->page_id", $page->title) }}</li>
            @endforeach
        @endif
    </ul>
    @include('layout.login-nav')
@overwrite

<section class="content-block">
    <h2>{{ $title }}</h2>
    {{ isset($content) ? $content : Lang::get("strings.nothing_here") }}
</section>
