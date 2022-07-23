@component('mail::message')
    # Introduction

    Reset your password.

    @component('mail::button', ['url' => 'http://localhost:3000/forgot-password?token=' . $email])
        Password Reset
    @endcomponent

    Thanks,<br>
    Chad Movies Team.
@endcomponent
