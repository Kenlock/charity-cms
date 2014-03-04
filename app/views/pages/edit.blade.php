{{ HTML::link("c/dashboard/{$model->charity->name}", '&larr; ' . Lang::get('dashboard.back')) }}

<h1>Edit Page</h1>

<ul class="form-errors">
  @foreach($errors->all() as $error)
     <li>{{ $error }}</li>
  @endforeach
</ul>

{{ Form::model($model, array('url'=>"edit/page/{$model->page_id}")) }}

<ul class="form-fields">

    @include('pages/_form')

   <li>{{ Form::submit(Lang::get('forms.page_edit'), array('class'=>'btn')) }}</li>
</ul>
