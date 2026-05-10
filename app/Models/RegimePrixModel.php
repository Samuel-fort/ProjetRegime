<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimePrixModel extends Model
{
    protected $table         = 'regime_prix';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['regime_id', 'duree_jours', 'prix'];
    protected $useTimestamps = false;
}