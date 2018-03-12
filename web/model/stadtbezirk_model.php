<?php

class stadtbezirk_model 
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function getAllBezirk($stadt_id) 
    {
        $statement = $this->dbh->prepare(
            "SELECT stadtbezirk_id, bezirkbezeichnung 
            FROM stadtbezirk 
            WHERE stadt_id = ?
            ORDER BY bezirkbezeichnung");

        $statement->bind_param('i', $stadt_id);
        $statement->execute();
        return $statement;
    }
}
