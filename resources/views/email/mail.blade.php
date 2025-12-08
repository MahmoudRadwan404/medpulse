<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .token {
            background: #f4f4f4;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 18px;
            text-align: center;
            letter-spacing: 2px;
        }
        .expiry {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>
        
        <p>Hello,</p>
        
     
        
        <p>Please use the following verification token to reset your password:</p>
        
        <div class="token">
            {{ $token }}
        </div>
        
        <p class="expiry">⚠️ This token will expire in 10 minutes.</p>
        
        <p>If you didn't request a password reset, please ignore this email. Your password will remain unchanged.</p>
        
        <p>Thank you,<br>Your Application Team</p>
    </div>
</body>
</html>