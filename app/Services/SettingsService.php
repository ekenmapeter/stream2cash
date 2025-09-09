<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    /**
     * Get all settings grouped by category
     */
    public function getAllSettings()
    {
        return Setting::getEditable()
            ->groupBy('group')
            ->map(function ($settings, $group) {
                return [
                    'group' => $group,
                    'settings' => $settings->map(function ($setting) {
                        return [
                            'id' => $setting->id,
                            'key' => $setting->key,
                            'value' => $setting->value,
                            'type' => $setting->type,
                            'label' => $setting->label,
                            'description' => $setting->description,
                            'options' => $setting->options,
                            'is_public' => $setting->is_public,
                            'is_editable' => $setting->is_editable,
                            'sort_order' => $setting->sort_order,
                        ];
                    })
                ];
            });
    }

    /**
     * Update multiple settings
     */
    public function updateSettings(array $settings)
    {
        $updated = [];

        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if ($setting && $setting->is_editable) {
                $setting->update(['value' => $value]);
                $updated[] = $key;
            }
        }

        // Clear cache for updated settings
        foreach ($updated as $key) {
            \Cache::forget("setting.{$key}");
        }

        return $updated;
    }

    /**
     * Get video-related settings
     */
    public function getVideoSettings()
    {
        return [
            'allow_seeking' => Setting::get('video_allow_seeking', false),
            'allow_pausing' => Setting::get('video_allow_pausing', false),
            'min_watch_percentage' => Setting::get('video_min_watch_percentage', 85),
            'heartbeat_interval' => Setting::get('video_heartbeat_interval', 10),
            'countdown_duration' => Setting::get('video_countdown_duration', 5),
        ];
    }

    /**
     * Get anti-cheat settings
     */
    public function getAntiCheatSettings()
    {
        return [
            'max_seek_count' => Setting::get('anti_cheat_max_seek_count', 3),
            'max_pause_count' => Setting::get('anti_cheat_max_pause_count', 5),
            'require_tab_visible' => Setting::get('anti_cheat_require_tab_visible', true),
            'min_heartbeat_frequency' => Setting::get('anti_cheat_min_heartbeat_frequency', 0.5),
        ];
    }

    /**
     * Get suspension settings
     */
    public function getSuspensionSettings()
    {
        return [
            'autopilot_enabled' => Setting::get('suspension_autopilot_enabled', false),
            'auto_approve_threshold' => Setting::get('suspension_auto_approve_threshold', 90),
            'notify_admins' => Setting::get('suspension_notify_admins', true),
        ];
    }

    /**
     * Get email settings
     */
    public function getEmailSettings()
    {
        return [
            'admin_address' => Setting::get('email_admin_address', 'admin@stream2cash.com'),
            'from_name' => Setting::get('email_from_name', 'Stream2Cash'),
        ];
    }

    /**
     * Get general settings
     */
    public function getGeneralSettings()
    {
        return [
            'site_name' => Setting::get('site_name', 'Stream2Cash'),
            'site_description' => Setting::get('site_description', 'Earn money by watching videos'),
            'maintenance_mode' => Setting::get('maintenance_mode', false),
        ];
    }

    /**
     * Check if video seeking is allowed
     */
    public function isVideoSeekingAllowed()
    {
        return Setting::get('video_allow_seeking', false);
    }

    /**
     * Check if video pausing is allowed
     */
    public function isVideoPausingAllowed()
    {
        return Setting::get('video_allow_pausing', false);
    }

    /**
     * Get minimum watch percentage
     */
    public function getMinWatchPercentage()
    {
        return Setting::get('video_min_watch_percentage', 85);
    }

    /**
     * Get heartbeat interval
     */
    public function getHeartbeatInterval()
    {
        return Setting::get('video_heartbeat_interval', 10);
    }

    /**
     * Get countdown duration
     */
    public function getCountdownDuration()
    {
        return Setting::get('video_countdown_duration', 5);
    }

    /**
     * Get maximum seek count
     */
    public function getMaxSeekCount()
    {
        return Setting::get('anti_cheat_max_seek_count', 3);
    }

    /**
     * Get maximum pause count
     */
    public function getMaxPauseCount()
    {
        return Setting::get('anti_cheat_max_pause_count', 5);
    }

    /**
     * Check if tab visibility is required
     */
    public function isTabVisibilityRequired()
    {
        return Setting::get('anti_cheat_require_tab_visible', true);
    }

    /**
     * Get minimum heartbeat frequency
     */
    public function getMinHeartbeatFrequency()
    {
        return Setting::get('anti_cheat_min_heartbeat_frequency', 0.5);
    }

    /**
     * Check if autopilot is enabled
     */
    public function isAutopilotEnabled()
    {
        return Setting::get('suspension_autopilot_enabled', false);
    }

    /**
     * Get auto-approve threshold
     */
    public function getAutoApproveThreshold()
    {
        return Setting::get('suspension_auto_approve_threshold', 90);
    }

    /**
     * Check if admin notifications are enabled
     */
    public function isAdminNotificationEnabled()
    {
        return Setting::get('suspension_notify_admins', true);
    }

    /**
     * Get admin email address
     */
    public function getAdminEmailAddress()
    {
        return Setting::get('email_admin_address', 'admin@stream2cash.com');
    }

    /**
     * Get email from name
     */
    public function getEmailFromName()
    {
        return Setting::get('email_from_name', 'Stream2Cash');
    }

    /**
     * Get site name
     */
    public function getSiteName()
    {
        return Setting::get('site_name', 'Stream2Cash');
    }

    /**
     * Get site description
     */
    public function getSiteDescription()
    {
        return Setting::get('site_description', 'Earn money by watching videos');
    }

    /**
     * Check if maintenance mode is enabled
     */
    public function isMaintenanceModeEnabled()
    {
        return Setting::get('maintenance_mode', false);
    }

    /**
     * Reset all settings to default values
     */
    public function resetToDefaults()
    {
        $defaults = [
            'video_allow_seeking' => '0',
            'video_allow_pausing' => '0',
            'video_min_watch_percentage' => '85',
            'video_heartbeat_interval' => '10',
            'video_countdown_duration' => '5',
            'anti_cheat_max_seek_count' => '3',
            'anti_cheat_max_pause_count' => '5',
            'anti_cheat_require_tab_visible' => '1',
            'anti_cheat_min_heartbeat_frequency' => '0.5',
            'suspension_autopilot_enabled' => '0',
            'suspension_auto_approve_threshold' => '90',
            'suspension_notify_admins' => '1',
            'email_admin_address' => 'admin@stream2cash.com',
            'email_from_name' => 'Stream2Cash',
            'site_name' => 'Stream2Cash',
            'site_description' => 'Earn money by watching videos',
            'maintenance_mode' => '0',
        ];

        foreach ($defaults as $key => $value) {
            Setting::set($key, $value);
        }

        return true;
    }
}
