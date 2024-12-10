<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User as U;

class Main
{

    public function home():void
    {
        $pseudo = isset($_SESSION["user"]) ? $_SESSION["user"]["firstname"] : "";
        $email = isset($_SESSION["user"]) ? $_SESSION["user"]["email"] : "";
        $view = new View("Main/home.php");
        $view->addData("pseudo", $pseudo);
        $view->addData("email", $email);
    }

}