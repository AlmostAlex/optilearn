<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class bewerbung_model
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function insertBewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $seminar_teilnahme, $offen) 
    {
        $statement = $this->dbh->prepare("INSERT INTO bewerbung (vorname, nachname, matrikelnummer, email, thema_id, studiengang, fachsemester, credit_anzahl, seminar_teilnahme, status) 
        VALUES (?,?,?,?,?,?,?,?,?,?)");
        $statement->bind_param('ssisisiiss', $vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $seminar_teilnahme, $offen);
        $statement->execute();
        $last_id = $this->dbh->insert_id;
        return $last_id;
    }

    public function updateBewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $seminar_teilnahme) 
    {   
        $statement = $this->dbh->prepare("UPDATE bewerbung SET vorname = ?, nachname = ?, matrikelnummer = ?, email = ?, thema_id = ?, studiengang = ?, fachsemester = ?, credit_anzahl = ?, seminar_teilnahme = ? WHERE thema_id = ? AND matrikelnummer = ?");
        $statement->bind_param('ssisisiisii', $vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $seminar_teilnahme, $thema_id, $matrikelnummer);
        $statement->execute();
    }

    public function getBewerberID($matrikelnummer)
    {
        $statement = $this->dbh->prepare("SELECT bewerbung_id FROM bewerbung WHERE matrikelnummer = ?");
        $statement->bind_param('i', $matrikelnummer);
        $statement->execute();
        $statement->bind_result($bewerbung_id);
        while($statement->fetch())
        {
            return $bewerbung_id;
        }
    }

    public function getBewerberDetails($thema_id)
    {
        $statement = $this->dbh->prepare("SELECT bewerbung_id, matrikelnummer, email, studiengang, fachsemester, credit_anzahl, seminar_teilnahme, status FROM bewerbung WHERE thema_id =?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function getBewerberAnzahlThema($thema_id)
    {
        $statement = $this->dbh->prepare("SELECT count(bewerbung_id) as anzahl_bewerber_check
        FROM bewerbung 
        WHERE thema_id =?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function duplikatPrüfung($modul_id) 
    {
        if($statement = $this->dbh->prepare("SELECT matrikelnummer, bewerbung.status, bewerbung.thema_id
        FROM bewerbung, thema
        WHERE thema.thema_id = bewerbung.thema_id AND thema.modul_id = ?"))
        {
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
        }
        else
        {
            return "leere DB";
        }
    }

    public function updateStatusGetMail($annahme, $email, $i)
    {
        $statement = $this->dbh->prepare("UPDATE bewerbung SET status = ? WHERE email = ?");
        $statement->bind_param('ss', $annahme, $email[$i]);
        $statement->execute();
    }
}
?>