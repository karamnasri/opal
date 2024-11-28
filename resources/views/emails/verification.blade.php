<!DOCTYPE html>
<html>

<head>
    <title>Email Verification</title>
</head>

<body>
    <p>Hello {{ $name }},</p>
    <p>Thank you for signing up! Please verify your email address using the verification code below:</p>
    <h3>{{ $verification_code }}</h3>
    <p>If you did not create an account, you can safely ignore this email.</p>
    <p>Regards,<br>Team</p>
</body>

</html>
