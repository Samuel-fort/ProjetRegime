<?php

namespace App\Controllers;

<<<<<<< HEAD
use App\Models\RegimeModel;
use App\Models\ActiviteModel;
=======
use App\Models\ActiviteModel;
use App\Models\RegimeModel;
>>>>>>> correction
use App\Models\UserModel;

class Objectif extends BaseController
{
<<<<<<< HEAD
    // Affiche et traite le choix d'objectif (3 options)
    public function choisir()
    {
        $userId = session()->get('user_id');
        if (! $userId) return redirect()->to(base_url('login'));
=======
    // Affiche et traite le choix de l'objectif de l'utilisateur
    public function choisir()
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return redirect()->to(base_url('login'));
        }
>>>>>>> correction

        $userModel = new UserModel();
        $user = $userModel->find($userId);

<<<<<<< HEAD
        $current = $user['objectif'] ?? null;

        if ($this->request->getMethod() === 'post') {
            $val = $this->request->getPost('objectif');
            $allowed = ['augmenter', 'reduire', 'imc_ideal'];

            if (! in_array($val, $allowed)) {
=======
        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        if ($this->request->getMethod() === 'post') {
            $objectif = (string) $this->request->getPost('objectif');
            $allowed = ['augmenter', 'reduire', 'imc_ideal'];

            if (! in_array($objectif, $allowed, true)) {
>>>>>>> correction
                session()->setFlashdata('error', "Valeur d'objectif invalide.");
                return redirect()->back();
            }

<<<<<<< HEAD
            // Sauvegarde en BDD
            $userModel->update($userId, ['objectif' => $val]);

            // Mise à jour session (clé explicite pour l'interface utilisateur)
            session()->set('user_objectif', $val);
=======
            // Sauvegarde du choix en base et en session
            $userModel->update($userId, ['objectif' => $objectif]);
            session()->set('user_objectif', $objectif);
>>>>>>> correction

            return redirect()->to(base_url('objectif/suggestions'));
        }

<<<<<<< HEAD
        return view('objectif/choisir', ['current' => $current]);
    }

    // Affiche les suggestions (régimes + activités) selon l'objectif de l'utilisateur
    public function suggestions()
    {
        $userId = session()->get('user_id');
        if (! $userId) return redirect()->to(base_url('login'));
=======
        return view('objectif/choisir', [
            'current' => $user['objectif'] ?? session()->get('user_objectif'),
        ]);
    }

    // Affiche les suggestions de régimes et d'activités selon l'objectif
    public function suggestions()
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return redirect()->to(base_url('login'));
        }
>>>>>>> correction

        $userModel = new UserModel();
        $user = $userModel->find($userId);

<<<<<<< HEAD
        $objectif = $user['objectif'] ?? session()->get('user_objectif');
        if (! $objectif) {
=======
        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        $objectif = (string) ($user['objectif'] ?? session()->get('user_objectif') ?? '');
        if ($objectif === '') {
>>>>>>> correction
            return redirect()->to(base_url('objectif/choisir'));
        }

        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteModel();

<<<<<<< HEAD
        $regimes = $regimeModel->getRegimesParObjectif((string) $objectif);
        $activites = $activiteModel->getActivitesParObjectif((string) $objectif);

        return view('objectif/suggestions', [
            'objectif' => $objectif,
            'regimes'  => $regimes,
=======
        $regimes = $regimeModel->getRegimesParObjectif($objectif);
        $activites = $activiteModel->getActivitesParObjectif($objectif);

        return view('objectif/suggestions', [
            'objectif' => $objectif,
            'regimes' => $regimes,
>>>>>>> correction
            'activites' => $activites,
        ]);
    }
}
