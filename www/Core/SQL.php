<?php

namespace App\Core;

class SQL
{
    private $pdo;

    public function __construct(){
        try{
            $this->pdo = new \PDO("mysql:host=mariadb;dbname=esgi","esgi","esgipwd");
        }catch(\Exception $e){
            die("Erreur SQL ".$e->getMessage());
        }
    }

    public function getOneById(string $table, int $id): array
    {
        $queryPrepared = $this->pdo->prepare("SELECT * FROM ".$table." WHERE id= :id");
        $queryPrepared->execute([
            "id"=>$id
        ]);
        return $queryPrepared->fetch();
    }

    public function getOneByField(string $table, string $field, string $value): array{
        $queryPrepared = $this->pdo->prepare("SELECT * FROM ".$table." WHERE ".$field."= :value");
        $queryPrepared->execute([
            "value"=>$value
        ]);
        if ($queryPrepared->rowCount() === 0){
            return [];
        }
        return $queryPrepared->fetch();
    }

    public function insert(string $table, array $data): bool{

        $fields = array_keys($data);
        $fieldsString = implode(", ",$fields);
        $valuesString = ":".implode(", :",$fields);
        $query = $this->pdo->prepare("INSERT INTO $table ($fieldsString) VALUES ($valuesString)");

        foreach ($data as $key => $value){
            $query->bindValue(":".$key, $value);
        }
        //var_dump($query);
        //die();
        $result = $query->execute();
        return $result;
    }

}