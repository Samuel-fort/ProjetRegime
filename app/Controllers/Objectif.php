<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\ActiviteModel;
use App\Models\UserModel;

class Objectif extends BaseController
{
    // Affiche et traite le choix d'objectif (3 options)
    public function choisir()
    {
        $userId = session()->get('user_id');
        if (! $userId) return redirect()->to(base_url('login'));

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $current = $user['objectif'] ?? null;

        if ($this->request->getMethod() === 'post') {
            $val = $this->request->getPost('objectif');
            $allowed = ['augmenter', 'reduire', 'imc_ideal'];

            if (! in_array($val, $allowed)) {
                session()->setFlashdata('error', "Valeur d'objectif invalide.");
                return redirect()->back();
            }

            // Sauvegarde en BDD
            $userModel->update($userId, ['objectif' => $val]);

            // Mise à jour session (clé explicite pour l'interface utilisateur)
            session()->set('user_objectif', $val);

            return redirect()->to(base_url('objectif/suggestions'));
        }

        return view('objectif/choisir', ['current' => $current]);
    }

    // Affiche les suggestions (régimes + activités) selon l'objectif de l'utilisateur
    public function suggestions()
    {
        $userId = session()->get('user_id');
        if (! $userId) return redirect()->to(base_url('login'));

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $objectif = $user['objectif'] ?? session()->get('user_objectif');
        if (! $objectif) {
            return redirect()->to(base_url('objectif/choisir'));
        }

        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteModel();

        $regimes = $regimeModel->getRegimesParObjectif((string) $objectif);
        $activites = $activiteModel->getActivitesParObjectif((string) $objectif);

        return view('objectif/suggestions', [
            'objectif' => $objectif,
            'regimes'  => $regimes,
            'activites' => $activites,
        ]);
    }
}
