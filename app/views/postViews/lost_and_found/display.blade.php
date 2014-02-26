<article>
    <figure>
        {{ HTML::image($post->getSmallProperty('image')) }}
    </figure>
    <p>
        Answers to: "{{ $post->getSmallProperty('animal_name') }}"
    </p>
    <p>
        Contact: {{ $post->getSmallProperty('contact') }}
    </p>
    <p>
        Last Seen: <br />
        {{ $post->getLargeProperty('last_seen') }}
    </p>
    <p>
        Extra Information: <br />
        @if (trim($post->getLargeProperty('extra_info')) != '')
            {{ $post->getLargeProperty('extra_info') }}
        @else
            {{ Lang::get('postViews.lost_and_found.no_extra_info') }}
        @endif
    </p>

</article>
