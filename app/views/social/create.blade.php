{{ HTML::linkAction('CharityController@getDashboard', '&larr; Back to Dashboard', array($charity->name)) }}

<h2>Social Links</h2>

<p>
    Copy/Paste your social network links here
</p>

@include('_errors')

{{ Form::open() }}

<ul class="form-fields">
    
    @foreach($currentLinks as $service => $link)
        <li>
            {{ Form::label($service, ucfirst($service)) }}
            {{ Form::text($service, Input::has($service) ? Input::get($service) : $link ) }}
        </li>
    @endforeach

    <li>
        {{ Form::submit('Save', array('class' => 'btn')) }}
    </li>

</ul>

{{ Form::close() }}
