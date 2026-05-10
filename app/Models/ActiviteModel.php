<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table         = 'activites_sportives';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'nom', 'description', 'duree_minutes',
        'calories_heure', 'objectif', 'actif'
    ];
    protected $useTimestamps = false;

    // Récupère les activités sportives actives correspondant à un objectif
    public function getActivitesParObjectif(string $objectif): array
    {
        return $this->where('objectif', $objectif)
                    ->where('actif', 1)
                    ->findAll();
    }
}