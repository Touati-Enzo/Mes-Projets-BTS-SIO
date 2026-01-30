<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\ChambreModel;
use CodeIgniter\Controller;

class ReservationController extends Controller
{
    protected $session;
    protected $reservationModel;
    protected $chambreModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->reservationModel = new ReservationModel();
        $this->chambreModel = new ChambreModel();
    }

    public function index()
    {
        $userId = $this->session->get('userId');
        $reservations = $this->reservationModel->getReservationsUtilisateur($userId);

        $data = [
            'title' => 'Mes réservations',
            'reservations' => $reservations,
            'user' => [
                'username' => $this->session->get('username'),
                'email' => $this->session->get('email'),
            ]
        ];

        return view('reservations/index', $data);
    }

    public function create()
    {
        $chambres = $this->chambreModel->findAll();

        $data = [
            'title' => 'Nouvelle réservation',
            'chambres' => $chambres,
            'user' => [
                'username' => $this->session->get('username'),
            ]
        ];

        return view('reservations/create', $data);
    }

    public function store()
    {
        $rules = [
            'num_chambre' => 'required',
            'date_debut' => 'required|valid_date[Y-m-d]',
            'date_fin' => 'required|valid_date[Y-m-d]',
            'nb_personne' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', \Config\Services::validation()->getErrors());
        }

        $numChambre = $this->request->getPost('num_chambre');
        $dateDebut = $this->request->getPost('date_debut');
        $dateFin = $this->request->getPost('date_fin');
        $nbPersonne = $this->request->getPost('nb_personne');

        // Vérifier la disponibilité
        if (!$this->reservationModel->verifierDisponibilite($numChambre, $dateDebut, $dateFin)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette chambre n\'est pas disponible sur cette période');
        }

        // Vérifier le nombre de personnes
        $chambre = $this->chambreModel->getChambreByNumero($numChambre);
        if ($nbPersonne > $chambre['personne_max']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le nombre de personnes dépasse la capacité de la chambre');
        }

        // Calculer le prix
        $prix = $this->reservationModel->calculerPrix($numChambre, $dateDebut, $dateFin);

        $data = [
            'user_id' => $this->session->get('userId'),
            'num_chambre' => $numChambre,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'prix' => $prix,
            'nb_personne' => $nbPersonne
        ];

        if ($this->reservationModel->save($data)) {
            return redirect()->to('/reservations')
                ->with('success', 'Réservation créée avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la réservation');
        }
    }

    public function detail($id)
    {
        $userId = $this->session->get('userId');
        $reservation = $this->reservationModel->find($id);

        if (!$reservation || $reservation['user_id'] != $userId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Réservation non trouvée');
        }

        $chambre = $this->chambreModel->getChambreByNumero($reservation['num_chambre']);

        $data = [
            'title' => 'Détails réservation',
            'reservation' => $reservation,
            'chambre' => $chambre,
            'user' => [
                'username' => $this->session->get('username'),
            ]
        ];

        return view('reservations/detail', $data);
    }

    public function cancel($id)
    {
        $userId = $this->session->get('userId');
        $reservation = $this->reservationModel->find($id);

        if (!$reservation || $reservation['user_id'] != $userId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Réservation non trouvée');
        }

        if ($this->reservationModel->delete($id)) {
            return redirect()->to('/reservations')
                ->with('success', 'Réservation annulée avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'annulation');
        }
    }

    public function adminReservations()
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $reservations = $this->reservationModel->getToutesReservations();
        $chambres = $this->chambreModel->findAll();

        $data = [
            'title' => 'Gestion des réservations',
            'reservations' => $reservations,
            'chambres' => $chambres,
            'user' => [
                'username' => $this->session->get('username'),
                'role' => $this->session->get('role')
            ]
        ];

        return view('reservations/admin', $data);
    }

    public function updateStatut($id)
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $statut = $this->request->getPost('statut');
        $validStatuts = ['en_attente', 'confirmee', 'annulee'];

        if (!in_array($statut, $validStatuts)) {
            return redirect()->back()
                ->with('error', 'Statut invalide');
        }

        $reservation = $this->reservationModel->find($id);
        if (!$reservation) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Réservation non trouvée');
        }

        if ($this->reservationModel->update($id, ['statut' => $statut])) {
            return redirect()->back()
                ->with('success', 'Statut de la réservation mis à jour avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour');
        }
    }

    public function adminDelete($id)
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $reservation = $this->reservationModel->find($id);
        if (!$reservation) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Réservation non trouvée');
        }

        if ($this->reservationModel->delete($id)) {
            return redirect()->to('/reservations/admin')
                ->with('success', 'Réservation supprimée avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression');
        }
    }

    public function quickUpdate($id)
    {
        // Vérifier que l'utilisateur est admin
        if ($this->session->get('role') !== 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Accès non autorisé');
        }

        $reservation = $this->reservationModel->find($id);
        if (!$reservation) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Réservation non trouvée');
        }

        $num_chambre = $this->request->getPost('num_chambre');
        $date_debut = $this->request->getPost('date_debut');
        $date_fin = $this->request->getPost('date_fin');
        $nb_personne = $this->request->getPost('nb_personne');
        $prix = $this->request->getPost('prix');

        // Vérifier que la chambre existe
        $chambre = $this->chambreModel->where('numero_chambre', $num_chambre)->first();
        if (!$chambre) {
            return redirect()->back()
                ->with('error', 'Chambre invalide');
        }

        $data = [
            'num_chambre' => $num_chambre,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'nb_personne' => $nb_personne,
            'prix' => $prix,
        ];

        if ($this->reservationModel->update($id, $data)) {
            return redirect()->back()
                ->with('success', 'Réservation mise à jour avec succès !');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour');
        }
    }
}
