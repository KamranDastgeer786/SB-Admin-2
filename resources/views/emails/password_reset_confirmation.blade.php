<!DOCTYPE html>
<html>
    <head>
        <title>Password Reset Successful</title>
    </head>
    <body>
        <h1>Password Reset Successful</h1>
        <p>Dear {{ $user->name }},</p>
        <p>Your password has been successfully reset. You can now log in with your new password.</p>
        <p>If you did not request this change, please contact our support team immediately.</p>
        <p>Thank you for being a part of our community!</p>
        <p>Best regards,</p>
        <p>The Dashboard Team</p>
    </body>
</html>