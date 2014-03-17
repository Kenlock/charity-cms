<h1>Charities</h1>

{{ Form::open(array('action' => 'CharityController@getSearch', 'method' => 'GET')) }}

<ul class="form-fields inline">
    <li>
        {{ Form::text('search') }}
    </li>
    <li>
        {{ Form::submit('Search', array('class' => 'btn')) }}
    </li>
</ul>

{{ Form::close() }}

@if (count($charities) > 0)
    @include('charity._badges')
@else
    <p>No Charities</p>
@endif
