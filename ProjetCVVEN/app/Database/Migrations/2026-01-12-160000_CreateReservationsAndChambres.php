<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservationsAndChambres extends Migration
{
    public function up()
    {
        // Table chambres
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'numero_chambre' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true,
            ],
            'prix_journalier' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'personne_max' => [
                'type' => 'INT',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'date_creation' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'date_modification' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('chambres');

        // Table reservations
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
            ],
            'num_chambre' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'date_debut' => [
                'type' => 'DATE',
            ],
            'date_fin' => [
                'type' => 'DATE',
            ],
            'prix' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'nb_personne' => [
                'type' => 'INT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('reservations');

        // Ajouter les clés étrangères
        $this->db->query('ALTER TABLE reservations ADD CONSTRAINT fk_reservations_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE reservations ADD CONSTRAINT fk_reservations_chambre FOREIGN KEY (num_chambre) REFERENCES chambres(numero_chambre) ON DELETE CASCADE');
    }

    public function down()
    {
        // Supprimer les clés étrangères
        $this->db->query('ALTER TABLE reservations DROP FOREIGN KEY fk_reservations_chambre');
        $this->db->query('ALTER TABLE reservations DROP FOREIGN KEY fk_reservations_user');

        $this->forge->dropTable('reservations');
        $this->forge->dropTable('chambres');
    }
}
