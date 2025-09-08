@extends('admin.layouts.app')

@section('content')
<div class="pt-4 px-4">
  <section class="flex justify-center items-center py-8 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-6xl p-8">

      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Earning Analytics</h1>
          <p class="text-gray-600">Earnings with user context</p>
        </div>
        <a href="{{ route('admin.analytics') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Overview
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200 rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($earnings as $earning)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ $earning->user->name }}</div>
                  <div class="text-sm text-gray-500">{{ $earning->user->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₪{{ number_format($earning->amount, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($earning->type ?? 'watch') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($earning->created_at)->format('M d, Y H:i') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No earnings found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($earnings->hasPages())
        <div class="mt-6">
          {{ $earnings->links() }}
        </div>
      @endif

    </div>
  </section>
</div>
@endsection


