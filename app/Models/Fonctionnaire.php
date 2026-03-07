<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fonctionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'cin',
        'nom_complet',
        'poste',
        'contact',
        'email',
        'etablissement',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean'
    ];

    public function historique(): HasMany
    {
        return $this->hasMany(HistoriquePersonnel::class);
    }
}