<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <p>Hello user {{ $email }}</p>
    <p>This is your forgot password email. Please click 
       <a class="text-bold" href="{{ url('/resetPassword?hashedToken=' . $hashedToken . '&email=' . $email) }}">here</a> to reset your password.
    </p>
</body>
</html>
