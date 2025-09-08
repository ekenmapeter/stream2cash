<!-- Reports Page -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-4xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Reports & Exports</h1>
          <p class="text-gray-600">Generate and export platform reports</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
      </div>

      <!-- Report Types -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        <!-- User Reports -->
        <div class="bg-blue-50 p-6 rounded-xl">
          <div class="flex items-center mb-4">
            <i class="fa-solid fa-users text-2xl text-blue-600 mr-3"></i>
            <h3 class="text-lg font-semibold text-blue-800">User Reports</h3>
          </div>
          <p class="text-sm text-blue-600 mb-4">Export user data, registrations, and activity reports</p>
          <div class="space-y-4">
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="users">
              <input type="hidden" name="format" value="csv">
              <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-download mr-2"></i>Export Users (CSV)
              </button>
            </form>
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="users">
              <input type="hidden" name="format" value="excel">
              <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-file-excel mr-2"></i>Export Users (Excel)
              </button>
            </form>
          </div>
        </div>

        <!-- Earning Reports -->
        <div class="bg-green-50 p-6 rounded-xl">
          <div class="flex items-center mb-4">
            <i class="fa-solid fa-dollar-sign text-2xl text-green-600 mr-3"></i>
            <h3 class="text-lg font-semibold text-green-800">Earning Reports</h3>
          </div>
          <p class="text-sm text-green-600 mb-4">Export earning data and transaction reports</p>
          <div class="space-y-2">
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="earnings">
              <input type="hidden" name="format" value="csv">
              <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-download mr-2"></i>Export Earnings (CSV)
              </button>
            </form>
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="earnings">
              <input type="hidden" name="format" value="excel">
              <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-file-excel mr-2"></i>Export Earnings (Excel)
              </button>
            </form>
          </div>
        </div>

        <!-- Withdrawal Reports -->
        <div class="bg-yellow-50 p-6 rounded-xl">
          <div class="flex items-center mb-4">
            <i class="fa-solid fa-money-bill-transfer text-2xl text-yellow-600 mr-3"></i>
            <h3 class="text-lg font-semibold text-yellow-800">Withdrawal Reports</h3>
          </div>
          <p class="text-sm text-yellow-600 mb-4">Export withdrawal requests and processing reports</p>
          <div class="space-y-2">
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="withdrawals">
              <input type="hidden" name="format" value="csv">
              <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-download mr-2"></i>Export Withdrawals (CSV)
              </button>
            </form>
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="withdrawals">
              <input type="hidden" name="format" value="excel">
              <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-file-excel mr-2"></i>Export Withdrawals (Excel)
              </button>
            </form>
          </div>
        </div>

        <!-- Task Reports -->
        <div class="bg-purple-50 p-6 rounded-xl">
          <div class="flex items-center mb-4">
            <i class="fa-solid fa-tasks text-2xl text-purple-600 mr-3"></i>
            <h3 class="text-lg font-semibold text-purple-800">Task Reports</h3>
          </div>
          <p class="text-sm text-purple-600 mb-4">Export task data and completion reports</p>
          <div class="space-y-2">
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="tasks">
              <input type="hidden" name="format" value="csv">
              <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-download mr-2"></i>Export Tasks (CSV)
              </button>
            </form>
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="tasks">
              <input type="hidden" name="format" value="excel">
              <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-file-excel mr-2"></i>Export Tasks (Excel)
              </button>
            </form>
          </div>
        </div>

        <!-- Financial Summary -->
        <div class="bg-red-50 p-6 rounded-xl">
          <div class="flex items-center mb-4">
            <i class="fa-solid fa-chart-pie text-2xl text-red-600 mr-3"></i>
            <h3 class="text-lg font-semibold text-red-800">Financial Summary</h3>
          </div>
          <p class="text-sm text-red-600 mb-4">Export comprehensive financial reports</p>
          <div class="space-y-2">
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="financial">
              <input type="hidden" name="format" value="excel">
              <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-file-excel mr-2"></i>Financial Summary (Excel)
              </button>
            </form>
            <form method="GET" action="{{ route('admin.reports.export') }}" class="inline">
              <input type="hidden" name="type" value="financial">
              <input type="hidden" name="format" value="pdf">
              <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-file-pdf mr-2"></i>Financial Summary (PDF)
              </button>
            </form>
          </div>
        </div>

        <!-- Custom Reports -->
        <div class="bg-gray-50 p-6 rounded-xl">
          <div class="flex items-center mb-4">
            <i class="fa-solid fa-cog text-2xl text-gray-600 mr-3"></i>
            <h3 class="text-lg font-semibold text-gray-800">Custom Reports</h3>
          </div>
          <p class="text-sm text-gray-600 mb-4">Generate custom reports with date ranges</p>
          <div class="space-y-2">
            <button onclick="showCustomReportModal()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
              <i class="fa-solid fa-plus mr-2"></i>Create Custom Report
            </button>
          </div>
        </div>

      </div>

      <!-- Recent Exports -->
      <div class="bg-gray-50 p-6 rounded-xl">
        <h3 class="text-lg font-semibold mb-4">Recent Exports</h3>
        <div class="text-center text-gray-500 py-8">
          <i class="fa-solid fa-file-export text-4xl mb-4"></i>
          <p>No recent exports found. Generate your first report above.</p>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Custom Report Modal -->
<div id="customReportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
      <h3 class="text-lg font-semibold mb-4">Create Custom Report</h3>
      <form method="GET" action="{{ route('admin.reports.export') }}">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="users">Users</option>
              <option value="earnings">Earnings</option>
              <option value="withdrawals">Withdrawals</option>
              <option value="tasks">Tasks</option>
              <option value="financial">Financial Summary</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
            <select name="format" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="csv">CSV</option>
              <option value="excel">Excel</option>
              <option value="pdf">PDF</option>
            </select>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
              <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
              <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
          </div>
        </div>
        <div class="flex gap-4 mt-6">
          <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            Generate Report
          </button>
          <button type="button" onclick="hideCustomReportModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function showCustomReportModal() {
  document.getElementById('customReportModal').classList.remove('hidden');
}

function hideCustomReportModal() {
  document.getElementById('customReportModal').classList.add('hidden');
}
</script>

@endsection
