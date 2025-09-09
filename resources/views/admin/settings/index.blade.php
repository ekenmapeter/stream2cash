@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-cog mr-2 text-blue-600"></i>
                System Settings
            </h3>
            <div class="flex space-x-2">
                <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors" onclick="resetSettings()">
                    <i class="fas fa-undo mr-1"></i>
                    Reset to Defaults
                </button>
                <button type="button" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors" onclick="saveAllSettings()">
                    <i class="fas fa-save mr-1"></i>
                    Save All Settings
                </button>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.parentElement.remove()">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.parentElement.remove()">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        {{ session('warning') }}
                    </div>
                    <button type="button" class="text-yellow-700 hover:text-yellow-900" onclick="this.parentElement.parentElement.remove()">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>
            @endif

                    <form id="settingsForm" method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf

                        <!-- Settings Tabs -->
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <button type="button" class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="general">
                                    <i class="fas fa-globe mr-1"></i>
                                    General
                                </button>
                                <button type="button" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="video">
                                    <i class="fas fa-video mr-1"></i>
                                    Video
                                </button>
                                <button type="button" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="anti-cheat">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    Anti-Cheat
                                </button>
                                <button type="button" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="suspension">
                                    <i class="fas fa-user-slash mr-1"></i>
                                    Suspension
                                </button>
                                <button type="button" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="email">
                                    <i class="fas fa-envelope mr-1"></i>
                                    Email
                                </button>
                            </nav>
                        </div>

                        <div class="mt-6">
                            <!-- General Settings -->
                            <div class="tab-content active" id="general">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if(isset($settings['general']))
                                        @foreach($settings['general']['settings'] as $setting)
                                            <div class="space-y-2">
                                                <label for="setting_{{ $setting['key'] }}" class="block text-sm font-medium text-gray-700">
                                                    {{ $setting['label'] }}
                                                    @if($setting['is_public'])
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Public</span>
                                                    @endif
                                                </label>
                                                @if($setting['description'])
                                                    <p class="text-sm text-gray-500">{{ $setting['description'] }}</p>
                                                @endif

                                                @if($setting['type'] === 'boolean')
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                               id="setting_{{ $setting['key'] }}"
                                                               name="settings[{{ $setting['key'] }}]"
                                                               value="1"
                                                               {{ $setting['value'] ? 'checked' : '' }}>
                                                        <label for="setting_{{ $setting['key'] }}" class="ml-2 block text-sm text-gray-900">
                                                            Enable
                                                        </label>
                                                    </div>
                                                @elseif($setting['type'] === 'integer' || $setting['type'] === 'decimal')
                                                    <input type="number"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}"
                                                           step="{{ $setting['type'] === 'decimal' ? '0.01' : '1' }}">
                                                @else
                                                    <input type="text"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}">
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Video Settings -->
                            <div class="tab-content hidden" id="video">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if(isset($settings['video']))
                                        @foreach($settings['video']['settings'] as $setting)
                                            <div class="space-y-2">
                                                <label for="setting_{{ $setting['key'] }}" class="block text-sm font-medium text-gray-700">
                                                    {{ $setting['label'] }}
                                                    @if($setting['is_public'])
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Public</span>
                                                    @endif
                                                </label>
                                                @if($setting['description'])
                                                    <p class="text-sm text-gray-500">{{ $setting['description'] }}</p>
                                                @endif

                                                @if($setting['type'] === 'boolean')
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                               id="setting_{{ $setting['key'] }}"
                                                               name="settings[{{ $setting['key'] }}]"
                                                               value="1"
                                                               {{ $setting['value'] ? 'checked' : '' }}>
                                                        <label for="setting_{{ $setting['key'] }}" class="ml-2 block text-sm text-gray-900">
                                                            Enable
                                                        </label>
                                                    </div>
                                                @elseif($setting['type'] === 'integer' || $setting['type'] === 'decimal')
                                                    <input type="number"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}"
                                                           step="{{ $setting['type'] === 'decimal' ? '0.01' : '1' }}">
                                                @else
                                                    <input type="text"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}">
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Anti-Cheat Settings -->
                            <div class="tab-content hidden" id="anti-cheat">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if(isset($settings['anti_cheat']))
                                        @foreach($settings['anti_cheat']['settings'] as $setting)
                                            <div class="space-y-2">
                                                <label for="setting_{{ $setting['key'] }}" class="block text-sm font-medium text-gray-700">
                                                    {{ $setting['label'] }}
                                                    @if($setting['is_public'])
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Public</span>
                                                    @endif
                                                </label>
                                                @if($setting['description'])
                                                    <p class="text-sm text-gray-500">{{ $setting['description'] }}</p>
                                                @endif

                                                @if($setting['type'] === 'boolean')
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                               id="setting_{{ $setting['key'] }}"
                                                               name="settings[{{ $setting['key'] }}]"
                                                               value="1"
                                                               {{ $setting['value'] ? 'checked' : '' }}>
                                                        <label for="setting_{{ $setting['key'] }}" class="ml-2 block text-sm text-gray-900">
                                                            Enable
                                                        </label>
                                                    </div>
                                                @elseif($setting['type'] === 'integer' || $setting['type'] === 'decimal')
                                                    <input type="number"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}"
                                                           step="{{ $setting['type'] === 'decimal' ? '0.01' : '1' }}">
                                                @else
                                                    <input type="text"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}">
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Suspension Settings -->
                            <div class="tab-content hidden" id="suspension">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if(isset($settings['suspension']))
                                        @foreach($settings['suspension']['settings'] as $setting)
                                            <div class="space-y-2">
                                                <label for="setting_{{ $setting['key'] }}" class="block text-sm font-medium text-gray-700">
                                                    {{ $setting['label'] }}
                                                    @if($setting['is_public'])
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Public</span>
                                                    @endif
                                                </label>
                                                @if($setting['description'])
                                                    <p class="text-sm text-gray-500">{{ $setting['description'] }}</p>
                                                @endif

                                                @if($setting['type'] === 'boolean')
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                               id="setting_{{ $setting['key'] }}"
                                                               name="settings[{{ $setting['key'] }}]"
                                                               value="1"
                                                               {{ $setting['value'] ? 'checked' : '' }}>
                                                        <label for="setting_{{ $setting['key'] }}" class="ml-2 block text-sm text-gray-900">
                                                            Enable
                                                        </label>
                                                    </div>
                                                @elseif($setting['type'] === 'integer' || $setting['type'] === 'decimal')
                                                    <input type="number"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}"
                                                           step="{{ $setting['type'] === 'decimal' ? '0.01' : '1' }}">
                                                @else
                                                    <input type="text"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}">
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Email Settings -->
                            <div class="tab-content hidden" id="email">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if(isset($settings['email']))
                                        @foreach($settings['email']['settings'] as $setting)
                                            <div class="space-y-2">
                                                <label for="setting_{{ $setting['key'] }}" class="block text-sm font-medium text-gray-700">
                                                    {{ $setting['label'] }}
                                                    @if($setting['is_public'])
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Public</span>
                                                    @endif
                                                </label>
                                                @if($setting['description'])
                                                    <p class="text-sm text-gray-500">{{ $setting['description'] }}</p>
                                                @endif

                                                @if($setting['type'] === 'boolean')
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                               id="setting_{{ $setting['key'] }}"
                                                               name="settings[{{ $setting['key'] }}]"
                                                               value="1"
                                                               {{ $setting['value'] ? 'checked' : '' }}>
                                                        <label for="setting_{{ $setting['key'] }}" class="ml-2 block text-sm text-gray-900">
                                                            Enable
                                                        </label>
                                                    </div>
                                                @elseif($setting['type'] === 'integer' || $setting['type'] === 'decimal')
                                                    <input type="number"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}"
                                                           step="{{ $setting['type'] === 'decimal' ? '0.01' : '1' }}">
                                                @else
                                                    <input type="text"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                           id="setting_{{ $setting['key'] }}"
                                                           name="settings[{{ $setting['key'] }}]"
                                                           value="{{ $setting['value'] }}">
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function saveAllSettings() {
    document.getElementById('settingsForm').submit();
}

function resetSettings() {
    if (confirm('Are you sure you want to reset all settings to their default values? This action cannot be undone.')) {
        // Create a form to submit the reset request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.settings.reset") }}';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        document.body.appendChild(form);
        form.submit();
    }
}

// Tab functionality
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
        content.classList.remove('active');
    });

    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    const selectedContent = document.getElementById(tabName);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
        selectedContent.classList.add('active');
    }

    // Add active class to selected tab button
    const selectedButton = document.querySelector(`[data-tab="${tabName}"]`);
    if (selectedButton) {
        selectedButton.classList.add('active', 'border-blue-500', 'text-blue-600');
        selectedButton.classList.remove('border-transparent', 'text-gray-500');
    }
}

// Auto-save individual settings on change
document.addEventListener('DOMContentLoaded', function() {
    // Tab button event listeners
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            switchTab(tabName);
        });
    });

    const inputs = document.querySelectorAll('input[name^="settings["]');

    inputs.forEach(input => {
        input.addEventListener('change', function() {
            const key = this.name.match(/settings\[(.+)\]/)[1];
            const value = this.type === 'checkbox' ? (this.checked ? '1' : '0') : this.value;

            // Send AJAX request to update single setting
            fetch('{{ route("admin.settings.single") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    key: key,
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success notification
                    showNotification('Setting updated successfully!', 'success');
                } else {
                    // Show error notification
                    showNotification(data.message || 'Failed to update setting', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while updating the setting', 'error');
            });
        });
    });
});

// Simple notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-md text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
