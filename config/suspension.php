<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Suspension Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the suspension and anti-cheat system
    |
    */

    'autopilot' => [
        'enabled' => env('SUSPENSION_AUTOPILOT_ENABLED', false),
        'auto_approve_threshold' => [
            'min_watch_percentage' => 80,
            'max_watch_percentage' => 85,
            'max_seek_count' => 2,
            'max_pause_count' => 3,
            'require_tab_visible' => true,
        ],
    ],

    'validation_rules' => [
        'min_watch_percentage' => 85,
        'max_seek_count' => 3,
        'max_pause_count' => 5,
        'require_tab_visible' => true,
        'min_heartbeat_ratio' => 0.7,
    ],

    'email_notifications' => [
        'enabled' => env('SUSPENSION_EMAIL_NOTIFICATIONS', true),
        'admin_emails' => [
            // Add admin email addresses here
            // 'admin@stream2cash.com',
        ],
    ],
];
