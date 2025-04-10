<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Cadet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #2e4e1e;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .body {
            padding: 20px;
            line-height: 1.6;
        }
        .body h2 {
            color: #2e4e1e;
        }
        .footer {
            background-color: #2e4e1e;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background-color: #4caf50;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to the ROTC Program!</h1>
        </div>
        <div class="body">
            <h2>Congratulations, {{ $name }}!</h2>
            <p>We are thrilled to welcome you to the ROTC Cadet Program. Your enrollment has been successfully completed, and we are excited to have you on board.</p>
            <p>As a cadet, you are now part of a proud tradition of discipline, leadership, and excellence. We look forward to seeing you grow and achieve great things.</p>
            <p>If you have any questions or need assistance, feel free to reach out to us anytime.</p>
            <a href="http://localhost:8000" class="button">Explore Future Announcements</a>
        </div>
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> ROTC Program. All rights reserved.</p>
        </div>
    </div>
</body>
</html>