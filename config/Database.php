<?php
namespace Config;
use PDOException;
use PDO;

class Database
{
    //connnection to database
    private $host = "localhost";
    private $dbname = "api_rest";
    private $dbpass = "";
    private $dbuser = "root";
    public $connexion ;

    //we ceate now a getter to the connection

    public function getConnection()
    {
        $this->connexion = null;

        try
        {
            $this->connexion = new PDO("mysql:host=" .$this->host. ";dbname=" .$this->dbname , $this->dbuser, $this->dbpass);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->exec("set names utf8");
        } 
        catch(PDOException $e)
        {
            die("Erreur : ".$e->getMessage());
        }
        //we return the connection

        return $this->connexion;

    }


}