<h2>All Users:</h2>
<ul>
    @foreach($users as $user)
        <li>
            <?php $user = $user->getPresenter(); ?>
            {{ HTML::image($user->image) }}
            {{ $user->getName() }}
            <p>{{ $user->description }}</p>
        </li>
    @endforeach
</ul>
