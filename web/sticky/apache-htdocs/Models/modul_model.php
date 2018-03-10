<?php

require("thema_model.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

class modul_model {

    //Erstellen einer Variable $dbh und speichern des Datenabnkzugriffs auf dieser
    //damit alle Funktionen Zugriff auf diese über $this->dbh haben
    public $dbh;

    public function __construct() {
        require("db.php");
        $this->dbh = $dbh;
        $this->thema = new thema_model();
    }

    //Annahme der relevanten Formeingaben und einspeisen dieser in die DB
    public function insertModul($thema, $modulbezeichnung, $kategorie, $verfahren, $semester, $start, $ende, $studiengang) {
        //Erst eintragung des Moduls
        $statement = $this->dbh->prepare("INSERT INTO `modul` (`modulbezeichnung`, `kategorie`, `verfahren`, `semester`, `frist_start`, `frist_ende`, `studiengang`, `benutzer_id`, `modul_verfuegbarkeit`) 
        VALUES (?,?,?,?,?,?,?,?,'Verfügbar')");
        $statement->bind_param('sssssssi', $modulbezeichnung, $kategorie, $verfahren, $semester, $start, $ende, $studiengang, $_SESSION['login']);
        $statement->execute();

        //dann die hierdurch entstandene modul_id holen
        $statement = $this->dbh->prepare("SELECT modul_id FROM modul WHERE modulbezeichnung = ?");
        $statement->bind_param('s', $modulbezeichnung);
        $statement->execute();
        $statement->bind_result($modul_id);
        while ($statement->fetch()) {
            $modul_id;
        }

        //Und hier alle Themen mit den passenden Beschreibungen zu dem gerade angelegten Modul hinzufügen
        array_filter($_POST['themenbezeichnungwindhund']);
        array_filter($_POST['themenbezeichnungbelegwunsch']);
        array_filter($_POST['themenbeschreibung']);
        $beschreibung = $_POST['themenbeschreibung'];
        $i = 0;
        $j = 0;
        if ($verfahren == "Belegwunschverfahren") {
            $i += 1;
        }
        while ($j < count($thema)) {
            $thema_array = $thema[$j];
            if (!empty($beschreibung[$i])) {
                $beschreibung_array = $beschreibung[$i];
                $this->thema->insertThema($modul_id, $thema_array, $beschreibung_array);
            } else {
                $this->thema->insertThema($modul_id, $thema_array, '');
            }
            $i += 1;
            $j += 1;
        }
        return $statement;
    }

    public function getModulAnzahl($modul_id) {
        $statement = $this->dbh->prepare("SELECT count(modul_id) as anzahl_modul FROM modul WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulBySemester($semester) {
        $statement = $this->dbh->prepare("SELECT modul_id, modulbezeichnung,verfahren,frist_start, frist_ende, nachrueckverfahren, timestamp FROM modul WHERE semester = ?");
        $statement->bind_param('s', $semester);
        $statement->execute();
        return $statement;
    }

    public function getModulAnzahlBySemester($semester) {
        $statement = $this->dbh->prepare("SELECT count(modul_id) as modul_anzahl FROM modul WHERE semester = ?");
        $statement->bind_param('s', $semester);
        $statement->execute();
        return $statement;
    }

    public function getModulAnzahlVerfuegbarBySemester($semester, $verfuegbar) {
        $statement = $this->dbh->prepare("SELECT count(modul_id) as modul_verfuegbar_anzahl  FROM modul WHERE semester = ? AND modul_verfuegbarkeit =?");
        $statement->bind_param('ss', $semester, $verfuegbar);
        $statement->execute();
        return $statement;
    }

    public function showFilterSemester($false) {
        $statement = $this->dbh->prepare("SELECT semester, count(modul_id) AS anzahl FROM modul WHERE archivierung=? GROUP BY semester");
        $statement->bind_param('s',$false);
        $statement->execute();
        return $statement;
    }

    public function showFilterKategorie($false) {
        $statement = $this->dbh->prepare("SELECT kategorie, count(modul_id) AS anzahl FROM modul WHERE archivierung=? GROUP BY kategorie");
        $statement->bind_param('s',$false);
        $statement->execute();
        return $statement;
    }

    public function showFilterDozent($false) {
        $statement = $this->dbh->prepare("SELECT dozent, count(modul_id) AS anzahl FROM modul, benutzer WHERE modul.benutzer_id = benutzer.benutzer_id AND modul.archivierung=? GROUP BY dozent");
        $statement->bind_param('s',$false);
        $statement->execute();
        return $statement;
    }

    public function showFilterVerfuegbarkeit($false) {
        $statement = $this->dbh->prepare("SELECT modul_verfuegbarkeit, count(modul_id) AS anzahl FROM modul WHERE archivierung=? GROUP BY modul_verfuegbarkeit");
        $statement ->bind_param('s',$false);
        $statement->execute();
        return $statement;
    }

    public function getFilterModule($select, $filter, $false) {
        $statement = $this->dbh->prepare(
                "SELECT modul_id, modulbezeichnung, kategorie, verfahren, semester, frist_start, frist_ende, benutzer_id, studiengang, modul_verfuegbarkeit, nachrueckverfahren
        FROM modul
        WHERE " . $select . " = ? AND archivierung =?");
        $statement->bind_param('ss', $filter, $false);
        $statement->execute();
        $this->dbh->error_list;
        return $statement;
    }

    public function getFilterDozent($filter, $true) {
        $statement1 = $this->dbh->prepare(
                "SELECT benutzer_id FROM benutzer WHERE dozent = ?");
        $statement1->bind_param('s', $filter);
        $statement1->execute();
        $statement1->bind_result($benutzer);
        $statement1->store_result();
        while ($statement1->fetch()) {
            $statement = $this->dbh->prepare(
                    "SELECT modul_id, modulbezeichnung, kategorie, verfahren, semester, frist_start, frist_ende, benutzer_id, studiengang, modul_verfuegbarkeit, nachrueckverfahren
        FROM modul
        WHERE benutzer_id = ? AND archivierung = ?");
            $statement->bind_param('ss', $benutzer, $true);
            $statement->execute();
            return $statement;
        }
    }

    public function getModul($modul_id) {
        $statement = $this->dbh->prepare("SELECT frist_start, frist_ende, modulbezeichnung, semester, studiengang, kategorie, verfahren, modul_verfuegbarkeit, nachrueckverfahren
        FROM modul WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulbezeichnung($modul_id) {
        $statement = $this->dbh->prepare("SELECT modulbezeichnung
        FROM modul WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulbezeichnungVerfahren($modul_id) {
        $statement = $this->dbh->prepare("SELECT modulbezeichnung, verfahren
        FROM modul WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getAllModule($archivierung) {
        $statement = $this->dbh->prepare("SELECT modul_id, modulbezeichnung, kategorie, verfahren, semester, frist_start, frist_ende, benutzer_id, studiengang, modul_verfuegbarkeit, nachrueckverfahren 
        FROM modul WHERE archivierung = ? ");
        $statement->bind_param('s', $archivierung);
        $statement->execute();
        return $statement;
    }

    public function getModulGroupDatum($semester) {
        $statement = $this->dbh->prepare("SELECT Count(modul_id) as anzahl_module, DATE_FORMAT(timestamp,'%d-%m-%Y') as datum_group 
        FROM modul
        WHERE semester =?
        GROUP BY datum_group");
        $statement->bind_param('s', $semester);
        $statement->execute();
        return $statement;
    }

    public function getModulKategorie($modul_id) {
        $statement = $this->dbh->prepare("SELECT kategorie
        FROM modul
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulStudiengang($modul_id) {
        $statement = $this->dbh->prepare("SELECT studiengang
        FROM modul
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        $statement->bind_result($studiengang);
        while ($statement->fetch()) {
            $studiengangDB = $studiengang;
        }
        return $studiengangDB;
    }

    public function getModul_verfuegbarkeit($modul_id) {
        $statement = $this->dbh->prepare("SELECT modul_verfuegbarkeit
        FROM modul
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement_verfuegbarkeit;
    }

    public function getModulBezeichnungKategorie($modul_id) {
        $statement = $this->dbh->prepare("SELECT modulbezeichnung, kategorie, nachrueckverfahren
        FROM modul
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulFristen($modul_id) {
        $statement = $this->dbh->prepare("SELECT modulbezeichnung, frist_ende
        FROM modul 
        WHERE modul_id =?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getFristEnde($modul_id) {
        $statement = $this->dbh->prepare("SELECT frist_ende FROM modul WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        $statement->bind_result($frist_ende);
        while($statement->fetch())
        {
            return $frist_ende;
        }
    }

    public function getModulbezeichnungEnde($modul_id) {
        $statement = $this->dbh->prepare("SELECT frist_start, frist_ende
        FROM modul
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulNachrückverfahren($modul_id) {
        $statement = $this->dbh->prepare("SELECT nachrueckverfahren
        FROM modul
        WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function getModulThemaSemester($semester) {
        $statement = $this->dbh->prepare("SELECT  modul.modul_id, modul.modulbezeichnung, modul.verfahren, modul.frist_start, modul.frist_ende, modul.timestamp, modul.nachrueckverfahren, thema.thema_id, thema.thema_verfuegbarkeit FROM thema,modul WHERE modul.modul_id = thema.modul_id AND modul.semester=?");
        $statement->bind_param('s', $semester);
        $statement->execute();
        return $statement;
    }

    public function updateFristEnde($modul_id, $status, $frist_ende_neu) {
        $modul_vergeben = $this->dbh->prepare("UPDATE modul SET frist_ende = ?, nachrueckverfahren = ? WHERE modul_id = ?");
        $modul_vergeben->bind_param('ssi', $frist_ende_neu, $status, $modul_id);
        $modul_vergeben->execute();
    }

    public function fristKontrolle($modul_id) {
        $statement = $this->dbh->prepare("SELECT frist_start FROM modul WHERE modul_id = ?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        return $statement;
    }

    public function deleteModul($modul_id) {
        $statement = $this->dbh->prepare("DELETE FROM modul WHERE modul_id=?");
        $statement->bind_param('i', $modul_id);
        $statement->execute();
        $this->thema->deleteAllThema($modul_id);
    }

    public function updateModul($kategorie, $modulbezeichnung, $start, $ende, $semester, $studiengang, $verfahren, $modul_id) {
        $modul = $this->dbh->prepare("UPDATE modul SET kategorie = ?, modulbezeichnung = ?, frist_start = ?, frist_ende =?, semester =?, studiengang =?, verfahren=? WHERE modul_id = ?");
        $modul->bind_param('sssssssi', $kategorie, $modulbezeichnung, $start, $ende, $semester, $studiengang, $verfahren, $modul_id);
        $modul->execute();
    }

    public function updateModulVerfuegbarkeit($modul_id, $vergeben) {
        $modul_vergeben = $this->dbh->prepare("UPDATE modul SET modul_verfuegbarkeit = ? WHERE modul_id = ?");
        $modul_vergeben->bind_param('si', $vergeben, $modul_id);
        $modul_vergeben->execute();
    }

    public function updateModulArchivierung($modul_id, $true) {
        $modul_vergeben = $this->dbh->prepare("UPDATE modul SET archivierung = ? WHERE modul_id = ?");
        $modul_vergeben->bind_param('si', $true, $modul_id);
        $modul_vergeben->execute();
    }

}

?>