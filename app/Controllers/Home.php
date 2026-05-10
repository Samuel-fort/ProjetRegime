<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Vérifier que l'utilisateur est connecté
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        return view('dashboard');
    }
}
