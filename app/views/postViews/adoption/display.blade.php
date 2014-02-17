<article>
    <figure>
        {{ HTML::image($post->getSmallProperty('image')) }}
    </figure>
    <p>
        Name: "{{ $post->getSmallProperty('animal_name') }}"
    </p>
    <p>
        Contact:<br />
        {{ $post->getSmallProperty('contact') }}
    </p>
    <p>
        Description: <br />
        {{ $post->getLargeProperty('animal_description') }}
    </p>

</article>
