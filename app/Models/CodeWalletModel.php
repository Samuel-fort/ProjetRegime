<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeWalletModel extends Model
{
    protected $table         = 'codes_wallet';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['code', 'montant', 'is_used', 'used_by', 'used_at'];
    protected $useTimestamps = false;
}