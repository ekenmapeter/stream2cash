@extends('user.layouts.app')

@section('title', 'Edit Profile | Stream2Cash')

@section('content')
<main class="flex-grow flex flex-col p-6 pt-0 gap-6">
    <header>
        <h1 class="text-2xl font-bold mb-1">Edit Profile</h1>
        <p class="text-sm text-gray-600">Update your account information</p>
    </header>

    <section class="bg-blue-900 text-white p-6 rounded-xl shadow-lg">
        <div class="flex flex-col md:flex-row gap-8 items-start">
            <div class="flex flex-col items-center">
                <img src="{{ route('user.avatar', auth()->id()) }}" alt="Avatar" class="w-40 h-40 rounded-full ring-4 ring-white/30 object-cover">
                <div class="text-xs text-white/70 mt-2">Auto-generated from your name</div>
            </div>
            <form action="{{ route('user.profile.update') }}" method="POST" class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                @csrf
                <div class="col-span-2">
                    <label class="block text-sm text-white/80 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-white/10 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('name') <div class="text-red-300 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm text-white/80 mb-2">Email</label>
                    <input type="email" name="email" disabled value="{{ old('email', $user->email) }}" class="w-full bg-white/10 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('email') <div class="text-red-300 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm text-white/80 mb-2">Payout Method</label>
                    <select name="payout_method" class="text-white w-full bg-blue-700 border-none rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400" !important>
                        @php($method = old('payout_method', $user->payout_method))
                        <option value="">Select a method</option>
                        <option value="bank" {{ $method==='bank'?'selected':'' }}>Bank Transfer</option>
                        <option value="paypal" {{ $method==='paypal'?'selected':'' }}>PayPal</option>
                        <option value="momo" {{ $method==='momo'?'selected':'' }}>Mobile Money</option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="bank_name" class="block text-sm text-white/80 mb-2">Bank Name</label>
                    <select id="bank_name" name="bank_name" class="text-white w-full bg-blue-700 border-none rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Select your bank</option>
                        <option value="Opay">Opay</option>
                        <option value="Moniepoint">Moniepoint</option>
                        <option value="Palmpay">Palmpay</option>
                        <option value="Guaranty Trust Bank (GTB)">Guaranty Trust Bank (GTB)</option>
                        <option value="Access Bank">Access Bank</option>
                        <option value="Zenith Bank">Zenith Bank</option>

                        <option value="Citibank">Citibank</option>
                        <option value="Coronation Merchant Bank">Coronation Merchant Bank</option>
                        <option value="Ecobank Nigeria">Ecobank Nigeria</option>
                        <option value="Fidelity Bank">Fidelity Bank</option>
                        <option value="First Bank of Nigeria">First Bank of Nigeria</option>
                        <option value="First City Monument Bank (FCMB)">First City Monument Bank (FCMB)</option>
                        <option value="Globus Bank">Globus Bank</option>
                        <option value="Heritage Bank">Heritage Bank</option>
                        <option value="Keystone Bank">Keystone Bank</option>
                        <option value="Polaris Bank">Polaris Bank</option>
                        <option value="Providus Bank">Providus Bank</option>
                        <option value="Stanbic IBTC Bank">Stanbic IBTC Bank</option>
                        <option value="Standard Chartered Bank">Standard Chartered Bank</option>
                        <option value="Sterling Bank">Sterling Bank</option>
                        <option value="SunTrust Bank">SunTrust Bank</option>
                        <option value="Titan Trust Bank">Titan Trust Bank</option>
                        <option value="Union Bank of Nigeria">Union Bank of Nigeria</option>
                        <option value="United Bank for Africa (UBA)">United Bank for Africa (UBA)</option>
                        <option value="Unity Bank">Unity Bank</option>
                        <option value="Wema Bank">Wema Bank</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label class="block text-sm text-white/80 mb-2">Account Name</label>
                    <input type="text" name="account_name" value="{{ old('account_name', $user->account_name) }}" class="w-full bg-white/10 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="col-span-1">
                    <label class="block text-sm text-white/80 mb-2">Account Number</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $user->account_number) }}" class="w-full bg-white/10 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="col-span-1">
                    <label class="block text-sm text-white/80 mb-2">PayPal Email</label>
                    <input type="email" name="paypal_email" value="{{ old('paypal_email', $user->paypal_email) }}" class="w-full bg-white/10 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="col-span-1">
                    <label class="block text-sm text-white/80 mb-2">New Password</label>
                    <input type="password" name="password" class="w-full bg-white/10 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Leave blank to keep current">
                    @error('password') <div class="text-red-300 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-1">
                    <label class="block text-sm text-white/80 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-white/10 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="col-span-2 flex gap-3">
                    <a href="{{ route('user.profile') }}" class="px-4 py-3 rounded-lg bg-white/10 hover:bg-white/20 text-white">Cancel</a>
                    <button type="submit" class="px-6 py-3 rounded-lg bg-green-600 hover:bg-green-500 text-white font-semibold">Save Changes</button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection


