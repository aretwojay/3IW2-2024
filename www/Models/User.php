<?php

namespace App\Models;

use App\Core\SQL;

class User {

    private $firstname;
    private $lastname;
    private $email;
    private $password;

    public function __construct($firstname, $lastname, $email, $password) {
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setEmail($email);
        $this->setPassword($password);
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
}