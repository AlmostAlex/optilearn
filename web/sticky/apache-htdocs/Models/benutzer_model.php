<?php

class benutzer_model 
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $id, $benutzername, $name, $passwort, $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function LoginKontrolle($benutzername, $passwort) 
    {
        
        $statement = $this->dbh->prepare("SELECT passwort FROM benutzer WHERE benutzername = ?");
        $statement->bind_param('s', $benutzername);
        $statement->execute();
        $statement->bind_result($pw);
        while ($statement->fetch()) {
            $pw;
        }
        return ($pass_corr = password_verify($passwort, $pw));
    }

    public function getId($benutzername) 
    {
        $statement = $this->dbh->prepare("SELECT benutzer_id FROM benutzer WHERE benutzername = ?");
        $statement->bind_Param('s', $benutzername);
        $statement->execute();        
        $statement->bind_result($benutzer_id);
        while ($statement->fetch()) 
        {
            $benutzer_id;
        }
        return $benutzer_id;
    }

    public function getDozent($benutzer_id) 
    {
        $statement = $this->dbh->prepare("SELECT dozent FROM benutzer WHERE benutzer_id = ?");
        $statement->bind_Param('i', $benutzer_id);
        $statement->execute();        
        $statement->bind_result($dozent);
        while ($statement->fetch()) 
        {
            $dozent;
        }
        return $dozent;
    }

    public function getpasswort() 
    {
        return $this->passwort;
    }

}
