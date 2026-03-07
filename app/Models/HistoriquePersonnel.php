<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriquePersonnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'fonctionnaire_id',
        'evenement',
        'details',
        'date_evenement'
    ];

    protected $casts = [
        'date_evenement' => 'date'
    ];

    public function fonctionnaire(): BelongsTo
    {
        return $this->belongsTo(Fonctionnaire::class);
    }
}