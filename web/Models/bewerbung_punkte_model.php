<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class bewerbung_punkte_model
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function insertBewerbungPunkte($studiengang_punkte, $fachsemester_punkte, $credit_anzahl_punkte, $seminar_teilnahme_punkte, $gesamt_punkte, $last_id) 
    {
        $statement = $this->dbh->prepare("INSERT INTO bewerbung_punkte (bewerbung_id, studiengang_punkte, fachsemester_punkte, credit_anzahl_punkte, seminar_teilnahme_punkte, gesamt_punkte) 
        VALUES (?,?,?,?,?,?)");
        $error = $this->dbh->errno . ' ' . $this->dbh->error;
        echo $error;
        $statement->bind_param('iiiiii', $last_id, $studiengang_punkte, $fachsemester_punkte, $credit_anzahl_punkte, $seminar_teilnahme_punkte, $gesamt_punkte);
        $statement->execute();
    }    

    public function updateBewerbungPunkte($studiengang_punkte, $fachsemester_punkte, $credit_anzahl_punkte, $seminar_teilnahme_punkte, $gesamt_punkte, $last_id) 
    {
        $statement = $this->dbh->prepare("UPDATE bewerbung_punkte SET studiengang_punkte = ?, fachsemester_punkte = ?, credit_anzahl_punkte = ?, seminar_teilnahme_punkte = ?, gesamt_punkte = ? WHERE bewerbung_id = ?");
        $error = $this->dbh->errno . ' ' . $this->dbh->error;
        echo $error;
        $statement->bind_param('iiiiii', $studiengang_punkte, $fachsemester_punkte, $credit_anzahl_punkte, $seminar_teilnahme_punkte, $gesamt_punkte, $last_id);
        $statement->execute();
    }

    public function getPunkteGesamt($bewerbung_id) 
    {
        $statement = $this->dbh->prepare("SELECT gesamt_punkte
        FROM bewerbung_punkte 
        WHERE bewerbung_id = ? ORDER BY gesamt_punkte DESC");
        $statement->bind_param('i', $bewerbung_id);
        $statement->execute();
        return $statement;
    }
}
?>