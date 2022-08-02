@component('mail::message')
    # Introduction

    Reset your password.

    @component('mail::button',
        ['url' => 'https://chad-movies.nikoloz.redberryinternship.ge/reset-password?token=' . $email . '&email=' . $token])
        Password Reset
    @endcomponent

    Thanks,<br>
    Chad Movies Team.
@endcomponent
