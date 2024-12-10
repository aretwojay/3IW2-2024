<?php
namespace App\Controllers;

use App\Core\User as U;
use App\Core\SQL;
use App\Core\View;
use App\Controllers\UserValidator;
use App\Models\User as UserModel;


class User
{
    private $user;

    public function __construct()
    {
        $this->user = new U();
    }

    public function register(): void
    {
        $view = new View("User/register.php", "front.php");
    }

    public function registerPost(): void
    {
        $validator = new UserValidator($_POST);

        $errors = $validator->validate();
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /sinscrire");
            die();
        }
        try {
            $newUser = $this->user->register(
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['password']
            );
            if ($newUser instanceof UserModel) {
                $_SESSION["errors"] = [];
                header("Location: /");
            } else if ($newUser instanceof \Exception) {
                $_SESSION["errors"] = [$newUser->getMessage()];
                header("Location: /sinscrire");
            }
        }
        catch (\Exception $e) {
            echo '<pre>' . $e->getMessage() . '</pre>';
            $_SESSION["errors"] = ["Erreur lors de l'inscription"];
            //header("Location: /sinscrire");
        }
    }

    public function login(): void
    {
        $view = new View("User/login.php", "front.php");
        //echo $view;
    }

    public function loginPost(): void
    {
        try {
            $isLogged = $this->user->login(
                $_POST['email'],
                $_POST['password']
            );
            if ($isLogged)  {
                header("Location: /");
            } else {
                $_SESSION["errors"] = ["Identifiants incorrects"];
                header("Location: /login");
            }
        }
        catch (\Exception $e) {
            $_SESSION["errors"] = ["Erreur lors de la connexion"];
            header("Location: /login");
        }
    }


    public function logout(): void
    {
        $this->user->logout();
        header("Location: /");
    }



}

