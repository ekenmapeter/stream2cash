<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = $this->settingsService->getAllSettings();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'settings' => 'required|array',
            'settings.*' => 'nullable',
            'site_name' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle logo upload
            if ($request->hasFile('site_logo')) {
                $file = $request->file('site_logo');
                $file->move(public_path('images'), 'logo.png');
            }

            // Handle site name and other settings
            $settingsInput = $request->input('settings', []);

            $updated = $this->settingsService->updateSettings($settingsInput);

            if (count($updated) > 0 || $request->hasFile('site_logo')) {
                return redirect()->back()
                    ->with('success', 'Settings updated successfully!');
            } else {
                return redirect()->back()
                    ->with('warning', 'No settings were updated.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update settings: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Reset settings to defaults
     */
    public function reset()
    {
        try {
            $this->settingsService->resetToDefaults();

            return redirect()->back()
                ->with('success', 'Settings have been reset to default values!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reset settings: ' . $e->getMessage());
        }
    }

    /**
     * Get settings by group (AJAX)
     */
    public function getByGroup(Request $request, $group)
    {
        $settings = $this->settingsService->getAllSettings()[$group] ?? [];

        return response()->json([
            'success' => true,
            'settings' => $settings
        ]);
    }

    /**
     * Update a single setting (AJAX)
     */
    public function updateSingle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'value' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updated = $this->settingsService->updateSettings([
                $request->input('key') => $request->input('value')
            ]);

            if (in_array($request->input('key'), $updated)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Setting updated successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Setting not found or not editable'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update setting: ' . $e->getMessage()
            ], 500);
        }
    }
}
