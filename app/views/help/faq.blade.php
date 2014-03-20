@section('sidebar')

    <h2>Frequently Asked Questions</h2>
    {{ $faq->getMenu() }}
@overwrite

<h2>User Manual</h2>
<p>
    Need more help? Download our {{ HTML::link('manual.chm', 'User Manual') }}
</p>

{{ $faq->getContent() }}
