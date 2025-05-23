<?php

namespace  App\Models;

use  CodeIgniter\Model;

class UserModel extends Model {
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $table = 'Adherent';
    protected $primaryKey = 'idAdherent';
    protected $allowedFields = ['nom', 'prenom', 'identifiant','motDePasse', 'dateNaissance', 'dateAdhesion', 'photo'];
    
    public function findByLogin($login)
    {
        return $this->where('identifiant', $login)->first();
    }
    
}