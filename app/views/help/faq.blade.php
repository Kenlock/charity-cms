@section('sidebar')

    <h2>Frequently Asked Questions</h2>
    {{ $faq->getMenu() }}
@overwrite

{{ $faq->getContent() }}
