<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    // Affiche et traite le formulaire de modification du profil utilisateur
    public function modifier()
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

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'nom' => 'required|min_length[2]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
                'taille' => 'required|numeric|greater_than[0]',
                'poids' => 'required|numeric|greater_than[0]',
            ];

            if (! $this->validate($rules)) {
                return view('profil/modifier', [
                    'user'   => $user,
                    'errors' => $this->validator->getErrors(),
                ]);
            }

            $nom    = trim((string) $this->request->getPost('nom'));
            $email  = trim((string) $this->request->getPost('email'));
            $taille = (float) $this->request->getPost('taille');
            $poids  = (float) $this->request->getPost('poids');

            // Recalcul de l'IMC avant sauvegarde des nouvelles mesures
            $tailleMetre = $taille / 100;
            $imc = round($poids / ($tailleMetre * $tailleMetre), 2);

            $userModel->update($userId, [
                'nom'    => $nom,
                'email'  => $email,
                'taille' => $taille,
                'poids'  => $poids,
                'imc'    => $imc,
            ]);

            // Mise à jour de la session pour garder les données synchronisées
            session()->set([
                'user_nom'   => $nom,
                'user_email' => $email,
            ]);

            session()->setFlashdata('success', 'Profil mis à jour avec succès.');

            return redirect()->to(base_url('user/dashboard'));
        }

        return view('profil/modifier', [
            'user' => $user,
        ]);
    }
}
