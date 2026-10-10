<!DOCTYPE html>
<html>
<head>
    <title>Test OTP</title>
</head>
<body>

<h2>OTP Test</h2>

<form action="backend/send_otp.php" method="POST">

    <input
        type="email"
        name="email"
        placeholder="Enter registered email"
        required>

    <br><br>

    <button type="submit">
        Send OTP
    </button>

</form>

</body>
</html>