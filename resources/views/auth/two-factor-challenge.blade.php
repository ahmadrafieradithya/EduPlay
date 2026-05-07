<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Factor Authentication - EduPlay</title>
</head>
<body>
    <h1>Two Factor Authentication</h1>

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div>
            <label for="code">Authentication Code</label>
            <input id="code" type="text" name="code" autocomplete="one-time-code" required autofocus>
            @error('code')<div>{{ $message }}</div>@enderror
        </div>

        <button type="submit">Login</button>
    </form>
</body>
</html>
