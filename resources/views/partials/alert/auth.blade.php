@if (session('status'))
    @if(session('status') === 'verification-link-sent')
        <div class="alert alert-success text-center ">
            Письмо с подтверждением было успешно отправлено.
        </div>
    @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endif



@if ($errors->updateProfileInformation->any())
    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->updateProfileInformation->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </ul>
    </div>
@endif

@if ($errors->updatePassword->any())
    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->updatePassword->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>

@endif


