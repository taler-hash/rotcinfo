<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6e6d3;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #c2c2a3;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #4b5320;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }
        .content h2 {
            color: #4b5320;
            font-size: 20px;
        }
        .footer {
            background-color: #e6e6d3;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>ROTC Registration Success</h1>
        </div>
        <div class="content">
            <h2>Congratulations!</h2>
            <p>Dear {{ $name }},</p>
            <p>You have successfully registered for the ROTC program. We are excited to have you join us in this journey of discipline, leadership, and service.</p>
            <p>Please note that the ROTC system will send you an email once you are officially enrolled and become a part of the organization. Stay tuned for further updates.</p>
            <p>If you have any questions, feel free to contact us.</p>
            <p>Best regards,</p>
            <p><strong>The ROTC Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> ROTC Program. All rights reserved.</p>
        </div>
    </div>
</body>
</html>