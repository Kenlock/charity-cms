<?php
    //$author = new presenters\UserPresenter($post->author);
    $author = $post->author->getPresenter();
?>

<article>

    @if (!Auth::guest() && $post->userCanDelete(Auth::user()))
        <ul class="btn-list delete-post">
        <li>{{ HTML::link("posts/delete/{$post->post_id}", Lang::get('post.delete'), array('class' => 'delete-post btn delete')) }}</li>
        <li>
        {{ HTML::link("posts/edit/{$post->page->charity->charity_id}/{$post->post_id}", Lang::get('post.edit'), array('class' => 'delete-post btn small')) }}
        </li>
        </ul>
    @endif

    <small>{{ HTML::link("c/charity/{$post->page->charity->name}/{$post->page->page_id}", '&larr; Back') }}</small>

    <h2>{{ $post->title }}</h2>
    <small>Posted by: {{ $author->getName() }} on {{ date('d/m/Y', $post->created_at) }}</small>

    <section>
        {{ $post->postView->getDisplayView($post) }}
    </section>

    @include('js.facebook')

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

    @if (!Auth::guest())
        @include('comments.comment_form')
    @else
        <p>{{ Lang::get('comments.login_required') }}</p>
    @endif

</section> <!-- .comments -->
