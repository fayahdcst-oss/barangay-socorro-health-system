<!DOCTYPE html>
<html>
<head>
    <title>Test Verify OTP</title>
</head>
<body>

<h2>Verify OTP</h2>

<form action="backend/verify_otp.php" method="POST">

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>OTP Code</label><br>
    <input type="text" name="otp" maxlength="6" required><br><br>

    <button type="submit">
        Verify OTP
    </button>

</form>

</body>
</html>