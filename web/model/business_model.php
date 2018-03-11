<?php

class business_model 
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

    public function insertBusiness($last_id, $kreditkarte, $kreditkartenNr, $stadt) 
    {
        $statement = $this->dbh->prepare("INSERT INTO business (benutzer_id, kreditkarte, kreditkartenNr, stadt_id) 
        VALUES (?,?,?)");
        $statement->bind_param('iii', $last_id, $kreditkarte, $kreditkartenNr, $stadt);
        $statement->execute();
    }
}
