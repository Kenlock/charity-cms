@if(Session::has('message'))
    {{ Session::get('message') }}
@endif

@if (Session::has('message_success'))
    <div class="msg suc">{{ Session::get('message_success') }}</div>
@endif

@if (Session::has('message_error'))
    <div class="msg err">{{ Session::get('message_err') }}</div>
@endif

@if (Session::has('message_alert'))
    <div class="msg alrt">{{ Session::get('message_alrt') }}</div>
@endif
