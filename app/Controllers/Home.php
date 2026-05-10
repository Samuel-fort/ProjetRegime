<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        // Rediriger l'affichage vers la nouvelle vue structurée du tableau de bord
        return view('dashboard/index');
    }
}
