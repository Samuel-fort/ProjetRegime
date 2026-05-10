<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table         = 'regimes';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'nom', 'description', 'pct_viande', 'pct_poisson',
        'pct_volaille', 'variation_poids', 'objectif', 'actif'
    ];
    protected $useTimestamps = false;
}