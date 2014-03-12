<h2>Contact Us</h2>

@include('_errors')

{{ Form::open() }}

<ul class="form-fields">

    <li>
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name') }}
    </li>

    <li class="req">
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email') }}
    </li>

    <li class="req">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea('content') }}
    </li>

    <li class="req">
        {{ Form::submit('Send', array('class' => 'btn')) }}
    </li>

</ul>

{{ Form::close() }}
