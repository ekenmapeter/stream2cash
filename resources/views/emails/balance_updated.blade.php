@php($appName = config('app.name', 'Stream Adolla'))
@php($logo = asset('images/logo.png'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Balance Updated • {{ $appName }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #0A1C64;
            color: #ffffff;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', Arial, sans-serif;
        }
        .container {
            max-width: 640px;
            margin: 0 auto;
            background: #0A1C64;
        }
        .header {
            padding: 32px 24px 16px 24px;
            text-align: center;
            background: linear-gradient(135deg, #0A1C64 0%, #162996 100%);
        }
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        .brand h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
        }
        .hero {
            padding: 24px;
            text-align: center;
            background: #3b82f6;
            border-radius: 16px 16px 0 0;
            margin: 0 16px;
        }
        .hero h2 {
            margin: 0 0 12px 0;
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
        }
        .hero p {
            margin: 0;
            font-size: 16px;
            color: #ffffff;
            opacity: 0.9;
        }
        .content {
            background: #ffffff;
            color: #1f2937;
            padding: 32px 24px;
            margin: 0 16px;
            border-radius: 0 0 16px 16px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1f2937;
        }
        .message {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 24px;
            color: #4b5563;
        }
        .balance-details {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }
        .balance-details h3 {
            margin: 0 0 16px 0;
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 500;
            color: #6b7280;
        }
        .detail-value {
            font-weight: 600;
            color: #1f2937;
        }
        .old-balance {
            color: #6b7280;
            font-size: 16px;
        }
        .new-balance {
            color: #10B981;
            font-size: 18px;
        }
        .change-amount {
            font-size: 18px;
            font-weight: 700;
        }
        .increase {
            color: #10B981;
        }
        .decrease {
            color: #EF4444;
        }
        .reason-section {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
        }
        .reason-section h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            font-weight: 600;
            color: #0c4a6e;
        }
        .reason-section p {
            margin: 0;
            font-size: 14px;
            color: #0c4a6e;
        }
        .admin-info {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
        }
        .admin-info h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }
        .admin-info p {
            margin: 0;
            font-size: 14px;
            color: #374151;
        }
        .cta {
            text-align: center;
            margin: 32px 0;
        }
        .cta-button {
            display: inline-block;
            background: #0A1C64;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            padding: 24px;
            color: #9ca3af;
            font-size: 14px;
        }
        .footer p {
            margin: 0 0 8px 0;
        }
        .footer a {
            color: #3b82f6;
            text-decoration: none;
        }
        .logo img {
            height: 40px;
            width: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">
                <div class="logo"><img src="{{ asset('images/logo.png') }}" alt="StreamAdolla"></div>
            </div>
        </div>
        
        <div class="hero">
            <h2>Stream Adolla - Account Balance Updated</h2>
            <p>Your account balance has been modified by an administrator</p>
        </div>
        
        <div class="content">
            <div class="greeting">Hello {{ $user->name }},</div>
            
            <div class="message">
                Your account balance has been updated by an administrator. Please review the details below and contact support if you have any questions.
            </div>
            
            <div class="balance-details">
                <h3>Balance Update Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Previous Balance:</span>
                    <span class="detail-value old-balance">${{ number_format($oldBalance, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">New Balance:</span>
                    <span class="detail-value new-balance">${{ number_format($newBalance, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Change Amount:</span>
                    <span class="detail-value change-amount {{ $newBalance > $oldBalance ? 'increase' : 'decrease' }}">
                        {{ $newBalance > $oldBalance ? '+' : '' }}${{ number_format($newBalance - $oldBalance, 2) }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Updated On:</span>
                    <span class="detail-value">{{ now()->format('M d, Y H:i') }}</span>
                </div>
            </div>
            
            <div class="reason-section">
                <h4>Reason for Update:</h4>
                <p>{{ $reason }}</p>
            </div>
            
            <div class="admin-info">
                <h4>Updated By:</h4>
                <p>{{ $adminName }} (Administrator)</p>
            </div>
            
            <div class="message">
                If you have any questions about this balance update or notice any discrepancies, 
                please don't hesitate to contact our support team immediately.
            </div>
            
            <div class="cta">
                <a href="{{ route('user.dashboard') }}" class="cta-button">View Dashboard</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for using {{ $appName }}!</p>
            <p>
                <a href="{{ route('user.dashboard') }}">Dashboard</a> •
                <a href="mailto:support@streamadolla.com">Support</a>
            </p>
        </div>
    </div>
</body>
</html>
