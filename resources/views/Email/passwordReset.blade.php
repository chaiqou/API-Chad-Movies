@component('mail::message')
    # Introduction

    Reset your password.

    @component('mail::button',
        ['url' => config('app.frontend_url') . 'reset-password?token=' . $email . '&email=' . $token])
        Password Reset
    @endcomponent

    Thanks,<br>
    Chad Movies Team.
@endcomponent
