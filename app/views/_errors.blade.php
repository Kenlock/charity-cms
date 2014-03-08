<ul class="form-errors">
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
