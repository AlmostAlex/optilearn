<?php

class benutzer_model 
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

    public function LoginKontrolle($benutzername, $passwort) 
    {
        $statement = $this->dbh->prepare("SELECT passwort FROM benutzer WHERE benutzername = ?");
        $statement->bind_param('s', $benutzername);
        $statement->execute();
        $statement->bind_result($pw);
        while ($statement->fetch())
        {
            return ($pass_corr = password_verify($passwort, $pw));
        }
    }

    public function duplikatBenutzer($benutzername)
    {
        if($statement = $this->dbh->prepare(
            "SELECT benutzername
            FROM benutzer
            WHERE benutzername = ?"))
        {
            $statement->bind_param('s', $benutzername);
            $statement->execute();
            return $statement;
        }
        else
        {
            return "leere DB";
        }
    }

    public function duplikatEmail($email)
    {
        if($statement = $this->dbh->prepare(
            "SELECT email
            FROM benutzer
            WHERE email = ?"))
        {
            $statement->bind_param('s', $email);
            $statement->execute();
            return $statement;
        }
        else
        {
            return "leere DB";
        }
    }

    public function insertBenutzer($benutzername, $passwort, $email, $nutzertyp, $vorname, $nachname) 
    {
        $statement = $this->dbh->prepare("INSERT INTO benutzer (benutzername, passwort, typ, vorname, nachname, email) 
        VALUES (?,?,?,?,?,?)");
        $statement->bind_param('ssisss', $benutzername, $passwort, $nutzertyp, $vorname, $nachname, $email);
        $statement->execute();
        $last_id = $this->dbh->insert_id;
        return $last_id;
    }
}
