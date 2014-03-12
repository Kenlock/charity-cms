<?php $my_comment = !Auth::guest() && Auth::user()->user_id == $comment->user->user_id; ?>
<?php $user = $comment->user->getPresenter(); ?>

<div class="comment">
    <figure>
        {{ HTML::image($user->image, 'User Profile Image') }}
    </figure>
    <article {{ $my_comment ? 'class="my-comment"' : '' }}>
        <h3>{{ $user->getName() }}: <time>{{ $comment->getAgeString() }}</time></h3>
        @if ($my_comment)
            <small class="meta">
                {{ HTML::link("delete/comment/{$comment->comment_id}", Lang::get('comments.delete'), array('class' => 'delete')) }}
            </small>
        @endif
        {{ $comment->comment }}
    </article>
</div>
