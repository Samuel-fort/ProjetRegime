<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    // Étape 1 : afficher le formulaire d'inscription (nom, mail, mdp, genre)
    public function register()
    {
        return view('auth/register_step1');
    }

    // Étape 1 : traiter le formulaire et passer à l'étape 2
    public function registerStep1Post()
    {
        $session = session();

        $nom      = $this->request->getPost('nom');
        $email    = $this->request->getPost('email');
        $mdp      = $this->request->getPost('mot_de_passe');
        $mdp2     = $this->request->getPost('mot_de_passe_confirm');
        $genre    = $this->request->getPost('genre');

        // Validations simples
        $errors = [];

        if (empty($nom))   $errors[] = "Le nom est obligatoire.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = "Email invalide.";
        if (empty($mdp) || strlen($mdp) < 6)
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
        if ($mdp !== $mdp2)
            $errors[] = "Les mots de passe ne correspondent pas.";
        if (!in_array($genre, ['homme', 'femme']))
            $errors[] = "Le genre est obligatoire.";

        // Vérifier si l'email existe déjà
        $userModel = new UserModel();
        if ($userModel->where('email', $email)->first()) {
            $errors[] = "Cet email est déjà utilisé.";
        }

        if (!empty($errors)) {
            return view('auth/register_step1', ['errors' => $errors, 'old' => $_POST]);
        }

        // Stocker en session pour l'étape 2
        $session->set('register_step1', [
            'nom'          => $nom,
            'email'        => $email,
            'mot_de_passe' => $mdp,
            'genre'        => $genre,
        ]);

        return redirect()->to('/register/step2');
    }

    // Étape 2 : afficher le formulaire taille/poids
    public function registerStep2()
    {
        $session = session();

        // Si l'étape 1 n'a pas été faite, rediriger
        if (!$session->get('register_step1')) {
            return redirect()->to('/register');
        }

        return view('auth/register_step2');
    }

    // Étape 2 : traiter et créer le compte
    public function registerStep2Post()
    {
        $session = session();
        $step1   = $session->get('register_step1');

        if (!$step1) {
            return redirect()->to('/register');
        }

        $taille = $this->request->getPost('taille'); // en cm
        $poids  = $this->request->getPost('poids');  // en kg

        $errors = [];

        if (empty($taille) || !is_numeric($taille) || $taille < 50 || $taille > 250)
            $errors[] = "Taille invalide (entre 50 et 250 cm).";
        if (empty($poids) || !is_numeric($poids) || $poids < 10 || $poids > 300)
            $errors[] = "Poids invalide (entre 10 et 300 kg).";

        if (!empty($errors)) {
            return view('auth/register_step2', ['errors' => $errors, 'old' => $_POST]);
        }

        // Calculer l'IMC
        $tailleM = $taille / 100;
        $imc     = round($poids / ($tailleM * $tailleM), 2);

        // Créer l'utilisateur
        $userModel = new UserModel();
        $userModel->insert([
            'nom'          => $step1['nom'],
            'email'        => $step1['email'],
            'mot_de_passe' => password_hash($step1['mot_de_passe'], PASSWORD_BCRYPT),
            'genre'        => $step1['genre'],
            'taille'       => $taille,
            'poids'        => $poids,
            'imc'          => $imc,
            'wallet'       => 0,
            'is_gold'      => 0,
        ]);

        // Nettoyer la session
        $session->remove('register_step1');
        $session->setFlashdata('success', 'Compte créé avec succès ! Vous pouvez vous connecter.');

        return redirect()->to('/login');
    }
}