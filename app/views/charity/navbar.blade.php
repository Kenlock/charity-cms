<ul class="login-menu">
    @include('layout.login-nav')
</ul>

<ul>
    @if (count($pages) > 0)
        @foreach ($pages as $p)
            <?php $class = $page->page_id == $p->page_id ? array('class' => 'current') : array(); ?>
            <li>{{ HTML::link("c/charity/{$charity->name}/{$p->page_id}", $p->title, $class) }}</li>
        @endforeach
        <li>{{ HTML::link("c/about/{$charity->name}", "About") }}</li>
    @endif
</ul>
