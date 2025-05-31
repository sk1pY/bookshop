@if (session('status') === 'verification-link-sent')
    <div class="alert alert-success text-center my-3">
        Письмо с подтверждением было успешно отправлено.
    </div>
@endif


@if ($errors->updateProfileInformation->any())
    <ul>
        @foreach ($errors->updateProfileInformation->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if ($errors->updatePassword->any())
    <ul>
        @foreach ($errors->updatePassword->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
