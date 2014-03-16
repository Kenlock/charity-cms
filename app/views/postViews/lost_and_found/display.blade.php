<article>
    <figure>
        {{ HTML::image($post->image) }}
    </figure>
    <p>
        Answers to: "{{ $post->animal_name }}"
    </p>
    <p>
        Contact: {{ $post->contact }}
    </p>
    <p>
        Last Seen: <br />
        {{ $post->markdown('last_seen') }}
    </p>
    <p>
        Extra Information: <br />
        @if (trim($post->extra_info) != '')
            {{ $post->markdown('extra_info') }}
        @else
            {{ Lang::get('postViews.lost_and_found.no_extra_info') }}
        @endif
    </p>

</article>
