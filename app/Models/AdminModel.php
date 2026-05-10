<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table      = 'admins';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email', 'mot_de_passe'
    ];

    protected $useTimestamps = false;
}