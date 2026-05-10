<?php

namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    // Affiche le tableau de bord de l'utilisateur connecté avec ses données fraîches
    public function index()
    {
        $userId = session()->get('user_id');

        if (! $userId) {
            return redirect()->to(base_url('login'));
        }

        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        $imc = (float) $user['imc'];
        if (empty($imc) && ! empty($user['taille']) && ! empty($user['poids'])) {
            $tailleMetre = $user['taille'] / 100;
            if ($tailleMetre > 0) {
                $imc = round($user['poids'] / ($tailleMetre * $tailleMetre), 2);
            }
        }

        $progression = min(100, max(0, ($imc / 40) * 100));

        return view('dashboard/index', [
            'user'        => $user,
            'imc'         => $imc,
            'categorie'   => $this->getCategorieImc($imc),
            'progression'  => $progression,
            'walletLabel'  => 'Ar',
        ]);
    }

    // Détermine l'interprétation textuelle de l'IMC
    private function getCategorieImc(float $imc): string
    {
        if ($imc < 18.5) {
            return 'Insuffisance pondérale';
        }

        if ($imc < 25) {
            return 'Poids normal';
        }

        if ($imc < 30) {
            return 'Surpoids';
        }

        return 'Obésité';
    }
}
