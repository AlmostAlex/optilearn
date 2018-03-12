<?php

class lernumgebung_model 
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function getLernbezeichnung($lernumgebung_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT lernbezeichnung 
            FROM lernumgebung 
            WHERE lernumgebung_id = ?");

        $statement->bind_param('i', $lernumgebung_id);
        $statement->execute();
        $statement->bind_result($lernbezeichnung);
        while ($statement->fetch()) 
        {
            return $lernbezeichnung;
        }
    }

    public function getLernumgebungId($lernbezeichnung) 
    {
        $statement = $this->dbh->prepare(
            "SELECT lernumgebung_id 
            FROM lernumgebung 
            WHERE lernbezeichnung = ?");

        $statement->bind_Param('s', $lernbezeichnung);
        $statement->execute();        
        $statement->bind_result($lernumgebung_id);
        while ($statement->fetch()) 
        {
            return $lernumgebung_id;
        }
    }

    public function getAllLernumgebungFree() 
    {
        $statement = $this->dbh->prepare(
            "SELECT lernumgebung_id, lernbezeichnung, plaetze,lernart
            FROM lernumgebung
            WHERE typ = 3");
        $statement->execute();
	    return $statement;
    }

    public function getAllLernumgebungStudent($uni_id)
    {
        $statement = $this->dbh->prepare(
            "SELECT lernumgebung.lernumgebung_id, lernumgebung.lernbezeichnung, lernumgebung.plaetze, lernumgebung.lernart
            FROM lernumgebung, uniraum
            WHERE typ = 1 AND lernumgebung.lernumgebung_id = uniraum.lernumgebung_id AND uniraum.uni_id = ?");

        $statement->bind_param('i', $uni_id);
        $statement->execute();
	    return $statement;
    }

    public function getAllLernumgebungBusiness()
    {
        $statement = $this->dbh->prepare(
            "SELECT lernumgebung.lernumgebung_id, lernumgebung.lernbezeichnung, lernumgebung.plaetze, lernumgebung.lernart, businessraum.kosten_stunde
            FROM lernumgebung, businessraum
            WHERE typ = 2 AND lernumgebung.lernumgebung_id = businessraum.lernumgebung_id");

        $statement->execute();
	    return $statement;
    }

    public function getLernplätze($lernumgebung_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT plaetze 
            FROM lernumgebung 
            WHERE lernumgebung_id = ?");

        $statement->bind_Param('i', $lernumgebung_id);
        $statement->execute();        
        $statement->bind_result($plätze);
        while ($statement->fetch()) 
        {
            return $plätze;
        }
    }

    public function getLernart($lernumgebung_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT lernart
            FROM lernumgebung
            WHERE lernumgebung_id = ?");
            
        $statement->bind_Param('i', $lernumgebung_id);
        $statement->execute();
        $statement->bind_result($lernart);
        while ($statement->fetch())
        {
            return $lernart;
        }
    }

    public function getLernartStill($lernumgebung_id) 
    {
        $still = "still";
        $statement = $this->dbh->prepare(
            "SELECT lernart
            FROM lernumgebung
            WHERE lernart = ?");
            
        $statement->bind_Param('s', $still);
        $statement->execute();
        return $statement;
    }

}
