<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to StreamAdolla</title>
    <style>
        /* Base styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #0A1C64;
            color: white;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #0A1C64;
        }

        .content {
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 20px 0;
        }


        .hero {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(to right, #0A1C64, #162996);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        p {
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px 5px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .btn-primary {
            background-color: white;
            color: #0A1C64;
        }

        .btn-secondary {
            background-color: #FFD700;
            color: black;
        }

        .features {
            background-color: #162996;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }

        .feature-list li:before {
            content: "✔";
            position: absolute;
            left: 0;
            color: #FFD700;
        }

        .testimonial {
            background-color: white;
            color: black;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 10px;
        }

        .testimonial-author {
            font-weight: bold;
        }

        .stars {
            color: #FFD700;
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #ccc;
        }

        .social-links {
            margin: 15px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #FFD700;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .container {
                width: 100%;
            }

            .btn {
                display: block;
                width: 90%;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo"><img src="{{ asset('images/logo.png') }}" alt="StreamAdolla" ></div>
        </div>

        <div class="content">
            <div class="hero">
                <h1>Welcome to StreamAdolla, {{ $user->name }}! 🎬</h1>
                <p>Get ready to earn real cash just by watching videos!</p>
            </div>

            <p>We're thrilled to have you join our community of video enthusiasts who are earning money doing what they love.</p>

            <div class="features">
                <h2 style="text-align: center; margin-top: 0;">Here's what you can do:</h2>
                <ul class="feature-list">
                    <li>Watch videos & earn instantly</li>
                    <li>Discover new video drops daily</li>
                    <li>Redeem gift cards or cash rewards</li>
                    <li>Join thousands of satisfied users worldwide</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ route('login') }}" class="btn btn-primary">Sign In to Your Account</a>
                <a href="#" class="btn btn-secondary">How It Works</a>
            </div>

            <div class="testimonial">
                <p class="testimonial-text">"StreamAdolla helped me earn my first PayPal gift card. Super easy and the payments are instant!"</p>
                <div class="stars">★★★★★</div>
                <p class="testimonial-author">- Amina Yusuf, Freelancer</p>
            </div>

            <p>Ready to start earning? Login to your dashboard and watch your first video today!</p>

            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ route('login') }}" class="btn btn-primary" style="background-color: #FFD700; color: black; font-size: 16px; padding: 15px 30px;">Start Watching & Earning Now</a>
            </div>

            <p>If you have any questions, feel free to reply to this email or visit our Help Center.</p>

            <p>Happy watching!<br>
            <strong>The StreamAdolla Team</strong></p>
        </div>

        <div class="footer">
            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Twitter</a> |
                <a href="#">Instagram</a>
            </div>
            <p>StreamAdolla - Get Paid Watching Videos</p>
            <p>You're receiving this email because you signed up for StreamAdolla.</p>
            <p><a href="#" style="color: #FFD700;">Unsubscribe</a> | <a href="#" style="color: #FFD700;">Privacy Policy</a></p>
        </div>
    </div>
</body>
</html>
