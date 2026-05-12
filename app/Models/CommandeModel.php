<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table         = 'commandes';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id', 'regime_id', 'duree_jours',
        'prix_original', 'remise_gold', 'prix_paye', 'date_achat'
    ];
    protected $useTimestamps = false;
}