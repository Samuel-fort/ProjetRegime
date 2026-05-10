<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\RegimePrixModel;
use App\Models\ActiviteModel;
use App\Models\CodeWalletModel;
use CodeIgniter\Controller;

class AdminController extends Controller
{
    // ─── DASHBOARD ───────────────────────────────────────────
    public function dashboard()
    {
        $data = [
            'nb_regimes'   => (new RegimeModel())->countAll(),
            'nb_activites' => (new ActiviteModel())->countAll(),
            'nb_codes'     => (new CodeWalletModel())->countAll(),
            'nb_codes_used'=> (new CodeWalletModel())->where('is_used', 1)->countAllResults(),
        ];
        return view('admin/dashboard', $data);
    }

    // ─── CRUD RÉGIMES ────────────────────────────────────────
    public function regimes()
    {
        $regimeModel = new RegimeModel();
        $prixModel   = new RegimePrixModel();
        $regimes     = $regimeModel->findAll();

        foreach ($regimes as &$r) {
            $r['prix'] = $prixModel->where('regime_id', $r['id'])->findAll();
        }

        return view('admin/regimes/index', ['regimes' => $regimes]);
    }

    public function regimeCreate()
    {
        return view('admin/regimes/form', ['regime' => null, 'prix' => null]);
    }

    public function regimeStore()
    {
        $regimeModel = new RegimeModel();
        $prixModel   = new RegimePrixModel();
        $errors      = [];

        $nom    = $this->request->getPost('nom');
        $objectif = $this->request->getPost('objectif');

        if (empty($nom))     $errors[] = "Le nom est obligatoire.";
        if (empty($objectif)) $errors[] = "L'objectif est obligatoire.";

        if (!empty($errors)) {
            return view('admin/regimes/form', ['regime' => null, 'prix' => null, 'errors' => $errors]);
        }

        $id = $regimeModel->insert([
            'nom'             => $nom,
            'description'     => $this->request->getPost('description'),
            'pct_viande'      => $this->request->getPost('pct_viande')   ?? 0,
            'pct_poisson'     => $this->request->getPost('pct_poisson')  ?? 0,
            'pct_volaille'    => $this->request->getPost('pct_volaille') ?? 0,
            'variation_poids' => $this->request->getPost('variation_poids') ?? 0,
            'objectif'        => $objectif,
            'actif'           => $this->request->getPost('actif') ? 1 : 0,
        ]);

        // Sauvegarder les prix
        foreach ([30, 60, 90] as $duree) {
            $prix = $this->request->getPost('prix_' . $duree);
            if (!empty($prix)) {
                $prixModel->insert([
                    'regime_id'   => $id,
                    'duree_jours' => $duree,
                    'prix'        => $prix,
                ]);
            }
        }

        session()->setFlashdata('success', 'Régime créé avec succès.');
        return redirect()->to(base_url('admin/regimes'));
    }

    public function regimeEdit($id)
    {
        $regimeModel = new RegimeModel();
        $prixModel   = new RegimePrixModel();

        $regime = $regimeModel->find($id);
        if (!$regime) return redirect()->to(base_url('admin/regimes'));

        $prix = [];
        foreach ($prixModel->where('regime_id', $id)->findAll() as $p) {
            $prix[$p['duree_jours']] = $p['prix'];
        }

        return view('admin/regimes/form', ['regime' => $regime, 'prix' => $prix]);
    }

    public function regimeUpdate($id)
    {
        $regimeModel = new RegimeModel();
        $prixModel   = new RegimePrixModel();

        $regimeModel->update($id, [
            'nom'             => $this->request->getPost('nom'),
            'description'     => $this->request->getPost('description'),
            'pct_viande'      => $this->request->getPost('pct_viande')   ?? 0,
            'pct_poisson'     => $this->request->getPost('pct_poisson')  ?? 0,
            'pct_volaille'    => $this->request->getPost('pct_volaille') ?? 0,
            'variation_poids' => $this->request->getPost('variation_poids') ?? 0,
            'objectif'        => $this->request->getPost('objectif'),
            'actif'           => $this->request->getPost('actif') ? 1 : 0,
        ]);

        // Mettre à jour les prix
        foreach ([30, 60, 90] as $duree) {
            $prix     = $this->request->getPost('prix_' . $duree);
            $existing = $prixModel->where('regime_id', $id)->where('duree_jours', $duree)->first();

            if ($existing) {
                $prixModel->update($existing['id'], ['prix' => $prix]);
            } else if (!empty($prix)) {
                $prixModel->insert(['regime_id' => $id, 'duree_jours' => $duree, 'prix' => $prix]);
            }
        }

        session()->setFlashdata('success', 'Régime modifié avec succès.');
        return redirect()->to(base_url('admin/regimes'));
    }

    public function regimeDelete($id)
    {
        (new RegimeModel())->delete($id);
        session()->setFlashdata('success', 'Régime supprimé.');
        return redirect()->to(base_url('admin/regimes'));
    }

    // ─── CRUD ACTIVITÉS ──────────────────────────────────────
    public function activites()
    {
        $activites = (new ActiviteModel())->findAll();
        return view('admin/activites/index', ['activites' => $activites]);
    }

    public function activiteCreate()
    {
        return view('admin/activites/form', ['activite' => null]);
    }

    public function activiteStore()
    {
        $model  = new ActiviteModel();
        $errors = [];

        if (empty($this->request->getPost('nom')))
            $errors[] = "Le nom est obligatoire.";

        if (!empty($errors)) {
            return view('admin/activites/form', ['activite' => null, 'errors' => $errors]);
        }

        $model->insert([
            'nom'            => $this->request->getPost('nom'),
            'description'    => $this->request->getPost('description'),
            'duree_minutes'  => $this->request->getPost('duree_minutes'),
            'calories_heure' => $this->request->getPost('calories_heure'),
            'objectif'       => $this->request->getPost('objectif'),
            'actif'          => $this->request->getPost('actif') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Activité créée avec succès.');
        return redirect()->to(base_url('admin/activites'));
    }

    public function activiteEdit($id)
    {
        $activite = (new ActiviteModel())->find($id);
        if (!$activite) return redirect()->to(base_url('admin/activites'));
        return view('admin/activites/form', ['activite' => $activite]);
    }

    public function activiteUpdate($id)
    {
        (new ActiviteModel())->update($id, [
            'nom'            => $this->request->getPost('nom'),
            'description'    => $this->request->getPost('description'),
            'duree_minutes'  => $this->request->getPost('duree_minutes'),
            'calories_heure' => $this->request->getPost('calories_heure'),
            'objectif'       => $this->request->getPost('objectif'),
            'actif'          => $this->request->getPost('actif') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Activité modifiée avec succès.');
        return redirect()->to(base_url('admin/activites'));
    }

    public function activiteDelete($id)
    {
        (new ActiviteModel())->delete($id);
        session()->setFlashdata('success', 'Activité supprimée.');
        return redirect()->to(base_url('admin/activites'));
    }

    // ─── CODES WALLET ────────────────────────────────────────
    public function codes()
    {
        $codes = (new CodeWalletModel())->findAll();
        return view('admin/codes/index', ['codes' => $codes]);
    }

    public function codeCreate()
    {
        return view('admin/codes/form');
    }

    public function codeStore()
    {
        $model  = new CodeWalletModel();
        $errors = [];

        $code    = strtoupper(trim($this->request->getPost('code')));
        $montant = $this->request->getPost('montant');

        if (empty($code))    $errors[] = "Le code est obligatoire.";
        if (empty($montant)) $errors[] = "Le montant est obligatoire.";
        if ($model->where('code', $code)->first()) $errors[] = "Ce code existe déjà.";

        if (!empty($errors)) {
            return view('admin/codes/form', ['errors' => $errors]);
        }

        $model->insert(['code' => $code, 'montant' => $montant, 'is_used' => 0]);

        session()->setFlashdata('success', 'Code créé avec succès.');
        return redirect()->to(base_url('admin/codes'));
    }

    public function codeDelete($id)
    {
        (new CodeWalletModel())->delete($id);
        session()->setFlashdata('success', 'Code supprimé.');
        return redirect()->to(base_url('admin/codes'));
    }
}