<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Si l'utilisateur n'est pas connecté, rediriger vers login
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Accueil',
            'user' => [
                'userId' => $this->session->get('userId'),
                'username' => $this->session->get('username'),
                'email' => $this->session->get('email'),
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name'),
                'role' => $this->session->get('role')
            ]
        ];

        return view('home', $data);
    }
}
