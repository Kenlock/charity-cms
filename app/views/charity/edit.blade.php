{{ HTML::link("c/dashboard/{$charity->name}", "&larr; Back to Dashboard") }}

<h1>Edit Charity</h1>

@include('_errors')

{{ Form::model($charity, array('files' => true)) }}

<ul class="form-fields">

    @include('charity.form._fields')

    <li>
        {{ Form::submit(Lang::get('buttons.update'), array('class' => 'btn')) }}
    </li>

</ul>

{{ Form::close() }}
