<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    public function getBenutzerTyp($benutzer_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT typ 
            FROM benutzer 
            WHERE benutzer_id = ?");

        $statement->bind_param('i', $benutzer_id);
        $statement->execute();
        $statement->bind_result($typ);
        while ($statement->fetch()) 
        {
            return $typ;
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
            $statement->bind_result($benutzernameDB);
            while($statement->fetch())
            {
                return $benutzernameDB;
            }
        }
        else
        {
            return "keinDuplikat";
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
            $statement->bind_result($emailDB);
            while($statement->fetch())
            {
                return $emailDB;
            }
        }
        else
        {
            return "keinDUplikat";
        }
    }

    public function insertBenutzer($benutzername, $passwort, $email, $nutzertyp, $vorname, $nachname) 
    {
        $statement = $this->dbh->prepare(
            "INSERT INTO benutzer (benutzername, passwort, email, typ, vorname, nachname) 
            VALUES (?,?,?,?,?,?)");

            $statement->bind_param('sssiss', $benutzername, $passwort, $email, $nutzertyp, $vorname, $nachname);
            $statement->execute();
        $last_id = $this->dbh->insert_id;
        return $last_id;
    }
}
