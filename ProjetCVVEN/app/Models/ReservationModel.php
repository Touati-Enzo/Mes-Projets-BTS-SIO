<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'num_chambre', 'date_debut', 'date_fin', 'prix', 'nb_personne'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getReservationsUtilisateur($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('date_debut', 'DESC')
            ->findAll();
    }

    public function getReservationAvecChambre($reservationId)
    {
        return $this->select('reservations.*, chambres.numero_chambre, chambres.prix_journalier, chambres.personne_max')
            ->join('chambres', 'reservations.num_chambre = chambres.numero_chambre')
            ->where('reservations.id', $reservationId)
            ->first();
    }

    public function verifierDisponibilite($numChambre, $dateDebut, $dateFin)
    {
        return $this->where('num_chambre', $numChambre)
            ->where('date_debut <=', $dateFin)
            ->where('date_fin >=', $dateDebut)
            ->countAllResults() === 0;
    }

    public function calculerPrix($numChambre, $dateDebut, $dateFin)
    {
        $chambreModel = new ChambreModel();
        $chambre = $chambreModel->getChambreByNumero($numChambre);

        if (!$chambre) {
            return 0;
        }

        $debut = new \DateTime($dateDebut);
        $fin = new \DateTime($dateFin);
        $interval = $debut->diff($fin);
        $jours = $interval->days;

        return $chambre['prix_journalier'] * $jours;
    }
}
