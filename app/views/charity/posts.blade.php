<h2>Posts</h2>
@if (isset($posts) and count($posts) > 0)

    @foreach ($posts as $post)
        
        <section>
            <h2>{{ $post->title }}</h2>
            {{ View::make("postViews.{$post->postView->view}.display", array('post' => $post)) }}
        </section>

    @endforeach

@endif
