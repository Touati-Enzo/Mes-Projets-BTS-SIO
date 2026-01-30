<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        // Vérifier si l'utilisateur est connecté
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Tableau de bord',
            'user'  => [
                'username' => $this->session->get('username'),
                'email'    => $this->session->get('email'),
                'role'     => $this->session->get('role')
            ]
        ];

        return view('dashboard/index', $data);
    }
}
