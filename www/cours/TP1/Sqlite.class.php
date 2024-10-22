<?php

class Sqlite{

    private SQLite3 $db;

    public function __construct() {
        $this->db = new SQLite3('db.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $this->db->enableExceptions(true);
        $this->setupDatabase();
    }

    private function setupDatabase() {
        $this->db->query('CREATE TABLE IF NOT EXISTS "user" (
            "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "firstname" VARCHAR(50),
            "lastname" VARCHAR(50),
            "email" VARCHAR(50),
            "password" VARCHAR(255)
        )');  
    }

    protected function getDb(): SQLite3 {
        return $this->db;
    }

    public function getUsers(): array {
        $query = $this->db->query('SELECT * FROM user');
        $users = [];
        while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUserByEmail(String $email) {
        $query = $this->db->prepare('SELECT * FROM user WHERE email = :email');
        $query->bindValue(':email', $email, SQLITE3_TEXT);
        $result = $query->execute();
        return array_shift($result->fetchArray(SQLITE3_ASSOC));
    }

    public function createUser(String $firstname, String $lastname, String $email, String $hashedPassword) {
        $query = $this->db->prepare('INSERT INTO user (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)');
        $query->bindValue(':firstname', $firstname, SQLITE3_TEXT);
        $query->bindValue(':lastname', $lastname, SQLITE3_TEXT);
        $query->bindValue(':email', $email, SQLITE3_TEXT);
        $query->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
        $result = $query->execute();
        return $result->finalize();
    }

}