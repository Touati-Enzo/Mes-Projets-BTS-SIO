<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ProfileController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $data = [
            'title' => 'Mon profil',
            'user' => [
                'userId' => $this->session->get('userId'),
                'username' => $this->session->get('username'),
                'email' => $this->session->get('email'),
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name'),
            ]
        ];

        return view('profile/index', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'Paramètres',
            'user' => [
                'username' => $this->session->get('username'),
            ]
        ];

        return view('profile/settings', $data);
    }
}
