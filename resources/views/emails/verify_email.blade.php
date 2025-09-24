@php($appName = $appName ?? config('app.name', 'StreamAdolla'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify your email • {{ $appName }}</title>
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
        .features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 24px 0;
        }
        .feature {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .feature-icon {
            width: 24px;
            height: 24px;
            background: #FFD700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0A1C64;
            font-weight: bold;
            font-size: 14px;
        }
        .feature-text {
            font-size: 14px;
            color: #475569;
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
        .cta-text {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #0f172a;
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
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="brand">
            <img alt="{{ $appName }}" src="{{ asset('images/logo.png') }}" width="48" height="48" style="border-radius:12px" />
            <h1>{{ $appName }}</h1>
        </div>
    </div>

    <div class="hero">
        <h2>Confirm your email to start earning! 🎬</h2>
        <p>Activate your account and begin watching videos to earn real cash rewards.</p>
    </div>

    <div class="card">
        <p>Hello {{ $user->name }},</p>
        <p>Welcome to <strong>{{ $appName }}</strong>! We're excited to have you join our community of video watchers who earn money doing what they love.</p>

        <div class="cta-section">
            <p class="cta-text">Verify your email to get started:</p>
            <a class="btn" href="{{ $actionUrl }}">Verify Email Address</a>
        </div>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">✔</div>
                <div class="feature-text">Watch videos & earn instantly</div>
            </div>
            <div class="feature">
                <div class="feature-icon">✔</div>
                <div class="feature-text">Daily new video drops</div>
            </div>
            <div class="feature">
                <div class="feature-icon">✔</div>
                <div class="feature-text">Redeem gift cards or cash rewards</div>
            </div>
        </div>

        <div class="testimonial">
            <p class="testimonial-text">"I've been using {{ $appName }} for 3 months and already earned over $150. It's so easy!"</p>
            <div class="stars">★★★★★</div>
            <p class="testimonial-author">- Sarah J., Verified User</p>
        </div>

        <p class="muted">This verification link will expire in 24 hours. If you didn't create an account with {{ $appName }}, you can safely ignore this email.</p>

        <div class="divider"></div>

        <p style="margin:0; font-size:14px;">Having trouble with the button?</p>
        <p style="word-break:break-all; margin:8px 0 0 0; font-size:14px;"><a href="{{ $actionUrl }}" style="color: #0A1C64;">{{ $actionUrl }}</a></p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} {{ $appName }} • Get Paid Watching Videos</p>
        <p style="margin:8px 0; font-size:12px;">If you have any questions, contact our support team.</p>
        <p style="margin:0; font-size:12px;">You're receiving this email because you signed up for {{ $appName }}.</p>
    </div>
</div>
</body>
</html>
