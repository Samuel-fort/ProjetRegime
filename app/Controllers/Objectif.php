<?php

namespace App\Controllers;

use App\Models\ActiviteModel;
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

        $regimes = $regimeModel->getRegimesParObjectif($objectif);
        $activites = $activiteModel->getActivitesParObjectif($objectif);

        return view('objectif/suggestions', [
            'objectif' => $objectif,
            'regimes' => $regimes,
            'activites' => $activites,
        ]);
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
