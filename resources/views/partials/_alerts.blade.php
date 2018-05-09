@if ($errors->count())
    <div class="alert alert-danger fade in" role="alert">
        <ul class="list-unstyled">
            @foreach ($errors->messages() as $error)
                <li>{{ $error[0] }}</li>
            @endforeach
        </ul>
    </div>
@endif