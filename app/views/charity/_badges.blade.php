<ul class="charity-badge-list"
    @foreach($charities as $charity)

        ><li class="badge">
            <a href="{{ URL::to("c/about/{$charity->name}") }}">
                <figure>
                    {{ HTML::image("{$charity->getPresenter()->image}", "{$charity->name} Logo") }}
                </figure>
                <h3>{{ $charity->name }}</h3>
            </a>
        </li

    @endforeach
></ul>
