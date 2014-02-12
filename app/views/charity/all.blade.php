<ul>
    @foreach($charities as $charity)

        <li>{{ $charity->name }} ({{ $charity->category->title }})</li>

    @endforeach
</ul>
