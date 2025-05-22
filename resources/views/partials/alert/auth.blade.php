@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

@if (session('status') === 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600">
        A new email verification link has been emailed to you!
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
