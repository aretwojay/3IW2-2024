<?php

namespace App\Core;
use App\Core\SQL;
use App\Models\User as U;
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

        // Vérification si l'email est déjà utilisé
        $findUser = $this->db->getOneByField("user", "email", $email);

        // Si l'email est déjà utilisé, on retourne une exception
        if ($findUser) {
            return new Exception("Email déjà utilisé");
        }

        // Création d'un nouvel utilisateur à partir du constructeur de la classe User
        // Les données sont nettoyées et formatées dans le constructeur
        $newUser = new U(
            $firstname,
            $lastname,
            $email,
            $password
        );

        // Insertion en base de données de l'utilisateur, si l'insertion échoue, on retourne une exception
        $result = $this->db->insert("user", [
            "firstname" => $newUser->getFirstname(),
            "lastname" => $newUser->getLastname(),
            "email" => $newUser->getEmail(),
            "password" => $newUser->getPassword()
        ]);
        if ($result) {
            $user = new U(
                $firstname,
                $lastname,
                $email,
                $password
            );
            return $user;
        }
        return new Exception("Erreur lors de l'inscription");
    }

    public function login(string $email, string $password): bool {
        $user = $this->db->getOneByField("user", "email", $email);

        if ($user && password_verify($password, $user['password'])) {
            $this->setSessionUser(new U(
                $user['firstname'],
                $user['lastname'],
                $user['email'],
                $user['password']
            ));
            return true;
        }
        
        return false;
    }

    public function isLogged():bool
    {
        if (isset($_SESSION['user'])) {
            return unserialize($_SESSION['user']) instanceof U;
        }
        return false;
    }

    public function setSessionUser(U $user):void
    {
        $_SESSION['user'] = serialize($user);
    }

    public function logout():void
    {
        session_destroy();
    }
        

}