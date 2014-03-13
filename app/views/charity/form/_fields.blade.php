<li>
    {{ Form::label('name', Lang::get('forms.charity_name'), array('class' => 'req')) }}
    <p>
        {{ Lang::get('forms.charity_name_hint') }}
    </p>
    {{ Form::text('name', null, [
        'placeholder'=> Lang::get('forms.charity_name')
    ]) }}
</li>
<li>
    {{ Form::label('address1', Lang::get('forms.charity_address'), array('class' => 'req')) }}
    <p>
        {{ Lang::get('forms.charity_address_hint') }}
    </p>
    <div class="address">
        {{ Form::text('address', Input::get('address'), [
            'placeholder'=> Lang::get('forms.charity_address1')
        ]) }}
        {{ Form::text('address1', Input::get('address1'), [
            'placeholder'=> Lang::get('forms.charity_address2')
        ]) }}
        {{ Form::text('address2', Input::get('address2'), [
            'placeholder'=> Lang::get('forms.charity_address3')
        ]) }}
    </div>
</li>

<li class="req">
    {{ Form::label('email', Lang::get('forms.charity_email')) }}
    <p>
        {{ Lang::get('forms.charity_email_hint') }}
    </p>
    {{ Form::text('email', null, array(
        'placeholder' => Lang::get('forms.charity_email')
    )) }}
</li>

<li class="req">
    {{ Form::label('charity_no', Lang::get('forms.charity_no')) }}
    <p>{{ Lang::get('forms.charity_no_hint') }}</p>
    {{ Form::text('charity_no', null, array(
        'placeholder' => Lang::get('forms.charity_no')
    )) }}
</li>

<li>
    {{ Form::label('description', Lang::get('forms.charity_description'), array('class' => 'req')) }}
    <p>
        {{ Lang::get('forms.charity_description_hint') }}
    </p>
    {{ Form::textarea('description', null, [
        'placeholder' => Lang::get('forms.charity_description')
    ]) }}
</li>
<li>
    {{ Form::label('charity_category_id', Lang::get('forms.charity_category'), array('class' => 'req')) }}
    <p>
        {{ Lang::get('forms.charity_category_hint') }}
    </p>
    {{ Form::select('charity_category_id', CharityCategory::getTitles()) }}
</li>
<li>
    {{ Form::label('image', Lang::get('forms.charity_image')) }}
    @if (isset($charity))
        {{ HTML::image($charity->image, 'Charity Logo') }}
    @endif
    <p>{{ Lang::get('forms.charity_image_hint') }}</p>
    {{ Form::file('image') }}
</li>
