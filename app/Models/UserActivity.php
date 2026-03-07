<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'activity_type',
        'description',
        'ip_address',
        'user_agent',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime'
    ];

    /**
     * Relation avec l'admin
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Types d'activités disponibles
     */
    const TYPE_LOGIN = 'login';
    const TYPE_LOGOUT = 'logout';
    const TYPE_PAGE_VISIT = 'page_visit';
    const TYPE_EXPORT = 'export';
    const TYPE_IMPORT = 'import';
    const TYPE_CREATE = 'create';
    const TYPE_UPDATE = 'update';
    const TYPE_DELETE = 'delete';

    /**
     * Scope pour un type d'activité spécifique
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope pour les activités récentes
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Enregistrer une nouvelle activité
     */
    public static function logActivity($adminId, $activityType, $description, $metadata = [])
    {
        return self::create([
            'admin_id' => $adminId,
            'activity_type' => $activityType,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => $metadata
        ]);
    }
}