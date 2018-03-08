<?php

class uni_model 
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function getBezeichnung($uni_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT unibezeichnung 
            FROM uni 
            WHERE uni_id = ?");

        $statement->bind_param('s', $uni_id);
        $statement->execute();
        $statement->bind_result($unibezeichnung);
        while ($statement->fetch()) 
        {
            return $unibezeichnung;
        }
    }

    public function getUniId($unibezeichnung) 
    {
        $statement = $this->dbh->prepare(
            "SELECT uni_id 
            FROM uni 
            WHERE unibezeichnung = ?");

        $statement->bind_Param('s', $unibezeichnung);
        $statement->execute();        
        $statement->bind_result($uni_id);
        while ($statement->fetch()) 
        {
            return $uni_id;
        }
    }

    public function getUniStadtId($uni_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT stadt_id 
            FROM uni 
            WHERE stadt_id = ?");

        $statement->bind_Param('i', $uni_id);
        $statement->execute();        
        $statement->bind_result($stadt_id);
        while ($statement->fetch())
        {
            return $stadt_id;
        }
    }

    public function getUniStadt($uni_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT stadtbezeichnung 
            FROM stadt, uni 
            WHERE uni.stadt_id = stadt.stadt_id AND uni.uni_id = ?");

        $statement->bind_Param('i', $uni_id);
        $statement->execute();        
        $statement->bind_result($stadtbezeichnung);
        while ($statement->fetch())
        {
            return $stadtbezeichnung;
        }
    }

    public function getAllUni($uni_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT uni_id, unibezeichunung 
            FROM uni 
            WHERE uni.stadt_id = stadt.stadt_id AND uni.uni_id = ?");

        $statement->bind_Param('i', $uni_id);
        $statement->execute();        
        $statement->bind_result($stadtbezeichnung);
        while ($statement->fetch())
        {
            return $stadtbezeichnung;
        }
    }


}
