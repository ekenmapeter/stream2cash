<!-- User IP Records View -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-8">
  <section class="flex justify-center items-center py-8 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-6xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">IP Records</h1>
          <p class="text-gray-600">IP address history for {{ $user->name }}</p>
        </div>
        <a href="{{ route('admin.users.show', $user) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to User
        </a>
      </div>

      <!-- IP Records Table -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b bg-gray-50">
              <th class="text-left py-3 px-4">IP Address</th>
              <th class="text-left py-3 px-4">Location</th>
              <th class="text-left py-3 px-4">Device Info</th>
              <th class="text-left py-3 px-4">Status</th>
              <th class="text-left py-3 px-4">Date</th>
              <th class="text-left py-3 px-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ipRecords as $record)
              <tr class="border-b hover:bg-gray-50 {{ $record->is_suspicious ? 'bg-red-50' : '' }}">
                <td class="py-3 px-4">
                  <span class="font-mono text-sm">{{ $record->ip_address }}</span>
                </td>
                <td class="py-3 px-4">
                  <div class="text-sm">{{ $record->location }}</div>
                  @if($record->country && $record->country !== 'Unknown')
                    <div class="text-xs text-gray-500">{{ $record->country }}</div>
                  @endif
                </td>
                <td class="py-3 px-4">
                  <div class="text-sm">{{ $record->device_info }}</div>
                  @if($record->user_agent)
                    <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $record->user_agent }}">
                      {{ Str::limit($record->user_agent, 50) }}
                    </div>
                  @endif
                </td>
                <td class="py-3 px-4">
                  @if($record->is_suspicious)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                      <i class="fa-solid fa-exclamation-triangle mr-1"></i>Suspicious
                    </span>
                  @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                      <i class="fa-solid fa-check mr-1"></i>Normal
                    </span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  <div class="text-sm">{{ $record->created_at->format('M d, Y') }}</div>
                  <div class="text-xs text-gray-500">{{ $record->created_at->format('H:i:s') }}</div>
                </td>
                <td class="py-3 px-4">
                  <div class="flex gap-2">
                    @if($record->is_suspicious)
                      <form method="POST" action="{{ route('admin.ip-records.clear-suspicion', $record) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-green-600 hover:text-green-800 text-xs" title="Clear suspicion">
                          <i class="fa-solid fa-check-circle"></i>
                        </button>
                      </form>
                    @else
                      <form method="POST" action="{{ route('admin.ip-records.mark-suspicious', $record) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs" title="Mark as suspicious">
                          <i class="fa-solid fa-exclamation-triangle"></i>
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                  <i class="fa-solid fa-search text-4xl mb-4"></i>
                  <p>No IP records found for this user.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($ipRecords->hasPages())
        <div class="mt-6">
          {{ $ipRecords->links() }}
        </div>
      @endif

      <!-- Summary Stats -->
      @if($ipRecords->count() > 0)
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="bg-blue-50 p-4 rounded-lg">
            <div class="flex items-center">
              <i class="fa-solid fa-globe text-blue-600 text-2xl mr-3"></i>
              <div>
                <div class="text-sm text-blue-600">Unique IPs</div>
                <div class="text-2xl font-bold text-blue-800">{{ $ipRecords->pluck('ip_address')->unique()->count() }}</div>
              </div>
            </div>
          </div>

          <div class="bg-red-50 p-4 rounded-lg">
            <div class="flex items-center">
              <i class="fa-solid fa-exclamation-triangle text-red-600 text-2xl mr-3"></i>
              <div>
                <div class="text-sm text-red-600">Suspicious</div>
                <div class="text-2xl font-bold text-red-800">{{ $ipRecords->where('is_suspicious', true)->count() }}</div>
              </div>
            </div>
          </div>

          <div class="bg-green-50 p-4 rounded-lg">
            <div class="flex items-center">
              <i class="fa-solid fa-shield-alt text-green-600 text-2xl mr-3"></i>
              <div>
                <div class="text-sm text-green-600">Normal</div>
                <div class="text-2xl font-bold text-green-800">{{ $ipRecords->where('is_suspicious', false)->count() }}</div>
              </div>
            </div>
          </div>
        </div>
      @endif

    </div>
  </section>
</div>

@endsection
