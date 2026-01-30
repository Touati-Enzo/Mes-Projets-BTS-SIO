<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        helper(['form', 'url']);
    }

    public function login()
    {
        // Si déjà connecté, rediriger vers l'accueil
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Connexion'
        ];

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validation->getErrors());
        }

        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->verifyCredentials($username, $password);

        if ($user) {
            // Créer la session
            $sessionData = [
                'userId'    => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'role'      => $user['role'],
                'isLoggedIn' => true
            ];

            $this->session->set($sessionData);

            // Redirection vers l'accueil
            return redirect()->to('/');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Identifiants incorrects');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        // Si déjà connecté, rediriger vers l'accueil
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Inscription'
        ];

        return view('auth/register', $data);
    }

    public function attemptRegister()
    {
        $rules = [
            'username'  => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validation->getErrors());
        }

        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'first_name'    => $this->request->getPost('first_name') ?? '',
            'last_name'    => $this->request->getPost('last_name') ?? '',
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'user'
        ];

        if ($userModel->save($data)) {
            return redirect()->to('/login')
                ->with('success', 'Compte créé avec succès ! Veuillez vous connecter.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur s\'est produite lors de l\'inscription.');
        }
    }
}
