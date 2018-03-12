<?php

class stadt_model 
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function getBezeichnung($stadt_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT stadtbezeichnung 
            FROM stadt 
            WHERE stadt_id = ?");

        $statement->bind_param('i', $stadt_id);
        $statement->execute();
        $statement->bind_result($stadtbezeichnung);
        while ($statement->fetch()) {
            return $stadtbezeichnung;
        }
    }

    public function getAllBezeichnung() 
    {
        $statement = $this->dbh->prepare(
            "SELECT stadtbezeichnung, stadt_id 
            FROM stadt
            ORDER BY stadtbezeichnung");
        $statement->execute();
        return $statement;
    }

    public function getStadtId($stadtbezeichnung) 
    {
        $statement = $this->dbh->prepare(
            "SELECT stadt_id 
            FROM stadt 
            WHERE stadtbezeichnung = ?");
            
        $statement->bind_Param('s', $stadtbezeichnung);
        $statement->execute();        
        $statement->bind_result($stadt_id);
        while ($statement->fetch()) 
        {
            return $stadt_id;
        }
    }
}
