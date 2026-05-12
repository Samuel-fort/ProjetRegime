<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table         = 'parametres';
    protected $primaryKey    = 'cle';
    protected $allowedFields = ['cle', 'valeur'];
    protected $useTimestamps = false;

    public function getValeur(string $cle, ?string $default = null): ?string
    {
        $row = $this->find($cle);

        if (! is_array($row) || ! isset($row['valeur'])) {
            return $default;
        }

        return (string) $row['valeur'];
    }
}