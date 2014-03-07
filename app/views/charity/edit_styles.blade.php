<h2>Charity Colours</h2>

{{ Form::open() }}

<ul class="form-fields">
    <li>
        {{ Form::label('background-color', 'Background Colour') }}
        {{ Form::text('background-color', $charity->getStyles()->getProperty('background-color'), array('class' => 'color')) }}
    </li>
    <li>
        {{ Form::submit(Lang::get('buttons.update')) }}
    </li>
</ul>

{{ Form::close() }}
