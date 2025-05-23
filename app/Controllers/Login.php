<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Database;

class Login extends Controller
{
    public function index(): string
    {
        return view('Login');
    }

    public function Profil(): string
    {
        return view('Profil');
    }

    public function invite(): string 
    {
        return view('Invite');
    }

    public function Create(): string
    {
        return view('Create');
    }

        public function account()
        {
            $pswd = $this->request->getPost('pass');
    
            // Preparation des données
            $data = [
                'eMail' => $this->request->getPost('mail'),
                'motDePasse' => $pswd,
                'nom' => $this->request->getPost('nom'),
                'prenom' => $this->request->getPost('prenom'),
                'dateNaissance' => $this->request->getPost('age'),
                'dateAdhesion' => date('Y-m-d'),
            ];
        
            // Enregistrement et redirection
            $userModel = new \App\Models\UserModel();
            if ($userModel->save($data)) {
                return redirect()->to('')->with('success', 'User registered successfully.');
            } else {
            }
        }


    public function authenticate()
    {
        
        

        $login = $this->request->getPost('identifier');
        $password = $this->request->getPost('password');

        // Verification des parametres
       
        $userModel = new UserModel();
        $user = $userModel->findByLogin($login);

        // Get the database connection
        $db = \Config\Database::connect();

        $sql = "SELECT dbo.VerifLoginPassword(:identifiant:, :motDePasse:) AS estValide";
        
        // Execute the query
        $query = $db->query($sql, [
            'identifiant' => $login,
            'motDePasse' => $password,
        ]);
        // Fetch the result
        $result = $query->getRow();

        if ($result->estValide) {
            session()->set([
                'user_id' => $user['idAdherent'],
                'id' => $user['identifiant'],
                'is_logged_in' => true,
            ]);
       

        
            return redirect()->to('/Profil')->with('success', 'Logged in successfully.');
        }


        return redirect()->to('/');
    }

    public function Logout()
    {
        session()->destroy();

        return redirect()->to('')->with('success', 'Logged out successfully.');
    }
}
