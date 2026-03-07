<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'page_name',
        'page_url',
        'visited_at',
        'time_spent',
        'ip_address',
        'user_agent',
        'session_id'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'time_spent' => 'integer'
    ];

    /**
     * Relation avec l'admin
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope pour les visites récentes
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('visited_at', '>=', now()->subDays($days));
    }

    /**
     * Scope pour un admin spécifique
     */
    public function scopeByAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    /**
     * Scope pour une période spécifique
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('visited_at', [$startDate, $endDate]);
    }

    /**
     * Scope pour les pages populaires
     */
    public function scopePopularPages($query, $limit = 10)
    {
        return $query->select('page_name')
            ->selectRaw('COUNT(*) as visit_count')
            ->groupBy('page_name')
            ->orderBy('visit_count', 'DESC')
            ->limit($limit);
    }

    /**
     * Calculer le temps moyen passé sur le site
     */
    public static function getAverageTimeSpent()
    {
        return self::avg('time_spent');
    }

    /**
     * Obtenir les statistiques de visite par admin
     */
    public static function getVisitsByAdmin()
    {
        return self::select('admin_id')
            ->selectRaw('COUNT(*) as total_visits')
            ->selectRaw('AVG(time_spent) as average_time')
            ->with('admin')
            ->groupBy('admin_id')
            ->get();
    }
}