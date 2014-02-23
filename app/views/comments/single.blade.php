<h3>{{ $comment->user->getName() }} said on {{ date('d M Y h:i:s', $comment->getCreatedAt()) }}:</h3>

<p>
    {{ $comment->comment }}
</p>
