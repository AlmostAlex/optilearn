<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class windhund_model
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function insertWindhund($vorname, $nachname, $matrikelnummer, $email, $thema_id, $status) 
    {
        $statement = $this->dbh->prepare("INSERT INTO windhund (vorname, nachname, matrikelnummer, email, thema_id, status) 
        VALUES (?,?,?,?,?,?)");
        $statement->bind_param('ssisis', $vorname, $nachname, $matrikelnummer, $email, $thema_id, $status);
        $statement->execute();
    }

    public function duplikatPrüfung($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT matrikelnummer, status
        FROM windhund, thema
        WHERE thema.thema_id = windhund.thema_id AND thema.modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function bewerbungAnzahlGesamt($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT windhund_id
                                        FROM windhund, thema
                                        WHERE windhund.thema_id = thema.thema_id AND thema.modul_id =?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getThemaBewerber($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT windhund_id, vorname, nachname, matrikelnummer, email, status
        FROM windhund
        WHERE thema_id = ? ");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function updateStatusGetMail($annahme, $email)
    {
        $statement = $this->dbh->prepare("UPDATE windhund SET status = ? WHERE email = ?");
        $statement->bind_param('ss', $annahme, $email);
        $statement->execute();
    }

    public function updateThemaMail($vergeben, $email)
    {
        $statement_thema = $this->dbh->prepare("SELECT thema_id FROM windhund WHERE email = ?");
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
    
}
?>