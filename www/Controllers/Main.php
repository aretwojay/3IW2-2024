<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User as U;

class Main
{

    public function home():void
    {        
        $unserializedUser = isset($_SESSION["user"]) ? unserialize($_SESSION["user"]) : null;
        // Si l'utilisateur est connecté, on récupère son pseudo et son email
        if ($unserializedUser instanceof U) {
            $pseudo = $unserializedUser->getFirstname();
            $email = $unserializedUser->getEmail();
        } else {
            $pseudo = "";
            $email = "";
        }
        $view = new View("Main/home.php");
        $view->addData("pseudo", $pseudo);
        $view->addData("email", $email);
        $view->addData("title", "Accueil");
        $view->addData("description", "Page d'accueil");
    }

}