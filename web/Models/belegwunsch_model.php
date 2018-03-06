<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class belegwunsch_model
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function insertBelegwunsch($vorname, $nachname, $matrikelnummer, $email, $modul_id, $wunsch_1, $wunsch_2, $wunsch_3, $offen, $thema_id) 
    {
        $statement = $this->dbh->prepare("INSERT INTO belegwunsch (vorname, nachname, matrikelnummer, email, modul_id, status, wunsch_1, wunsch_2, wunsch_3, thema_id) 
        VALUES (?,?,?,?,?,?,?,?,?,?)");
        $statement->bind_param('ssisisiiii', $vorname, $nachname, $matrikelnummer, $email, $modul_id, $offen, $wunsch_1, $wunsch_2, $wunsch_3, $thema_id);
        $statement->execute();
    }

    public function duplikatPrüfung($modul_id) 
    {
        if($statement = $this->dbh->prepare("SELECT matrikelnummer, belegwunsch.status
        FROM belegwunsch, modul
        WHERE belegwunsch.modul_id = modul.modul_id AND modul.modul_id = ?"))
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

    public function getThemaBewerber($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT belegwunsch_id, wunsch_1, wunsch_2, wunsch_3
        FROM belegwunsch
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getBewerberDetailsThema($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT belegwunsch_id, vorname, nachname, matrikelnummer, email, status
        FROM belegwunsch 
        WHERE thema_id =?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function getBewerberAnzahl($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT COUNT(belegwunsch_id)
        FROM belegwunsch
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        $statement->bind_result($Anzahl);
        while($statement->fetch())
        {
            return $Anzahl;
        }
    }

    public function getBewerberAnzahlThema($thema_id)
    {
        $statement = $this->dbh->prepare("SELECT count(belegwunsch_id) as anzahl_bewerber_check
        FROM belegwunsch 
        WHERE thema_id =?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }
    
    public function setThema($belegwunsch_id, $thema_id) 
    {
        $statement = $this->dbh->prepare("UPDATE belegwunsch SET thema_id = ? WHERE belegwunsch_id = ?");
        $statement->bind_param('ii', $thema_id, $belegwunsch_id);
        $statement->execute();
    }

    public function updateStatusGetMail($annahme, $email)
    {
        $statement = $this->dbh->prepare("UPDATE belegwunsch SET status = ? WHERE email = ?");
        $statement->bind_param('ss', $annahme, $email);
        $statement->execute();
    }

    public function updateThemaMail($vergeben, $email)
    {
        $statement_thema = $this->dbh->prepare("SELECT thema_id FROM belegwunsch WHERE email = ?");
        $statement_thema->bind_param('s', $email);
        $statement_thema->execute();
        $statement_thema->bind_result($thema_id);
        $statement_thema->store_result();
        while($statement_thema->fetch())
        {
            $statement = $this->dbh->prepare("UPDATE thema SET thema_verfuegbarkeit = ? WHERE thema_id = ?");
            $statement->bind_param('si', $vergeben, $thema_id);
            $statement->execute();
        }
    }

    public function getBewerberAufThema($thema_id)
    {
        $statement = $this->dbh->prepare("SELECT count(belegwunsch_id) as anzahl_bewerber
        FROM belegwunsch 
        WHERE wunsch_1 = ? OR wunsch_2 = ? OR wunsch_3 = ?");
        $statement->bind_param('iii', $thema_id, $thema_id, $thema_id);
        $statement->execute();
        return $statement;
    }
}
?>