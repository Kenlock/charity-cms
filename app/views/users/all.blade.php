<h2>All Users:</h2>
<ul>
    @foreach($users as $user)
        <li>
            {{ isset($user->image) ? HTML::image($user->image) : '' }}
            {{ $user->firstname . " " . $user->lastname }}
        </li>
    @endforeach
</ul>

<ul>
    @foreach($oauth as $o)
        <li>
            {{ $o->uid }} :: {{ $o->user_id }} ({{ $o->provider }})
        </li>
    @endforeach
</ul>
