<h2>Charity Search</h2>

{{ Form::open(array('method' => 'GET')) }}

<ul class="form-fields">
    <li>
        {{ Form::label('search', 'Search') }}
        {{ Form::text('search', Input::get('search')) }}
    </li>

    <li>
        {{ Form::submit('Search', array('class' => 'btn')) }}
    </li>
</ul>

{{ Form::close() }}

@if (count($charities) > 0)
    <h2>Results</h2>
    <p>
        Searching for "{{ $search }}"
    </p>
    <ul>
        @foreach ($charities as $charity)
            <li>
                {{ $charity->getPresenter()->viewLink()}}
            </li>
        @endforeach
    </ul>
@elseif ($search != "")

    <p>
        No results for "{{ $search }}"
    </p>
@endif
