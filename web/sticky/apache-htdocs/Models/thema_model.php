<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class thema_model
{
    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }

    public function insertThema($modul_id, $themenbezeichnung, $themenbeschreibung) 
    {
        if($statement = $this->dbh->prepare("INSERT INTO `thema` (`themenbezeichnung`, `beschreibung`, `modul_id`, `thema_verfuegbarkeit`) 
        VALUES (?,?,?, 'Verfügbar')"))
        {
            $statement->bind_param('ssi', $themenbezeichnung, $themenbeschreibung, $modul_id);
            $statement->execute();           
        }
        else
        {
            $error = $this->dbh->errno . ' ' . $this->dbh->error;
            echo "Fehlercode: ".$error."<br/> Eintragung vom Thema ist fehlgeschlagen.";
        }
    }

    public function getBewerberAufThema($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT count(bewerbung_id) as anzahl_bewerber
        FROM thema, bewerbung 
        WHERE bewerbung.thema_id = thema.thema_id AND thema.thema_id = ?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function getThemaDetails($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT modul_id, themenbezeichnung, thema_verfuegbarkeit
        FROM thema 
        WHERE thema_id =?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function getModulThema($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT themenbezeichnung, beschreibung, thema_id, thema_verfuegbarkeit  FROM thema WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }
    
        public function getModulAnzahlThema_Verfuegbar($modul_id, $verfuegbar) 
    {
        $statement = $this->dbh->prepare("SELECT count(thema_id) as anzahl_thema_verfuegbarkeit FROM thema WHERE modul_id = ? AND thema_verfuegbarkeit =?");
        $statement->bind_param('is', $modul_id, $verfuegbar);
        $statement->execute();
        return $statement;
    }

    public function getAllModulThema($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT thema_id FROM thema WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getAllModulThemaDetails($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT thema_id, themenbezeichnung, thema_verfuegbarkeit
        FROM thema 
        WHERE modul_id =?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getAllModulThemaDetailsVergeben($modul_id) 
    {
        $vergeben = "vergeben";
        $statement = $this->dbh->prepare("SELECT thema_id, themenbezeichnung, thema_verfuegbarkeit
        FROM thema 
        WHERE modul_id =? AND thema_verfuegbarkeit = ?");
        $statement->bind_param('is', $modul_id, $vergeben);
        $statement->execute();
        return $statement;
    }

    public function getModulThemaAnzahlById($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT count(thema_id) as anzahl FROM thema WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }
    
    
    public function getModulThemaAnzahlVerfuegbar($modul_id, $thema_verfuegbarkeit) 
    {
        $statement = $this->dbh->prepare("SELECT count(thema_id) as anzahl_thema_verfuegbar FROM thema WHERE modul_id = ? AND thema_verfuegbarkeit= ? ");
        $statement->bind_param('is', $modul_id, $thema_verfuegbarkeit);
        $statement->execute();
        return $statement;
    }
    
        public function getModulThemaVerfuegbar($modul_id, $thema_verfuegbarkeit) 
    {
        $statement = $this->dbh->prepare("SELECT themenbezeichnung, thema_id FROM thema WHERE modul_id = ? AND thema_verfuegbarkeit= ? ");
        $statement->bind_param('is', $modul_id, $thema_verfuegbarkeit);
        $statement->execute();
        return $statement;
    }


    public function getThemaAnzahl($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT count(thema_id) as anzahl from thema WHERE thema_id = ?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function getModulThemaAnzahl($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT count(thema_id) as anzahl from thema WHERE modul_id = ? group by modul_id");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulThemaAnzahldirekt($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT count(thema_id) from thema WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        $statement->bind_result($Anzahl);
        while($statement->fetch())
        {
        return $Anzahl;
        }
    }

    public function getThemeninfo($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT themenbezeichnung, beschreibung FROM thema WHERE thema_id = ?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function updateThema($themenbezeichnung, $themenbeschreibung, $thema_id) 
    {
        $statement = $this->dbh->prepare("UPDATE thema SET themenbezeichnung = ?, beschreibung = ? WHERE thema_id = ?");
        $statement->bind_param('ssi', $themenbezeichnung, $themenbeschreibung, $thema_id);
        $statement->execute();
        return $statement;
    }

    public function updateVerfuegbarkeit($thema_id, $vergeben) 
    {
        $statement = $this->dbh->prepare("UPDATE thema SET thema_verfuegbarkeit = ? WHERE thema_id = ?");
        $statement->bind_param('si', $vergeben, $thema_id);
        $statement->execute();
    }

    public function deleteThema($thema_id) 
    {
        $statement = $this->dbh->prepare("DELETE FROM thema WHERE thema_id=?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
    }

    public function deleteAllThema($modul_id) 
    {
        $statement = $this->dbh->prepare("DELETE FROM thema WHERE modul_id=?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
    }

    public function getModulId($thema_id)
    {
        $statement = $this->dbh->prepare("SELECT modul_id FROM thema WHERE thema_id = ?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function getThemenbezeichnung($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT themenbezeichnung  FROM thema WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }
    
    public function getBezeichnung($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT themenbezeichnung  FROM thema WHERE thema_id = ?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }

    public function getBezeichnungModulId($thema_id) 
    {
        $statement = $this->dbh->prepare("SELECT modul_id, themenbezeichnung
        FROM thema 
        WHERE thema_id=?");
        $statement->bind_param('i', $thema_id);
        $statement->execute();
        return $statement;
    }
    
    public function getThemenBez($modul_id) 
    {
        $statement = $this->dbh->prepare("SELECT thema.thema_id, thema.themenbezeichnung, thema.thema_verfuegbarkeit FROM thema,modul WHERE modul.modul_id = thema.modul_id AND modul.modul_id = ?");
        $statement->bind_param('s', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getAnzahlWindhund($DBverfahren, $modul_id) 
    { 
        $statement = $this->dbh->prepare("SELECT count({$DBverfahren}.{$DBverfahren}_id) as ab FROM {$DBverfahren},thema,modul 
                                        WHERE thema.thema_id = {$DBverfahren}.thema_id 
                                        AND thema.modul_id = modul.modul_id 
                                        AND modul.modul_id = ?");
        $statement->bind_param('i', $modul_id);     
        $statement->execute();
        return $statement;
    }

    public function getAnzahlBelegwunsch($DBverfahren, $modul_id) 
    { 
        $statement = $this->dbh->prepare("SELECT count({$DBverfahren}.{$DBverfahren}_id) as ab FROM {$DBverfahren},modul 
                                        WHERE {$DBverfahren}.modul_id = modul.modul_id
                                        AND modul.modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getMailThemenbezeichnung($verfahren, $modul_id, $email2)
    {
        $statement = $this->dbh->prepare("SELECT themenbezeichnung FROM thema, ".$verfahren."  
        WHERE thema.thema_id = ".$verfahren.".thema_id AND thema.modul_id = ? AND ".$verfahren.".email =?");
        $statement->bind_param('is', $modul_id, $email2);
        $statement->execute();
        return $statement;
    }
    
}
?>