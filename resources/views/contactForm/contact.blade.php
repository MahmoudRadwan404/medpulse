<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Message Content</title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .content-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .content-body {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-size: 16px;
            line-height: 1.7;
            color: #333;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 4px;
            border-left: 4px solid #4f46e5;
        }
        .sender-info {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info-label {
            font-weight: 600;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="content-container">
        @if($contact ?? false)
        <div class="sender-info">
            <div><span class="info-label">From:</span> {{ $contact->full_name }}</div>
            <div><span class="info-label">Email:</span> {{ $contact->email }}</div>
            @if($contact->organisation)
            <div><span class="info-label">Organization:</span> {{ $contact->organisation }}</div>
            @endif
            <div><span class="info-label">Type:</span> {{ $contact->asking_type }}</div>
        </div>
        @endif
        
        <div class="content-body">
            {{ $content }}
        </div>
        
        @if($contact ?? false)
        <div style="margin-top: 20px; font-size: 12px; color: #666; text-align: right;">
            Received: {{ $contact->created_at->format('M j, Y, g:i A') }}
        </div>
        @endif
    </div>
</body>
</html>