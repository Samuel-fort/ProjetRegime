<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class WalletController extends Controller
{
    public function validerCode()
    {
        $session = session();
        
        // Vérifier que l'utilisateur est connecté
        if (!$session->get('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Non authentifié']);
        }

        $code = $this->request->getPost('code');
        // Traitement atomique pour éviter les réutilisations concurrentes
        $db = \Config\Database::connect();

        // Démarrer une transaction
        $db->transStart();

        // Lire le code non utilisé
        $codeRow = $db->table('codes_wallet')
            ->where('code', $code)
            ->where('is_used', 0)
            ->get()
            ->getRowArray();

        if (! $codeRow) {
            $db->transComplete();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Code invalide ou déjà utilisé']);
        }

        // Marquer comme utilisé de façon conditionnelle (optimistic update)
        $updated = $db->table('codes_wallet')
            ->where('id', $codeRow['id'])
            ->where('is_used', 0)
            ->update(['is_used' => 1, 'used_by' => $session->get('user_id'), 'used_at' => date('Y-m-d H:i:s')]);

        // Vérifier que l'update a bien affecté une ligne
        if ($db->affectedRows() === 0) {
            $db->transComplete();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Code déjà utilisé']);
        }

        // Crédite le wallet de l'utilisateur
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));
        $nouveauSolde = ($user['wallet'] ?? 0) + $codeRow['montant'];
        $userModel->update($session->get('user_id'), ['wallet' => $nouveauSolde]);

        // Terminer la transaction
        $db->transComplete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Code validé !',
            'solde'   => $nouveauSolde,
            'montant' => $codeRow['montant']
        ]);
    }

    // Voir le solde
    public function solde()
    {
        $session = session();
        if (!$session->get('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Non authentifié']);
        }
        
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));
        
        return $this->response->setJSON([
            'status' => 'success',
            'solde'  => $user['wallet']
        ]);
    }

    // Afficher la page de test
    public function test()
    {
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to('/login');
        }
        
        return view('wallet/test');
    }

    // Afficher la vraie page du portefeuille
    public function index()
    {
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        return view('wallet/index', ['user_solde' => $user['wallet']]);
    }
}