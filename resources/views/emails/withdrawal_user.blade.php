@php($appName = config('app.name', 'StreamAdolla'))
@php($logo = asset('images/logo.png'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Withdrawal Request Submitted • {{ $appName }}</title>
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
            background: #162996;
            border-radius: 16px 16px 0 0;
            margin: 0 16px;
        }
        .hero h2 {
            margin: 0 0 12px 0;
            font-size: 24px;
            font-weight: 700;
        }
        .hero p {
            margin: 0;
            color: #e0e7ff;
            font-size: 16px;
        }
        .card {
            margin: 0 16px;
            background: #ffffff;
            border-radius: 0 0 16px 16px;
            padding: 32px 24px;
            color: #0f172a;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card p {
            margin: 0 0 20px 0;
            line-height: 1.6;
            font-size: 16px;
        }
        .withdrawal-details {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
            border-left: 4px solid #FFD700;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #475569;
        }
        .detail-value {
            font-weight: 700;
            color: #0f172a;
        }
        .amount {
            font-size: 24px;
            color: #10B981;
            font-weight: 800;
            text-align: center;
            margin: 16px 0;
        }
        .status-badge {
            display: inline-block;
            background: #FFD700;
            color: #0A1C64;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 700;
            margin-top: 8px;
        }
        .next-steps {
            background: #f0f9ff;
            border-radius: 8px;
            padding: 16px;
            margin: 20px 0;
            border: 1px solid #e0f2fe;
        }
        .next-steps h3 {
            margin: 0 0 12px 0;
            color: #0A1C64;
            font-size: 18px;
        }
        .next-steps ul {
            margin: 0;
            padding-left: 20px;
            color: #475569;
        }
        .next-steps li {
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            background: #FFD700;
            color: #0A1C64 !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin: 16px 0;
        }
        .btn:hover {
            background: #FFC400;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        .muted {
            color: #475569;
            font-size: 14px;
        }
        .footer {
            padding: 32px 24px;
            text-align: center;
            color: #cbd5e1;
            font-size: 14px;
        }
        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 24px 0;
        }
        .testimonial {
            background: #f8fafc;
            border-radius: 8px;
            padding: 16px;
            margin: 20px 0;
            border-left: 4px solid #FFD700;
        }
        .testimonial-text {
            font-style: italic;
            margin: 0 0 8px 0;
            color: #475569;
        }
        .testimonial-author {
            font-weight: 600;
            color: #0f172a;
            font-size: 14px;
        }
        .stars {
            color: #FFD700;
            margin: 4px 0;
            font-size: 14px;
        }
        .cta-section {
            text-align: center;
            margin: 24px 0;
        }

        @media (max-width: 640px) {
            .container {
                width: 100%;
            }
            .header, .hero, .card {
                padding-left: 16px;
                padding-right: 16px;
            }
            .hero h2 {
                font-size: 20px;
            }
            .btn {
                display: block;
                width: 100%;
                padding: 16px;
            }
            .detail-row {
                flex-direction: column;
                gap: 4px;
            }
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
        <h2>Withdrawal Request Submitted!</h2>
        <p>Your earnings are on the way to your account.</p>
    </div>

    <div class="card">
        <p>Hi <strong>{{ $user->name }}</strong>,</p>
        <p>We've successfully received your withdrawal request. Your funds are being processed and will be sent to you shortly.</p>

        <div class="withdrawal-details">
            <div class="amount">₦{{ number_format($withdrawal->amount, 2) }}</div>
            <div class="detail-row">
                <span class="detail-label">Withdrawal Method:</span>
                <span class="detail-value">{{ $withdrawal->method }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Request Date:</span>
                <span class="detail-value">{{ \Illuminate\Support\Carbon::parse($withdrawal->requested_at)->format('M d, Y h:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    Processing
                    <div class="status-badge">Under Review</div>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Bank</span>
                <span class="detail-value">{{ data_get($withdrawal->account_details, 'bank_name') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Account Name</span>
                <span class="detail-value">{{ data_get($withdrawal->account_details, 'account_name') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Account Number</span>
                <span class="detail-value">{{ data_get($withdrawal->account_details, 'account_number') }}</span>
            </div>
        </div>

        <div class="next-steps">
            <h3>What happens next?</h3>
            <ul>
                <li>Our team will review your request (usually within 24-48 hours)</li>
                <li>You'll receive a confirmation email once approved</li>
                <li>Funds will be transferred to your selected payment method</li>
            </ul>
        </div>

        <div class="cta-section">
            <a class="btn" href="{{ route('user.dashboard') }}">View Your Dashboard</a>
        </div>

        <div class="testimonial">
            <p class="testimonial-text">"I've made multiple withdrawals with {{ $appName }} and they always process quickly. Great service!"</p>
            <div class="stars">★★★★★</div>
            <p class="testimonial-author">- Michael T., Verified User</p>
        </div>

        <p>We'll notify you via email once your withdrawal is approved and processed.</p>

        <div class="divider"></div>

        <p class="muted">If you have any questions about your withdrawal, please contact our support team.</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} {{ $appName }} • Get Paid Watching Videos</p>
        <p style="margin:8px 0; font-size:12px;">Thank you for being part of our community!</p>
    </div>
</div>
</body>
</html>
