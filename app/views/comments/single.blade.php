<?php $my_comment = Auth::user() == $comment->user; ?>
<?php $user = $comment->user->getPresenter(); ?>

<div class="comment">
    @if ($my_comment)
        <small class="meta">
            {{ HTML::link("delete/comment/{$comment->comment_id}", Lang::get('comments.delete')) }}
        </small>
    @endif
    <figure>
        {{ HTML::image($user->image, 'User Profile Image') }}
    </figure>
    <article {{ $my_comment ? 'class="my-comment"' : '' }}>
        <h3>{{ $user->getName() }}: <time>{{ $comment->getAgeString() }}</time></h3>
        {{ $comment->comment }}
    </article>
</div>
