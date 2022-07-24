@component('mail::message')
    # Introduction

    Reset your password.

    @component('mail::button', ['url' => 'http://localhost:3000/reset-password?token=' . $email . '&email=' . $token])
        Password Reset
    @endcomponent

    Thanks,<br>
    Chad Movies Team.
@endcomponent
