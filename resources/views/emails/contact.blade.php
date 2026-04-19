<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .field:last-child {
            border-bottom: none;
        }
        .field-label {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
        }
        .field-value {
            color: #333;
            font-size: 16px;
        }
        .message-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 New Contact Form Submission</h1>
        </div>
        
        <div class="content">
            <p style="font-size: 16px; color: #6b7280; margin-bottom: 25px;">
                You have received a new message from the JOB-lyNK contact form.
            </p>
            
            <div class="field">
                <div class="field-label">Full Name</div>
                <div class="field-value">{{ $name }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">Email Address</div>
                <div class="field-value">
                    <a href="mailto:{{ $email }}" style="color: #3b82f6; text-decoration: none;">{{ $email }}</a>
                </div>
            </div>
            
            <div class="field">
                <div class="field-label">Subject</div>
                <div class="field-value">{{ $subject }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">Message</div>
                <div class="message-box">
                    {{ $messageContent }}
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p style="margin: 0;">This email was sent from the JOB-lyNK contact form</p>
            <p style="margin: 5px 0 0 0;">© 2024 JOB-lyNK. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
