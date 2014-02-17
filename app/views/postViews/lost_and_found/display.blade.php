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

</article>
