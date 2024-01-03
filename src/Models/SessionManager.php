<?php

namespace Bluteki\Ussd\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property string $session_id
 * @property string $msisdn
 * @property Collection $data
 * @property Collection $menus
 * @property Collection $recorder
 * @property int $navigation_tracker
 */
class SessionManager extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_id',
        'msisdn',
        'data',
        'menus',
        'navigation_tracker'
    ];

    /**
     * Get request data.
     * 
     * @return Attribute
     */
    public function data(): Attribute
    {
        return Attribute::make(
            get: fn ($val) => collect(json_decode($val, true) ?? []),
            set: fn ($val) => json_encode(static::is_array($val) ? $val : [])
        );
    }

    /**
     * Get request data.
     * 
     * @return Attribute
     */
    public function menus(): Attribute
    {
        return Attribute::make(
            get: fn ($val) => collect(json_decode($val, true) ?? []),
            set: fn ($val) => json_encode(static::is_array($val) ? $val : [])
        );
    }

    /**
     * Check if value is valid array.
     * 
     * @param mixed val
     * @return bool
     */
    private static function is_array($val): bool
    {
        return is_array($val) || $val instanceof Collection ? true : false;
    }
}