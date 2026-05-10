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

    // Récupère les régimes actifs pour un objectif donné en retournant le prix minimum par régime
    public function getRegimesParObjectif(string $objectif): array
    {
        return $this->db->table('regimes r')
            ->select('r.*, MIN(rp.prix) as prix_min')
            ->join('regime_prix rp', 'rp.regime_id = r.id')
            ->where('r.objectif', $objectif)
            ->where('r.actif', 1)
            ->groupBy('r.id')
            ->get()
            ->getResultArray();
    }
}