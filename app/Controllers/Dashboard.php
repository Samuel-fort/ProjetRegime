<?php

namespace App\Controllers;

use App\Models\CommandeModel;
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
        $commandeActuelle = (new CommandeModel())
            ->select('commandes.*, regimes.nom AS regime_nom, regimes.description AS regime_description')
            ->join('regimes', 'regimes.id = commandes.regime_id', 'left')
            ->where('commandes.user_id', $userId)
            ->orderBy('commandes.date_achat', 'DESC')
            ->first();

        $dateFinRegime = null;
        $joursRestants = null;
        if (is_array($commandeActuelle) && ! empty($commandeActuelle['date_achat']) && ! empty($commandeActuelle['duree_jours'])) {
            $dateAchat = new \DateTimeImmutable((string) $commandeActuelle['date_achat']);
            $dateFinRegime = $dateAchat->modify('+' . ((int) $commandeActuelle['duree_jours']) . ' days');
            $maintenant = new \DateTimeImmutable('now');
            if ($dateFinRegime > $maintenant) {
                $joursRestants = (int) $maintenant->diff($dateFinRegime)->format('%a');
            } else {
                $joursRestants = 0;
            }
        }

        return view('dashboard/index', [
            'user' => $user,
            'imc' => $imc,
            'categorie' => $this->getCategorieImc($imc),
            'progression' => $progression,
            'walletLabel' => 'Ar',
            'commandeActuelle' => $commandeActuelle,
            'dateFinRegime' => $dateFinRegime,
            'joursRestants' => $joursRestants,
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
