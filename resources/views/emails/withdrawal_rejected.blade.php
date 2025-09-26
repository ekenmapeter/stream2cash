@php($appName = config('app.name', 'Stream2Cash'))
@php($logo = asset('images/logo.png'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Withdrawal Rejected • {{ $appName }}</title>
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
            background: #EF4444;
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
        .withdrawal-details {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }
        .withdrawal-details h3 {
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
        .amount {
            color: #EF4444;
            font-size: 18px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            background: #EF4444;
            color: #ffffff;
        }
        .refund-notice {
            background: #f0fdf4;
            border: 1px solid #22c55e;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
        }
        .refund-notice h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            font-weight: 600;
            color: #166534;
        }
        .refund-notice p {
            margin: 0;
            font-size: 14px;
            color: #166534;
        }
        .rejection-reason {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
        }
        .rejection-reason h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            font-weight: 600;
            color: #991b1b;
        }
        .rejection-reason p {
            margin: 0;
            font-size: 14px;
            color: #991b1b;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">
                <div class="logo"><img src="{{ asset('images/logo.png') }}" alt="StreamAdolla" ></div>

            </div>
        </div>

        <div class="hero">
            <h2>Stream Adolla - Withdrawal Rejected</h2>
            <p>Your withdrawal request could not be processed</p>
        </div>

        <div class="content">
            <div class="greeting">Hello {{ $user->name }},</div>

            <div class="message">
                We regret to inform you that your withdrawal request has been rejected.
                The amount has been refunded to your account balance and is available for future withdrawals.
            </div>

            <div class="refund-notice">
                <h4>💰 Refund Processed</h4>
                <p>The withdrawal amount has been automatically refunded to your account balance. You can request a new withdrawal at any time.</p>
            </div>

            <div class="withdrawal-details">
                <h3>Withdrawal Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Amount:</span>
                    <span class="detail-value amount">${{ number_format($withdrawal->amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value">{{ ucfirst($withdrawal->method ?? 'Bank Transfer') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="status-badge">Rejected</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Rejected On:</span>
                    <span class="detail-value">{{ $withdrawal->processed_at->format('M d, Y H:i') }}</span>
                </div>
            </div>

            @if($withdrawal->admin_notes)
            <div class="rejection-reason">
                <h4>Rejection Reason:</h4>
                <p>{{ $withdrawal->admin_notes }}</p>
            </div>
            @endif

            <div class="message">
                If you have any questions about this rejection or need assistance with your account,
                please don't hesitate to contact our support team.
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
