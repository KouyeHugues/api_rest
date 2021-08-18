<?php
namespace App\Models;

class Section
{
    //connection
    private $table = "section";
    private $connexion;

    //object properties
    public $id;
    public $domain;
    public $length; 
    public $width;
    public $addedAt;
    public $updatedAt;

    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * We will create function read which allow us to have all data on our database
     */

    public function read()
    {
        //fist of all we will write the  request 
        $sql = "SELECT * FROM {$this->table} ORDER BY addedAt DESC LIMIT 0,10";

        //we prepare the request 
        $query = $this->connexion->prepare($sql);

        //we execute the request
        $query->execute(); 

        //we return the result

        return $query;

    }

    /**
     * We will now cereate a function which will allow us to add a new data our database
     */

     public function create()
     {
        //we will write our request
        $sql = "INSERT INTO {$this->table} SET domaine = :domaine, length = :length , width = :width, addedAt = :addedAt";
        
        //we prepare our request
        $query = $this->connexion->prepare($sql);

        //Protection of our data
        $this->domain = htmlspecialchars(strip_tags($this->domain));
        $this->length = htmlspecialchars(strip_tags($this->length));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->addedAt = htmlspecialchars(strip_tags($this->addedAt));

        //we add our protected data
        $query->blindParam(":domain", $this->domain);
        $query->blindParam(":length", $this->length);
        $query->blindParam(":width", $this->width);
        $query->blindParam(":addedAt", $this->addedAt);

        //Excecution of request
        if($query->execute())
        {
            return true;
        }
        return false;

     }

     /**
      * read one section
      */
     public function findby()
     {
         //we write the request
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";

         //preparation of request
        $query = $this->connexion->prepare($sql);

         //we add the preotected data
        $query->blindParam(1, $this->id);

         //we exceute the request 
        $query->execute();

        //we get a section row
        $sectionrow = $query->fetch(PDO::FETCH_ASSOC);

         //we hydrate the object
        $this->domain =$sectionrow["domain"];
        $this->length =$sectionrow["length"];
        $this->width =$sectionrow["width"];
        $this->addedAt =$sectionrow["addedAt"];

     }

     /**
      * We delete a section
      */
     public function delete()
     {
         //request
         $sql = "DELETE FROM {$this->table} WHERE id = ?";

         //preaparation of request
         $query = $this->connexion->prepare($sql);

         //protection of request
         $this->id = htmlspecialchars(strip_tags($this->id));

         //we add our protected data
         $query->blindParam(1, $this->id);

         //Execution of the request
         if($query->execute())
         {
             return true;
         }
         return false;
        
     }

    /**
     * we creata function that will update our sections
     */
    public function update()
    {
        //request 
        $sql = "UPDATE {$this->table} SET domain = :domain, length = :length, width = :width, addedAt = :addedAt";

        //we prepare our request
        $query = $this->connexion->prepare($sql);

        //Protection of our data
        $this->domain = htmlspecialchars(strip_tags($this->domain));
        $this->length = htmlspecialchars(strip_tags($this->length));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->addedAt = htmlspecialchars(strip_tags($this->addedAt));

        //we add our protected data
        $query->blindParam(":domain", $this->domain);
        $query->blindParam(":length", $this->length);
        $query->blindParam(":width", $this->width);
        $query->blindParam(":addedAt", $this->addedAt);

        //Excecution of request
        if($query->execute())
        {
            return true;
        }
        return false;

    }

}