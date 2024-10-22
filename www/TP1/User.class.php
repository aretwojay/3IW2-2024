<?php
session_start();
require_once 'Sqlite.class.php';
class User{

    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $db;

    public function __construct($firstname, $lastname, $email, $password) {
        $this->firstname = $this->setFirstname($firstname);
        $this->lastname = $this->setLastname($lastname);
        $this->email = $this->setEmail($email);
        $this->password = $this->setPassword($password);
        $this->db = new Sqlite();
    }

    //Getters

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    //Setters
    public function setFirstname($firstname) {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    public function setLastname($lastname) {
        $this->lastname = strtoupper(trim($lastname));
    }

    public function setEmail($email) {
        $this->email = strtolower(trim($email));
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function register() {
        $newUser = new User($this->firstname, $this->lastname, $this->email, $this->password);

        $result = $this->db->createUser($newUser->getFirstname(), $newUser->getLastname(), $newUser->getEmail(), $newUser->getPassword());
        if ($result) {
            $_SESSION['user'] = $newUser;
            return true;
        }
        return false;
    }

    public function login(String $email, String $password): bool {
        $user = $this->db->getUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }


}
