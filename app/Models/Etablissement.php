<?php
// app/Models/Etablissement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    protected $fillable = [
        'code_etab',
        'secteur',
        'cisco',
        'commune',
        'zap',
        'fokontany',
        'nom_etab',
        'latitude',
        'longitude',
        'nb_ENF',
        'nb_Ens_foncts',
        'nb_PA_NonFonct',
        'nb_PA_Fonct',
        'nb_Benevols',
        'effectif_total_Personnels'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'nb_ENF' => 'integer',
        'nb_Ens_foncts' => 'integer',
        'nb_PA_NonFonct' => 'integer',
        'nb_PA_Fonct' => 'integer',
        'nb_Benevols' => 'integer',
        'effectif_total_Personnels' => 'integer'
    ];

    // Scopes pour les requêtes courantes
    public function scopePublic($query)
    {
        return $query->where('secteur', 'Publique');
    }

    public function scopePrive($query)
    {
        return $query->where('secteur', 'Privée');
    }

    public function scopeByCisco($query, $cisco)
    {
        return $query->where('cisco', $cisco);
    }

    public function scopeByCommune($query, $commune)
    {
        return $query->where('commune', $commune);
    }

    // Calcul du ratio élèves/enseignant
    public function getRatioElevesEnseignantAttribute()
    {
        $totalEnseignants = $this->nb_Ens_foncts + $this->nb_PA_NonFonct + $this->nb_PA_Fonct;
        return $totalEnseignants > 0 ? $this->nb_ENF / $totalEnseignants : 0;
    }
}