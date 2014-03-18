<?php

$type = isset($type) ? $type : 'Contributors';

?>

<h1>{{ $charity->name }}</h1>

<h2>Current {{ $type }}</h2>
<table>
    @foreach ($contributors as $user)
        <tr>
            <td>{{ $user->getPresenter()->getName() }}</td>
            <td>{{ HTML::link("delete/contributor/{$charity->charity_id}/{$user->user_id}", "remove", array('class' => 'btn delete')) }}</td>
        </tr>
    @endforeach
</table>

<h2>Add {{ $type }}</h2>
<p>
    {{ Lang::get('contributors.search_hint') }}
</p>


{{ Form::open() }}
<ul class="form-fields">
    <li>
        {{ Form::label('user_name', 'Username', array('class' => 'inline-field')) }}
        {{ Form::text('user_name', $query) }}
        {{ Form::submit('Search', array('class' => 'inline-field btn')) }}
    </li>
</ul>
{{ Form::close() }}

@if (count($search_results) > 0)

<h2>Search Results:</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        @foreach ($search_results as $user)
            <tr>
                <td data-label="Name">{{ $user->getPresenter()->getName() }}</td>
                <td data-label="Actions">{{ HTML::link("create/contributor/{$charity->charity_id}/{$user->user_id}", 'Add Admin') }}</td>
            </tr>
        @endforeach
    </table>
    {{ $search_results->links() }}

@else
    
    <p>No Users found</p>

@endif
