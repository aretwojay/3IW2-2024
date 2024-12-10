<?php

namespace App\Core;
use App\Core\SQL;
use App\Models\User as U;
use Error;
use Exception;

class User
{

    private $db;

    public function __construct(){
        $this->db = new SQL();
    }

    public function register(
        string $firstname,
        string $lastname,
        string $email,
        string $password
    ): U | Exception {

        $user = $this->db->getOneByField("user", "email", $email);

        if ($user) {
            return new Exception("Email déjà utilisé");
        }

        $result = $this->db->insert("user", [
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "password" => $password
        ]);
        if ($result) {
            $user = new U(
                $firstname,
                $lastname,
                $email,
                $password
            );
            $this->setSessionUser($user);
            return $user;
        }
        return new Exception("Erreur lors de l'inscription");
    }

    public function login(string $email, string $password): bool {
        $user = $this->db->getOneByField("user", "email", $email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }

    public function isLogged():bool
    {
        return isset($_SESSION['user']);
    }

    public function setSessionUser(U $user):void
    {
        $_SESSION['user'] = $user;
    }

    public function logout():void
    {
        session_destroy();
    }
        

}