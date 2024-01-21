<?php


namespace Libs\Database;

use PDOException;

class UsersTable 
{
    private $db = null;

    public function __construct(MySQL $mysql)
    {
       $this->db = $mysql->connect();
    }

    public function find($email, $password)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
            $statement->execute(['email' => $email, 'password' => $password]);
            $user = $statement->fetch();

            return $user ?? false;
        } catch(PDOException $e)
        {
            echo $e->getMessage();
            exit();
        }
    }

    public function insert($data)
    {
        try {
            $statement = $this->db->prepare(
                "INSERT INTO users (name, email, phone, address, password, created\_at) 
                VALUES (:name, :email, :phone, :address, :password, NOW())"
            );
            $statement->execute($data);

            return $this->db->lastInsertId();
        } catch(PDOException $e) {

            echo $e->getMessage();
            exit();
        }
    
    } 
    public function updatePhoto($id, $photo)
    {
        $statement = $this->db->prepare("UPDATE users SET photo=:photo WHERE id=:id");
        $statement->execute(['id' => $id , 'photo' => $photo]);

        return $statement->rowCount();
    }
}