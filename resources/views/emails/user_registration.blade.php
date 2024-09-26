<!DOCTYPE html>
<html>
    <head>
       <title>Welcome to Our Dashboard</title>
    </head>

    <body>
       <h1>Welcome to Our Dashboard, {{ $user->name }}!</h1>
       <p>Dear {{ $user->name }},</p>

        <p>
            We are thrilled to have you as a part of our community. Your account has been created successfully.
            Here are the details of your account:
        </p>

        <ul>
           <li><strong>Email:</strong> {{ $user->email }}</li>
           <li><strong>Registration Date:</strong> {{ \Carbon\Carbon::now()->format('F j, Y') }}</li>
        </ul>

        <p>
            You can now log in to your account and explore all the features we have to offer.
            If you ever need to reset your password, you can use our password recovery feature.
        </p>

        <p>
            If you have any questions or need assistance, feel free to contact us at [support@example.com].
        </p>
    </body>
</html>

