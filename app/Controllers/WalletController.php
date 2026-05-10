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
        
        // Vérifier le code dans la table codes_wallet
        $db = \Config\Database::connect();
        $codeData = $db->table('codes_wallet')
            ->where('code', $code)
            ->where('is_used', 0)
            ->get()
            ->getRowArray();

        if (!$codeData) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Code invalide ou déjà utilisé']);
        }

        // Ajouter le montant au wallet
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));
        $nouveauSolde = $user['wallet'] + $codeData['montant'];
        
        $userModel->update($session->get('user_id'), ['wallet' => $nouveauSolde]);

        // Marquer le code comme utilisé
        $db->table('codes_wallet')
            ->where('id', $codeData['id'])
            ->update(['is_used' => 1, 'used_by' => $session->get('user_id'), 'used_at' => date('Y-m-d H:i:s')]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Code validé !',
            'solde'   => $nouveauSolde,
            'montant' => $codeData['montant']
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