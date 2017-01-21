@foreach ($errors->all() as $error)
<div class="notification is-danger">
    <button class="delete"></button>
    {{ $error }}
</div>
@endforeach

@if (session('status'))
<div class="notification is-info">
    <button class="delete"></button>
    {{ session('status') }}
</div>
@endif
