<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - EduPlay</title>
</head>
<body>
    <h1>Forgot Password</h1>

    @if(session('status'))
        <div>{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<div>{{ $message }}</div>@enderror
        </div>

        <button type="submit">Send reset link</button>
    </form>

    <p><a href="{{ route('login') }}">Back to login</a></p>
</body>
</html>
