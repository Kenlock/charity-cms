<ul class="login-menu">
    @include('layout.login-nav')
</ul>

<ul>
    @if (count($pages) > 0)
        @foreach ($pages as $p)
            <?php
                $class = array();
                if (isset($page)) {
                    $class = $page->page_id == $p->page_id ? array('class' => 'current') : array();
                }
            ?>
            <li>{{ HTML::link("c/charity/{$charity->name}/{$p->page_id}", $p->title, $class) }}</li>
        @endforeach
        <?php $class = array(); if (!isset($page)) $class = array('class' => 'current'); ?>
        <li>{{ HTML::link("c/about/{$charity->name}", "About", $class) }}</li>
    @endif
</ul>
