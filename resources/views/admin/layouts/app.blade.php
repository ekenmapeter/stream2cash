<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - @yield('title', 'Stream2Cash')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts - Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQ6bCgJp10x9P7G/CqR1x+L56E6JgG/32E5f/n5h5u6wN5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
      body {
          font-family: 'Inter', sans-serif;
      }
      /* Custom scrollbar styles */
      ::-webkit-scrollbar {
          width: 8px;
      }
      ::-webkit-scrollbar-track {
          background: #1f2937;
      }
      ::-webkit-scrollbar-thumb {
          background: #4b5563;
          border-radius: 4px;
      }
      ::-webkit-scrollbar-thumb:hover {
          background: #6b7280;
      }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">
  @include('admin.components.header')
  @include('admin.components.sidebar')

  <!-- Impersonation Banner -->
  @if(Auth::check() && Auth::user()->isImpersonated())
    <div class="bg-purple-600 text-white py-2 px-4 text-center text-sm font-medium">
      <div class="flex items-center justify-center gap-2">
        <i class="fa-solid fa-user-secret"></i>
        <span>You are impersonating {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('admin.stop-impersonate') }}" class="inline ml-4">
          @csrf
          <button type="submit" class="bg-purple-700 hover:bg-purple-800 px-3 py-1 rounded text-xs">
            <i class="fa-solid fa-times mr-1"></i>Stop Impersonating
          </button>
        </form>
      </div>
    </div>
  @endif

  <main class="pt-16 md:pl-64">
    @yield('content')
  </main>

  @include('admin.components.footer')
</body>
</html>

