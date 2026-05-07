<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - EduPlay</title>
</head>
<body>
    <h1>Confirm your password</h1>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autofocus>
            @error('password')<div>{{ $message }}</div>@enderror
        </div>

        <button type="submit">Confirm</button>
    </form>
</body>
</html>
