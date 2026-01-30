<?php

namespace App\Models;

use CodeIgniter\Model;

class ChambreModel extends Model
{
    protected $table = 'chambres';
    protected $primaryKey = 'id';
    protected $allowedFields = ['numero_chambre', 'prix_journalier', 'personne_max', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'date_creation';
    protected $updatedField = 'date_modification';

    public function getChambreByNumero($numero)
    {
        return $this->where('numero_chambre', $numero)->first();
    }

    public function getChambresDisponibles($dateDebut, $dateFin)
    {
        // Récupère toutes les chambres qui ne sont pas réservées sur cette période
        // Détecte les chevauchements de dates
        $chambreOccupees = $this->db->table('reservations')
            ->where('date_debut <=', $dateFin)
            ->where('date_fin >=', $dateDebut)
            ->select('num_chambre')
            ->get()
            ->getResultArray();

        // Récupère les numéros des chambres occupées
        $numerosOccupes = array_column($chambreOccupees, 'num_chambre');

        if (empty($numerosOccupes)) {
            // Aucune chambre occupée, retourner toutes les chambres
            return $this->findAll();
        }

        // Retourner les chambres qui ne sont pas occupées
        return $this->whereNotIn('numero_chambre', $numerosOccupes)->findAll();
    }
}
