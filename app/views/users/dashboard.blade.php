<?php $myCharities = Auth::user()->getCharities(); ?>

@section('sidebar')
    @include('users.sidebar')
@overwrite

<div class="user-tag right">
    <span>{{ Auth::user()->getPresenter()->getName() }}</span>
    {{ HTML::image(Auth::user()->getPresenter()->image, 'User Profile') }}
</div>

<h1>Dashboard</h1>
 
<section>

    @if (count($myCharities) > 0)
        <h2>My Charities</h2>
        <table>
            @foreach($myCharities as $charity)
                <tr>
                    <td>{{ HTML::link("c/charity/{$charity->name}", $charity->name) }}</td>
                    <td>{{ HTML::link("c/dashboard/{$charity->name}", 'Dashboard', array('class' => 'btn')) }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <h2>Recent Comments</h2>
    <ul class="comments">
        @if (count($my_recent_comments) > 0)
            @foreach($my_recent_comments as $comment)
                <li>
                    <h3>Posted on:
                        {{ HTML::link("posts/single/{$comment->post->page->charity->name}/{$comment->post->post_id}", $comment->post->title) }}
                    </h3>
                    @include('comments.single')
                </li>
            @endforeach
        @else
            <li>You have not made any comments</li>
        @endif
    </ul>

    <h2>Other Actions</h2>
    {{ HTML::link('c/create', 'Create a charity', array('class' => 'btn')) }}
    {{ HTML::link('c/', 'View all charities', array('class' => 'secondary-btn')) }}

</section>
