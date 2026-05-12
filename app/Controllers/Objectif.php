<?php

namespace App\Controllers;

use App\Models\ActiviteModel;
use App\Models\ParametreModel;
use App\Models\RegimeModel;
use App\Models\UserModel;

class Objectif extends BaseController
{
    // Affiche et traite le choix de l'objectif de l'utilisateur
    public function choisir()
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return redirect()->to(base_url('login'));
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            $objectif = (string) $this->request->getPost('objectif');
            $allowed = ['augmenter', 'reduire', 'imc_ideal'];

            if (! in_array($objectif, $allowed, true)) {
                session()->setFlashdata('error', "Valeur d'objectif invalide.");
                return redirect()->back();
            }

            // Sauvegarde du choix en base et en session
            $userModel->update($userId, ['objectif' => $objectif]);
            session()->set('user_objectif', $objectif);

            return redirect()->to(base_url('objectif/suggestions'));
        }

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

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        $objectif = (string) ($user['objectif'] ?? session()->get('user_objectif') ?? '');
        if ($objectif === '') {
            return redirect()->to(base_url('objectif/choisir'));
        }

        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteModel();
        $parametreModel = new ParametreModel();
        $estGold = (int) ($user['is_gold'] ?? 0) === 1;
        $tauxRemiseGold = (float) ($parametreModel->getValeur('taux_remise_gold', '15') ?? '15');

        $regimes = $regimeModel->getRegimesAvecPrixParObjectif($objectif);
        foreach ($regimes as &$regime) {
            $offres = [];
            foreach (($regime['prix_par_duree'] ?? []) as $duree => $prixOriginal) {
                $prixOriginal = (float) $prixOriginal;
                $remiseGold = $estGold ? round($prixOriginal * $tauxRemiseGold / 100, 2) : 0.0;
                $offres[] = [
                    'duree_jours' => (int) $duree,
                    'prix_original' => $prixOriginal,
                    'remise_gold' => $remiseGold,
                    'prix_paye' => max(0, round($prixOriginal - $remiseGold, 2)),
                ];
            }

            $regime['offres'] = $offres;
        }
        unset($regime);

        $activites = $activiteModel->getActivitesParObjectif($objectif);

        return view('objectif/suggestions', [
            'objectif' => $objectif,
            'regimes' => $regimes,
            'activites' => $activites,
            'estGold' => $estGold,
            'tauxRemiseGold' => $tauxRemiseGold,
        ]);
    }

    // Achat d'un régime pour une durée donnée
    public function acheter($regimeId)
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return redirect()->to(base_url('login'));
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);
        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        $duree = (int) $this->request->getPost('duree_jours');
        $allowedDurees = [30, 60, 90];
        if (! in_array($duree, $allowedDurees, true)) {
            session()->setFlashdata('error', 'Durée invalide.');
            return redirect()->back();
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);
        if (! $regime || (int) ($regime['actif'] ?? 0) !== 1) {
            session()->setFlashdata('error', 'Régime introuvable ou inactif.');
            return redirect()->to(base_url('objectif/suggestions'));
        }

        $prixRow = $regimeModel->db->table('regime_prix')
            ->where('regime_id', $regimeId)
            ->where('duree_jours', $duree)
            ->get()
            ->getRowArray();

        if (! $prixRow) {
            session()->setFlashdata('error', 'Aucun prix disponible pour cette durée.');
            return redirect()->to(base_url('objectif/suggestions'));
        }

        $parametreModel = new ParametreModel();
        $tauxRemiseGold = (float) ($parametreModel->getValeur('taux_remise_gold', '15') ?? '15');
        $prixOriginal = (float) $prixRow['prix'];
        $remiseGold = ((int) ($user['is_gold'] ?? 0) === 1) ? round($prixOriginal * $tauxRemiseGold / 100, 2) : 0.0;
        $prixPaye = max(0, round($prixOriginal - $remiseGold, 2));
        $walletActuel = (float) ($user['wallet'] ?? 0);

        if ($walletActuel < $prixPaye) {
            session()->setFlashdata('error', 'Solde insuffisant pour acheter ce régime.');
            return redirect()->to(base_url('objectif/suggestions'));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $nouveauSolde = round($walletActuel - $prixPaye, 2);
        $userModel->update($userId, ['wallet' => $nouveauSolde]);

        $db->table('commandes')->insert([
            'user_id' => $userId,
            'regime_id' => (int) $regimeId,
            'duree_jours' => $duree,
            'prix_original' => $prixOriginal,
            'remise_gold' => $remiseGold,
            'prix_paye' => $prixPaye,
            'date_achat' => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        session()->setFlashdata('success', 'Régime acheté avec succès.');

        return redirect()->to(base_url('objectif/suggestions'));
    }

    // Exporte les suggestions utilisateur en PDF
    public function exportSuggestionsPdf()
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return redirect()->to(base_url('login'));
        }

        $dompdfClass = '\\Dompdf\\Dompdf';
        if (! class_exists($dompdfClass)) {
            return redirect()->back()->with('error', 'Le module PDF (dompdf) n\'est pas installé.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        $objectif = (string) ($user['objectif'] ?? session()->get('user_objectif') ?? '');
        if ($objectif === '') {
            return redirect()->to(base_url('objectif/choisir'));
        }

        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteModel();
        $regimes = $regimeModel->getRegimesParObjectif($objectif);
        $activites = $activiteModel->getActivitesParObjectif($objectif);

        $html = view('objectif/suggestions_pdf', [
            'objectif' => $objectif,
            'regimes' => $regimes,
            'activites' => $activites,
        ]);

        $dompdf = new $dompdfClass();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="suggestions-' . $objectif . '.pdf"')
            ->setBody($dompdf->output());
    }
}
