<ul>
    @foreach($charities as $charity)

        <li>{{ $charity->name }} ({{ $charity->category->title }})
            <ul>
                <li>{{ HTML::link("c/charity/{$charity->name}", $charity->name) }}</li>
            </ul>
        </li>

    @endforeach
</ul>
