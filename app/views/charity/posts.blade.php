
@if (isset($posts) and count($posts) > 0)

    @foreach ($posts as $post)
        <?php $post->loadProperties() ?>
        
        <section>
            <h2>{{ HTML::link("posts/single/{$charity->name}/{$post->post_id}", $post->title) }} <time>{{ date('d M \'y', $post->created_at) }}</time></h2>
            {{ $post->postView->getDisplayView($post); }}
        </section>

    @endforeach

    {{ $posts->links() }}

@else

    <section>
        No Posts
    </section>

@endif
