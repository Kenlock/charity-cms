<article>

    @if ($post->userCanDelete(Auth::user()))
        {{ HTML::link("posts/delete/{$post->post_id}", Lang::get('post.delete'), array('class' => 'delete-post btn')) }}
    @endif

    <small>{{ HTML::link("c/charity/{$post->page->charity->name}/{$post->page->page_id}", '&larr; Back') }}</small>

    <h2>{{ $post->title }}</h2>
    <small>Posted by: {{ $post->author->getName() }} on {{ date('d/m/Y', $post->created_at) }}</small>

    <section>
        {{ $post->postView->getDisplayView($post) }}
    </section>

</article>

<h2>Comments</h2>
<section class="comments">

    @if (count($post->comments) > 0)
        @foreach ($post->comments as $comment)
            {{ $comment }}
        @endforeach
    @else
        <p>No Comments</p>
    @endif

    @if (Auth::check())
        @include('comments.comment_form')
    @else
        <p>{{ Lang::get('comments.login_required') }}</p>
    @endif

</section> <!-- .comments -->
