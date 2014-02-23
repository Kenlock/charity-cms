<article>

    <small>{{ HTML::link("c/charity/{$post->page->charity->name}/{$post->page->page_id}", '&larr; Back') }}</small>

    <h2>{{ $post->title }}</h2>
    <small>Posted by: {{ $post->author->getName() }} on {{ $post->created_at }}</small>

    <section>
        {{ $post->postView->getDisplayView($post) }}
    </section>

    <h2>Comments</h2>
    @if (count($post->comments) > 0)
        @foreach ($post->comments as $comment)
            {{ $comment }}
        @endforeach
    @else
        No Comments
    @endif
    @include('comments.comment_form')

</article>
