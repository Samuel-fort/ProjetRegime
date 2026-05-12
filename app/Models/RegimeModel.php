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

    // Récupère les régimes avec tous les prix disponibles par durée
    public function getRegimesAvecPrixParObjectif(string $objectif): array
    {
        $regimes = $this->db->table('regimes')
            ->where('objectif', $objectif)
            ->where('actif', 1)
            ->orderBy('nom', 'ASC')
            ->get()
            ->getResultArray();

        if ($regimes === []) {
            return [];
        }

        $regimeIds = array_map(static fn (array $regime): int => (int) $regime['id'], $regimes);

        $prixRows = $this->db->table('regime_prix')
            ->select('regime_id, duree_jours, prix')
            ->whereIn('regime_id', $regimeIds)
            ->orderBy('duree_jours', 'ASC')
            ->get()
            ->getResultArray();

        $prixParRegime = [];
        foreach ($prixRows as $row) {
            $regimeId = (int) $row['regime_id'];
            $duree = (int) $row['duree_jours'];
            $prixParRegime[$regimeId][$duree] = (float) $row['prix'];
        }

        foreach ($regimes as &$regime) {
            $regimeId = (int) $regime['id'];
            $regime['prix_par_duree'] = $prixParRegime[$regimeId] ?? [];
            $regime['prix_min'] = $regime['prix_par_duree'] !== []
                ? min($regime['prix_par_duree'])
                : null;
        }
        unset($regime);

        return $regimes;
    }
}