{{ Form::open(array('action' => 'CharityController@getSearch', 'method' => 'GET')) }}

<ul class="form-fields">
    <li>
        {{ Form::text('search') }}
    </li>
    <li>
        {{ Form::submit('Search', array('class' => 'btn inline-field')) }}
    </li>
</ul>

{{ Form::close() }}

@if (count($charities) > 0)
    <ul>
        @foreach($charities as $charity)

            <li>{{ $charity->name }} ({{ $charity->category->title }})
                <ul>
                    <li>{{ HTML::link("c/charity/{$charity->name}", $charity->name) }}</li>
                </ul>
            </li>

        @endforeach
    </ul>
@else
    <p>No Charities</p>
@endif
