<?php

namespace App\Controllers;

use App\Models\ChambreModel;
use CodeIgniter\Controller;

class ChambreController extends Controller
{
    protected $session;
    protected $chambreModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->chambreModel = new ChambreModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Nos chambres',
            'chambres' => $this->chambreModel->findAll(),
            'user' => [
                'username' => $this->session->get('username'),
            ]
        ];

        return view('chambres/index', $data);
    }

    public function detail($id)
    {
        $chambre = $this->chambreModel->find($id);

        if (!$chambre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Chambre non trouvée');
        }

        $data = [
            'title' => 'Détails chambre',
            'chambre' => $chambre,
            'user' => [
                'username' => $this->session->get('username'),
            ]
        ];

        return view('chambres/detail', $data);
    }

    public function create()
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $data = [
            'title' => 'Créer une chambre',
            'user' => [
                'username' => $this->session->get('username'),
            ]
        ];

        return view('chambres/create', $data);
    }

    public function store()
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $rules = [
            'numero_chambre' => 'required|is_unique[chambres.numero_chambre]',
            'prix_journalier' => 'required|numeric',
            'personne_max' => 'required|integer|greater_than[0]',
            'description' => 'permit_empty|string'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'numero_chambre' => $this->request->getPost('numero_chambre'),
            'prix_journalier' => $this->request->getPost('prix_journalier'),
            'personne_max' => $this->request->getPost('personne_max'),
            'description' => $this->request->getPost('description') ?? ''
        ];

        if ($this->chambreModel->save($data)) {
            return redirect()->to('/chambres')
                ->with('success', 'Chambre créée avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la chambre');
        }
    }

    public function edit($id)
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $chambre = $this->chambreModel->find($id);

        if (!$chambre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Chambre non trouvée');
        }

        $data = [
            'title' => 'Modifier la chambre',
            'chambre' => $chambre,
            'user' => [
                'username' => $this->session->get('username'),
            ]
        ];

        return view('chambres/edit', $data);
    }

    public function update($id)
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $chambre = $this->chambreModel->find($id);

        if (!$chambre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Chambre non trouvée');
        }

        $rules = [
            'numero_chambre' => "required|is_unique[chambres.numero_chambre,id,{$id}]",
            'prix_journalier' => 'required|numeric',
            'personne_max' => 'required|integer|greater_than[0]',
            'description' => 'permit_empty|string'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', \Config\Services::validation()->getErrors());
        }

        $data = [
            'id' => $id,
            'numero_chambre' => $this->request->getPost('numero_chambre'),
            'prix_journalier' => $this->request->getPost('prix_journalier'),
            'personne_max' => $this->request->getPost('personne_max'),
            'description' => $this->request->getPost('description') ?? ''
        ];

        if ($this->chambreModel->save($data)) {
            return redirect()->to('/chambres')
                ->with('success', 'Chambre modifiée avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id)
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $chambre = $this->chambreModel->find($id);

        if (!$chambre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Chambre non trouvée');
        }

        if ($this->chambreModel->delete($id)) {
            return redirect()->to('/chambres')
                ->with('success', 'Chambre supprimée avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression');
        }
    }
}
