<div>
    <figure>
        {{ HTML::image($comment->user->image, 'User Profile Image') }}
    </figure>
    <article>
        <h3>{{ $comment->user->getName() }}: <time>{{ $comment->getAgeString() }}</time></h3>
        {{ $comment->comment }}
    </article>
</div>
