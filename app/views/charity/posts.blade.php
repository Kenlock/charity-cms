@if (isset($posts) and count($posts) > 0)

    @foreach ($posts as $post)
        
        <section>
            <h2>{{ HTML::link("posts/single/{$charity->name}/{$post->post_id}", $post->title) }}</h2>
            {{ $post->postView->getDisplayView($post); }}
        </section>

    @endforeach

    {{ $posts->links() }}

@else

    <section>
        No Posts
    </section>

@endif
