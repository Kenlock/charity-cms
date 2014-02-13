<ul>
    @foreach($charities as $charity)

        <li>{{ $charity->name }} ({{ $charity->category->title }})
            <ul>
                <li>{{ HTML::link("c/view/{$charity->name}", $charity->name) }}</li>
            </ul>
        </li>

    @endforeach
</ul>
