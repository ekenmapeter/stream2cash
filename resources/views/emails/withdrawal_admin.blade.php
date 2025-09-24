@php($appName = config('app.name', 'StreamAdolla'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Withdrawal Request • {{ $appName }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background:#f6f7fb; color:#0f172a; }
        .container { max-width:640px; margin:0 auto; padding:24px; }
        .card { background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; padding:24px; }
        .h1 { font-size:20px; margin:0 0 12px 0; }
        .meta { color:#475569; font-size:14px; margin-bottom:16px; }
        .row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f1f5f9; }
        .row:last-child { border-bottom:0; }
        .label { color:#475569; font-weight:600; }
        .btn { display:inline-block; margin-top:16px; background:#0A1C64; color:#fff !important; text-decoration:none; padding:10px 16px; border-radius:8px; font-weight:700; }
    </style>
    </head>
<body>
    <div class="container">
        <div class="card">
            <div class="h1">New Withdrawal Request</div>
            <div class="meta">User {{ $user->name }} ({{ $user->email }}) initiated a withdrawal.</div>
            <div class="row"><span class="label">Amount</span><span>₦{{ number_format($withdrawal->amount, 2) }}</span></div>
            <div class="row"><span class="label">Method</span><span>{{ $withdrawal->method }}</span></div>
            <div class="row"><span class="label">Requested</span><span>{{ \Illuminate\Support\Carbon::parse($withdrawal->requested_at)->format('M d, Y h:i A') }}</span></div>
            <div class="row"><span class="label">Bank</span><span>{{ data_get($withdrawal->account_details, 'bank_name') }}</span></div>
            <div class="row"><span class="label">Account Name</span><span>{{ data_get($withdrawal->account_details, 'account_name') }}</span></div>
            <div class="row"><span class="label">Account Number</span><span>{{ data_get($withdrawal->account_details, 'account_number') }}</span></div>
            <a class="btn" href="{{ route('admin.withdrawals') }}">Review in Admin</a>
        </div>
    </div>
</body>
</html>


