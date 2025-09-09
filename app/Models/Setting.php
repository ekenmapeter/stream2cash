<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'options',
        'is_public',
        'is_editable',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_public' => 'boolean',
        'is_editable' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $cacheKey = "setting.{$key}";

        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return static::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value by key
     */
    public static function set($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );

        // Clear cache
        Cache::forget("setting.{$key}");

        return $setting;
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        return static::where('group', $group)
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => static::castValue($setting->value, $setting->type)];
            });
    }

    /**
     * Get all public settings
     */
    public static function getPublic()
    {
        return static::where('is_public', true)
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => static::castValue($setting->value, $setting->type)];
            });
    }

    /**
     * Get all editable settings
     */
    public static function getEditable()
    {
        return static::where('is_editable', true)
            ->orderBy('group')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'decimal':
            case 'float':
                return (float) $value;
            case 'json':
            case 'array':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting.{$setting->key}");
        }
    }

    /**
     * Scope for settings by group
     */
    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope for public settings
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for editable settings
     */
    public function scopeEditable($query)
    {
        return $query->where('is_editable', true);
    }
}
