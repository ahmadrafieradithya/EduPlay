<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - EduPlay</title>
</head>
<body>
    <h1>Please verify your email address</h1>

    @if (session('status') == 'verification-link-sent')
        <div>A new verification link has been sent to your email address.</div>
    @endif

    <p>Before proceeding, please check your email for a verification link.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Resend verification email</button>
    </form>
</body>
</html>
