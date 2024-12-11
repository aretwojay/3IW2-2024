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
        $view->addData("title", "Inscription");
        $view->addData("description", "Page d'inscription");
    }

    public function registerPost(): void
    {
        $validator = new UserValidator($_POST);

        $errors = $validator->validate();
        // Si il y a des erreurs, on les stocke dans la session et on redirige 
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /sinscrire");
            die();
        }
        // Si il n'y a pas d'erreurs, on tente de créer un nouvel utilisateur
        try {
            $newUser = $this->user->register(
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['password']
            );
            // Si l'utilisateur est bien créé, on redirige vers la page de connexion
            if ($newUser instanceof UserModel) {
                $_SESSION["errors"] = [];
                header("Location: /login");
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
        $view->addData("title", "Connexion");
        $view->addData("description", "Page de connexion");
        //echo $view;
    }

    public function loginPost(): void
    {
        // On tente de connecter l'utilisateur
        try {
            $isLogged = $this->user->login(
                $_POST['email'],
                $_POST['password']
            );
            // Si l'utilisateur est connecté, on le redirige vers la page d'accueil
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

