<?php
class UserValidator{

    private $fields = ['firstname', 'lastname', 'email', 'password', 'passwordConfirm'];
    private $errors = [];
    private $data = [];

    public function __construct(array $post) {
        $this->data = $post;
    }

    public function validateField($field): void {
        if (!isset($this->data[$field])) {
            $this->errors[$field] = 'Le champ ' . $field . ' est obligatoire';
        }
    }

    public function checkLength($field, $min, $max): void {
        if (strlen($this->data[$field]) < $min) {
            $this->errors[$field] = 'Le champ ' . $field . ' doit faire au moins ' . $min . ' caractères';
        }
        if (strlen($this->data[$field]) > $max) {
            $this->errors[$field] = 'Le champ ' . $field . ' doit faire au maximum ' . $max . ' caractères';
        }
    }

    public function validateName($field): void {
        $this->checkLength($field, 2, 50);
    }

    public function validateEmail($field): void {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Le champ ' . $field . ' doit être un email';
        }
        $this->checkLength($field, 6, 50);
    }

    public function validatePassword($field): void {
        $this->checkLength($field, 8, 255);
    }

    public function validatePasswordConfirm($field): void {
        $this->checkLength($field, 8, 255);
        if ($this->data[$field] !== $this->data['password']) {
            $this->errors[$field] = 'Le champ ' . $field . ' doit être identique au mot de passe';
        }
    }

    public function validate() {
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