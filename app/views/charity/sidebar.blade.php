<div class="hearts">
    {{ HTML::image('css/images/heart.jpg', 'Heart Image') }}
    103
</div>

<section class="sidebar-content">

    <figure>
        @if (isset($charity->image))
            {{ HTML::image($charity->image, 'Charity Logo') }}
        @else
            {{ HTML::image('', 'Default Image') }}
        @endif
    </figure>
    <h2>{{ $charity->name }}</h2>

    @if (isset($page) and !Auth::guest() and Auth::user()->canPostTo($page))
        {{ HTML::link("posts/create/{$page->page_id}", 'New Post', array('class' => 'btn')) }}
    @endif

</section> <!-- .sidebar-content -->
