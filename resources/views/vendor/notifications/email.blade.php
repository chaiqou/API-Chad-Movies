<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>

<body
    style="height: 100%; width: 100vw; background-image: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%); background-repeat: no-repeat;  background-attachment: fixed; margin: 0; padding: 0; box-sizing: border-box; margin-left: 5vw">

    <div
        style="height: 100%;  text-align:center;  display: flex; flex-direction: column; align-content: flex-start; margin-top: 20px">
        <div style="padding: 0 auto; ">
            <img src="https://i.ibb.co/MR96Jzx/Vector.png" alt="Vector" border="0" style="margin-top: 8px">
            <p style="color: #DDCCAA; text-align: center;">MOVIE QUOTES</p>
            <p
                style="margin-top: 30px;  text-align: left; line-height: 150%;  font-size: 16px; font-weight: 400; color:white;">
                Hi Nikoloz
            </p>
            <p style=" text-align: left; line-height: 150%;  font-size: 16px; font-weight: 400; color:white;">
                Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your
                account:
            </p>
            <div style="position: relative; right: 45vw">
                @isset($actionText)
                    <?php
                    $color = match ($level) { 'success', 'error' => $level,  default => 'primary' };
                    ?>
                    @component('mail::button', ['url' => $actionUrl, 'color' => 'red'])
                        Verify account
                    @endcomponent
                @endisset

            </div>
            <p style=" text-align: left;  line-height: 150%;  font-size: 16px; font-weight: 400; color:white;">
                If clicking doesn't work, you can try copying and pasting it to your browser: </p>
            <a style='position: relative; right: 20.5vw; color: #DDCCAA; text-align: left;  white-space: normal;'
                href="{{ $actionUrl }}">{{ $actionUrl }}</a>
            <p
                style=" text-align: left; margin-top: 20px; line-height: 150%;  font-size: 16px; font-weight: 400; color:white;">
                If you have any problems, please contact us: support@moviequotes.ge </p>
            <p style=" text-align: left; line-height: 150%;  font-size: 16px; font-weight: 400; color:white;">
                MovieQuotes Crew</p>

        </div>
    </div>

</body>


</html>
