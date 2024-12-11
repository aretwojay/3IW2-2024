<?php

namespace App\Controllers;

class UserValidator{

    private $labels = [
        'firstname' => 'prénom',
        'lastname' => 'nom',
        'email' => 'email',
        'password' => 'mot de passe',
        'passwordConfirm' => 'confirmation de mot de passe'
    ];
    private $fields = [];
    private $errors = [];
    private $data = [];

    public function __construct(array $post) {
        $this->data = $post;
        // On récupère les clés du tableau $labels, qui correspondent aux champs du formulaire
        $this->fields = array_keys($this->labels);
    }

    // Fonctions de validation communes

    public function validateField(string $field): void {
        if (!isset($this->data[$field])) {
            $this->errors[$field] = 'Le champ ' . $this->labels[$field] . ' est obligatoire';
        }
    }

    public function checkLength(string $field, int $min, int $max): void {
        if (strlen($this->data[$field]) < $min) {
            $this->errors[$field] = 'Le champ ' . $this->labels[$field] . ' doit faire au moins ' . $min . ' caractères';
        }
        if (strlen($this->data[$field]) > $max) {
            $this->errors[$field] = 'Le champ ' . $this->labels[$field] . ' doit faire au maximum ' . $max . ' caractères';
        }
    }

    // Fonctions de validation spécifiques

    public function validateName(string $field): void {
        $this->checkLength($field, 2, 50);
    }

    public function validateEmail(string $field): void {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Le champ ' . $this->labels[$field] . ' doit être un email';
        }
        $this->checkLength($field, 6, 50);
    }

    public function validatePassword(string $field): void {
        $this->checkLength($field, 8, 255);
    }

    public function validatePasswordConfirm(string $field): void {
        $this->checkLength($field, 8, 255);
        // On vérifie que le champ passwordConfirm est identique au champ password
        if ($this->data[$field] !== $this->data['password']) {
            $this->errors[$field] = 'Le champ ' . $this->labels[$field] . ' doit être identique au mot de passe';
        }
    }

    // Fonction de validation principale

    public function validate(): array {
        foreach ($this->fields as $field) {
            $this->validateField($field);
        }
        $this->validateName('firstname');
        $this->validateName('lastname');
        $this->validateEmail('email');
        $this->validatePassword('password');
        $this->validatePasswordConfirm('passwordConfirm');

        return $this->errors;
    }
    
}