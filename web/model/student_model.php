<?php

class student_model 
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function getBenutzerId($benutzername) 
    {
        $statement = $this->dbh->prepare(
            "SELECT benutzer_id 
            FROM benutzer 
            WHERE benutzername = ?");

        $statement->bind_param('s', $benutzername);
        $statement->execute();
        $statement->bind_result($benutzer_id);
        while ($statement->fetch()) 
        {
            return $benutzer_id;
        }
    }

    public function getUniID($benutzer_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT uni_id
            FROM student 
            WHERE benutzer_id = ?");

        $statement->bind_param('i', $benutzer_id);
        $statement->execute();
        $statement->bind_result($uni_id);
        while ($statement->fetch()) 
        {
            return $uni_id;
        }
    }

    public function insertStudent($last_id, $uni, $stadt) 
    {
        $statement = $this->dbh->prepare("INSERT INTO student (benutzer_id, uni_id, stadt_id) 
        VALUES (?,?,?)");
        $statement->bind_param('iii', $last_id, $uni, $stadt);
        $statement->execute();
    }
}
