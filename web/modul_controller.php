<?php

require("Models/modul_model.php");
require("Models/benutzer_model.php");

class modul_controller {

    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $modul;

    public function __construct() {
        $this->modul = new modul_model();
        $this->thema = new thema_model();
        $this->benutzer = new benutzer_model();
    }

    public function ModulEintragung() {
        //Übergabe der Formeingaben, Kontrolle ob diese auch ausgefüllt worden sind und
        //Aufruf der Modelfunktion "LoginKontrolle" mit diesen.
        $modulbezeichnung = $_POST["Bezeichnung"];
        $kategorie = $_POST["Kategorie"];
        $verfahrenseminar = $_POST["Verfahrenseminar"];
        $semester = $_POST['Semester'];
        $jahr = $_POST['Semester_Jahr'];
        $semester = $semester . ' ' . $jahr;
        $studiengang = $_POST["Studiengang"];
        $start_datum = $_POST["Start"]; // DD MM YY
        $start = date("Y-m-d", strtotime($start_datum));
        $ende_datum = $_POST["Ende"];
        $ende = date("Y-m-d", strtotime($ende_datum));

        if ($kategorie == "Seminararbeit" && ($verfahrenseminar == "Windhundverfahren" || $verfahrenseminar == "Bewerbungsverfahren" )) {
            if (!empty(array_filter($_POST['themenbezeichnungwindhund']))) {
                $thema = $_POST['themenbezeichnungwindhund'];
                $eintrag = $this->modul->insertModul($thema, $modulbezeichnung, $kategorie, $verfahrenseminar, $semester, $start, $ende, $studiengang);
                $this->prüfung($eintrag);
            } else {
                echo "<div class='alert alert-danger' style='margin-top: 3%; width: 90%; text-align: center; left: 5%;' role='alert'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Achtung!</b><br>Bitte fülle alle Eingabefelder aus!</div>";
            }
        } else if ($kategorie == "Seminararbeit" && $verfahrenseminar == "Belegwunschverfahren") {
            if (!empty(array_filter($_POST['themenbezeichnungbelegwunsch']))) {
                $thema = $_POST['themenbezeichnungbelegwunsch'];
                $eintrag = $this->modul->insertModul($thema, $modulbezeichnung, $kategorie, $verfahrenseminar, $semester, $start, $ende, $studiengang);
                $this->prüfung($eintrag);
            } else {
                echo "<div class='alert alert-danger' style='margin-top: 3%; width: 90%; text-align: center; left: 5%;'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Achtung!</b><br>Bitte fülle alle Eingabefelder aus!</div>";
            }
        } else if ($kategorie == "Abschlussarbeit" && ($verfahrenseminar == "Windhundverfahren" || $verfahrenseminar == "Bewerbungsverfahren" )) {
            if (!empty(array_filter($_POST['themenbezeichnungwindhund']))) {
                $thema = $_POST['themenbezeichnungwindhund'];
                $eintrag = $this->modul->insertModul($thema, $modulbezeichnung, $kategorie, $verfahrenseminar, $semester, $start, $ende, $studiengang);
                $this->prüfung($eintrag);
            } else {
                echo "<div class='alert alert-danger' style='margin-top: 3%; width: 90%; text-align: center; left: 5%;' role='alert'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Achtung!</b><br>Bitte fülle alle Eingabefelder aus!</div>";
            }
        } else if ($kategorie == "Abschlussarbeit" && ($verfahrenseminar == "Belegwunschverfahren")) {
            if (!empty(array_filter($_POST['themenbezeichnungbelegwunsch']))) {
                $thema = $_POST['themenbezeichnungbelegwunsch'];
                $eintrag = $this->modul->insertModul($thema, $modulbezeichnung, $kategorie, $verfahrenseminar, $semester, $start, $ende, $studiengang);
                $this->prüfung($eintrag);
            } else {
                echo "<div class='alert alert-danger' style='margin-top: 3%; width: 90%; text-align: center; left: 5%;' role='alert'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Achtung!</b><br>Bitte fülle alle Eingabefelder aus!</div>";
            }
        } else {
            echo "<div class='alert alert-danger' style='margin-top: 3%; width: 90%; text-align: center; left: 5%;' role='alert'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Achtung!</b><br>Bitte Verfahren auswählen!</div>";
        }
    }

    public function prüfung($eintrag) {
        if ($eintrag == TRUE) {
            echo"<script> $(window).load(function() { $('#modul_success').modal('show'); }); </script>";
            echo"<success><div class='modal fade' id='modul_success' tabindex='0' role='dialog'>";
            echo"<div class='modal-dialog'>";
            echo"<div class='modal-content'>";
            echo"<div class='modal-header'>";
            echo"<h5 class='modal-title' id='titel'>Modul erfolgreich eingetragen!</h5>";
            echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo"<span aria-hidden='true'>&times;</span></button>";
            echo"</div>";
            echo"<div class='modal-body'>";
            echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center><b>Das Modul wurde erfolgreich eingetragen!</b><br>";
            echo"Gehe zur <a style='color: green;' href='mt_verwaltung.php'>Verwaltungsseite für Module und Themen</a></center></div>";
            echo"<p class='debug-url'></p>";
            echo"</div>";
            echo"<div class='modal-footer'>";
            echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
            echo"</div>";
            echo"</div>";
            echo"</div>";
            echo"</div></success>";
            //echo"<meta http-equiv='refresh' content='0; URL=/erfolgreich.php'>"; // Weiterleitung zur Verwaltung 
        } else {
            echo "<div class='alert alert-danger' style='margin-top: 3%; width: 90%; text-align: center; left: 5%;' role='alert'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Achtung!</b><br>Eintragung fehlgeschlagen.</div>";
        }
    }

    public function ModelübersichtEdit($modul_id) {
        //Erstmal wird geschaut, um welche Fristen es sich handelt
        $statement_modul = $this->modul->getModul($modul_id);
        $statement_modul->bind_result($frist_start, $frist_ende, $modulbezeichnung, $semester, $studiengang, $kategorie, $verfahren, $modul_verfuegbarkeit, $nachrueckverfahren);
        $statement_modul->store_result();
        $dec_modul = base64_encode($modul_id);
        while ($statement_modul->fetch()) {
            echo"<form method='post'>";
            echo"<div class='edit_div_modul'>";
            date_default_timezone_set("Europe/Berlin");
            $aktuell = new DateTime(date("Y-m-d"));
            $start = new DateTime($frist_start);
            
            $start_anzeige = date("d-m-Y", strtotime($frist_start));
            $ende_anzeige = date("d-m-Y", strtotime($frist_ende));

            echo"<table class='edit_div_table'>";
            echo"<tr><td colspan='3'><h5>Bearbeitung des Moduls:<br><span>{$modulbezeichnung}</span></h5></td></tr>";
            echo"<tr>";
            echo"<td><label for='Kategorie'><b>Kategorie:</b><red style='color: red'>*</red></label></td>";
            if ($kategorie == 'Abschlussarbeit') {
                echo"<td><center><input style='margin-right: 5px;' type='radio' name='Kategorie' value='Seminararbeit' class='Kategorie' />Seminararbeit</input></center></td>";
                echo"<td><center><input style='margin-right: 5px;' type='radio' name='Kategorie' value='Abschlussarbeit' class='Kategorie' checked='checked' />Abschlussarbeit</input></center></td>";
            } else {
                echo"<td><center><input style='margin-right: 5px;' type='radio' name='Kategorie' value='Seminararbeit' class='Kategorie' checked='checked'/>Seminararbeit</input></center></td>";
                echo"<td><center><input style='margin-right: 5px;' type='radio' name='Kategorie' value='Abschlussarbeit' class='Kategorie'/>Abschlussarbeit</input></center></td>";
            }
            echo"</tr>";
            echo"<tr>";
            echo"<td><label for='Kategorie'><b>Modulbezeichnung:</b><red style='color: red'>*</red></label></td>";
            echo"<td colspan='2'><input type='text' id='bezeichnung' name='Bezeichnung'  class='form-control' value='{$modulbezeichnung}' required></td>";
            echo"</tr>";

            if ($start <= $aktuell) {
                echo"<tr>";
                echo"<td><label for='Termine'><b>Bewerbungsfristen:</b><red style='color: red'>*</red></label></td>";
                echo"<td><input type='text' class='form-control' name='Start' value='$start_anzeige' readonly required></td>";
                echo"<td><input type='text' class='form-control' name='Ende' value='$ende_anzeige' readonly required></td></tr>";
            } else {
                echo"<tr>";
                echo"<td><label for='Termine'><b>Bewerbungsfristen:</b><red style='color: red'>*</red></label></td>";
                echo"<td><input type='text' class='form-control' name='Start' value='$start_anzeige' id='datepicker_Start' required></td>";
                echo"<td><input type='text' class='form-control' name='Ende' value='$ende_anzeige' id='datepicker_Ende' required></td></tr>";
            }
            echo"<tr>";
            echo"<td><label for='Semester'><b>Semester:</b><red style='color: red'>*</red></label></td>";
            echo"<td colspan='2'><input type'text' class='form-control' id='Semester' name='Semester' value='{$semester}' required></td>";
            echo"</tr>";
            echo"<td><label for='bevStudiengang'><b>bevorzugter Studiengang:</b></label></td>";
            echo"<td colspan='2'>";
            echo"<select class='form-control' name='Studiengang' id='Studiengang' required>";
            if ($studiengang === 'None') {
                echo"       <option value='None'>Keiner</option>";
                echo"       <option value='Betriebswirtschaftlehre'>Betriebswirtschaftslehre</option>";
                echo"       <option value='Wirtschaftsinformatik'>Wirtschaftsinformatik</option>";
                echo"       <option value='Volkswirtschaftslehre'>Volkswirtschaftslehre</option>";
                echo"       <option value='Wirtschaftspädagogik'>Wirtschaftspädagogik</option>";
            } elseif ($studiengang === 'Wirtschaftsinformatik') {
                echo"       <option value='Wirtschaftsinformatik'>Wirtschaftsinformatik</option>";
                echo"       <option value='Betriebswirtschaftlehre'>Betriebswirtschaftslehre</option>";
                echo"       <option value='Volkswirtschaftslehre'>Volkswirtschaftslehre</option>";
                echo"       <option value='Wirtschaftspädagogik'>Wirtschaftspädagogik</option>";
                echo"       <option value='None'>Keiner</option>";
            } elseif ($studiengang === 'Betriebswirtschaftlehre') {
                echo"       <option value='Betriebswirtschaftlehre'>Betriebswirtschaftlehre</option>";
                echo"       <option value='Wirtschaftsinformatik'>Wirtschaftsinformatik</option>";
                echo"       <option value='Volkswirtschaftslehre'>Volkswirtschaftslehre</option>";
                echo"       <option value='Wirtschaftspädagogik'>Wirtschaftspädagogik</option>";
                echo"       <option value='None'>Keiner</option>";
            } elseif ($studiengang === 'Volkswirtschaftslehre') {
                echo"       <option value='Volkswirtschaftslehre'>Volkswirtschaftslehre</option>";
                echo"       <option value='Betriebswirtschaftlehre'>Betriebswirtschaftslehre</option>";
                echo"       <option value='Wirtschaftsinformatik'>Wirtschaftsinformatik</option>";
                echo"       <option value='Wirtschaftspädagogik'>Wirtschaftspädagogik</option>";
                echo"       <option value='None'>Keiner</option>";
            } elseif ($studiengang === 'Wirtschaftspädagogik') {
                echo"       <option value='Wirtschaftspädagogik'>Wirtschaftspädagogik</option>";
                echo"       <option value='Volkswirtschaftslehre'>Volkswirtschaftslehre</option>";
                echo"       <option value='Betriebswirtschaftlehre'>Betriebswirtschaftslehre</option>";
                echo"       <option value='Wirtschaftsinformatik'>Wirtschaftsinformatik</option>";
                echo"       <option value='None'>Keiner</option>";
            }
            echo"</select>";
            echo"</td>";
            echo"<tr>";
            echo"<td><label for='verf'><b>Verfahren:<red style='color: red'>*</red></b></label></td>";

            if ($start > $aktuell) {
                echo"<td colspan='2'><select class='form-control' name='verfahren' id='verfahren' required>";

                if ($verfahren === 'Windhundverfahren') {
                    echo"       <option value='Windhundverfahren'>Windhundverfahren</option>";
                    echo"       <option value='Bewerbungsverfahren'>Bewerbungsverfahren</option>";
                    echo"       <option value='Belegwunschverfahren'>Belegwunschverfahren</option>";
                } elseif ($verfahren === 'Bewerbungsverfahren') {
                    echo"       <option value='Bewerbungsverfahren'>Bewerbungsverfahre</option>";
                    echo"       <option value='Windhundverfahren'>Windhundverfahren</option>";
                    echo"       <option value='Belegwunschverfahren'>Belegwunschverfahren</option>";
                } elseif ($verfahren === 'Belegwunschverfahren') {
                    echo"       <option value='Belegwunschverfahren'>Belegwunschverfahren</option>";
                    echo"       <option value='Windhundverfahren'>Windhundverfahren</option>";
                    echo"       <option value='Bewerbungsverfahren'>Bewerbungsverfahren</option>";
                    echo" </select>";
                }
            } else {
                echo"<td colspan='2'><input type='text' class='form-control' name='verfahren' value='$verfahren' readonly required>";
            }
            echo"</td>";
            echo"</tr>";
            echo"<tr><td colspan='2'><br><input type='submit' name='modul_edit' class='btn btn-primary' value='Modul editieren'/></td></tr>";
            echo"</table></form>";
            echo"<table style='margin-bottom: 0%;' class='edit_div_table'><tr><td><h5><i class='fas fa-list-ul'></i> Zu dem Modul gibt es folgende Themen:</h5></td></tr>"
            . "<tr><td><span>Thema zum Modul hinzufügen </span><a href='/add_thema.php?action=addthema&id={$dec_modul}'><i class='far fa-plus-square'></i></a> </td></tr></table><br>";
            $statement_thema = $this->thema->getModulThema($modul_id);
            $statement_thema->bind_result($themenbezeichnung, $beschreibung, $thema_id, $thema_verfügbarkeit);
            $statement_thema->store_result();
            echo"<ul>";
            while ($statement_thema->fetch()) {
                $dec_thema = base64_encode($thema_id);
                echo"<li> <a href='edit_thema.php?action=editThema&id={$dec_thema}'><i class='far fa-edit'></i></a> {$themenbezeichnung}</li>";
            }
            echo"</ul></div><br>";
        }
    }

    public function ModulübersichtDozent() {
        $statement_modul = $this->modul->getAllModule("false");
        $statement_modul->bind_result($modul_id, $modulbezeichnung, $kategorie, $verfahren, $semester, $frist_start, $frist_ende, $benutzer_id, $studiengang, $modul_verfuegbarkeit, $nachrueckverfahren);
        $statement_modul->store_result();

        echo"<uebersicht style='margin-bottom: 100px;'>";
        echo"<div class='panel panel-default panel-table'>";
        echo"<div class='top'>";
        
        echo"<list><table><tr>";
        echo"<td><h3 class='panel-title-dozent'>Modulübersicht - Admin</h3></td>";
        echo"<td><div class='btn-group_dozent' data-toggle='buttons'>";
        echo"<label class='btn btn-filter' data-target='Vergeben'>";
        echo"<input type='radio' name='options' id='option1' autocomplete='off' checked>";
        echo"<i class='fas fa-times'></i> Geschlossene Module";
        echo"</label>";
        echo"<label class='btn btn-filter' data-target='Verfügbar'>";
        echo"<input type='radio' name='options' id='option2' autocomplete='off'>";
        echo"<i class='far fa-circle'></i> Offene Module</label>";
        echo"<label class='btn btn-filter' data-target='all'><input type='radio' name='options' id='option3' autocomplete='off'>";
        echo"Alle Module</label>";
        echo"</div>";
        echo"</td></tr></table></list></div>";

        echo"<module>";
        echo"<div class='panel-body'>";
        echo"<table class='panel_table'>";
        echo"<tr>";
        echo"<th style='width:57px;'></th>";
        echo"<th style='width:400px;'>Modulbezeichnung</th>";
        echo"<th style='width:120px;'>Status</th>";
        echo"<th style='width:200px;'>Funktionen</th>";
        echo"</tr>";
        echo"</table>";

        while ($statement_modul->fetch()) {
            if ($nachrueckverfahren == "Aktiv") {
                $verfahren_scheinvariable = "Windhundverfahren";
                $nachrueck_nachricht = "[Nachrückverfahren]";
            } else {
                $verfahren_scheinvariable = $verfahren;
                $nachrueck_nachricht = '';
            }
            $dec_modul = base64_encode($modul_id);

            // Aktuelle Zeit wird abgerufen
            date_default_timezone_set("Europe/Berlin");
            $aktuell_datum = date("Y-m-d");
            $heute_dt = new DateTime($aktuell_datum);
            // Start und Endfristen zum Vergleich
            $start_dt = new DateTime($frist_start);
            $frist_end = new DateTime($frist_ende);
            // Anzeige der Start und Endfristen in d-m-Y Form
            $start_anzeige = date("d-m-Y", strtotime($frist_start));
            $ende_anzeige = date("d-m-Y", strtotime($frist_ende));

            $aktuell_datum_anzeige = date("d-m-Y");
            $frist_ende_neu = date("d-m-Y", strtotime($aktuell_datum_anzeige . "+7 day"));

            // Wenn der Starttermin noch nicht eingetroffen ist, dann können Themen noch gelöscht werden
            if ($start_dt > $heute_dt) {
     
                $delete_modul_btn = "<span data-toggle='tooltip' data-placement='top' title='Modul löschen' class='badge badge-danger'><a href='#' data-toggle='modal' data-target='#delete_modal_$modul_id'><i class='far fa-trash-alt'></i></a></span>";
            } else {
                $delete_modul_btn = "";
            }

            $statement_thema = $this->thema->getModulThema($modul_id); // Themen werden geholt in Abh. der ID des Moduls
            $statement_thema->bind_result($themenbezeichnung, $beschreibung, $thema_id, $thema_verfügbarkeit);
            $statement_thema->store_result();

            // Wenn Nachrückverfahren aktiv ist, dann ändert sich das Verfahren zum Windhundverfahren - dh es wird kein Update durchgeführt
            $statement_nachrückverfahren = $this->modul->getModulNachrückverfahren($modul_id);
            $statement_nachrückverfahren->bind_result($nachrueckverfahren);
            $statement_nachrückverfahren->store_result();

            while ($statement_nachrückverfahren->fetch()) {
                if ($verfahren == "Windhundverfahren" || $verfahren == "Belegwunschverfahren") {
                    $einsicht_bewerbungen_windhund_belegwunsch = "<span data-toggle='tooltip' data-placement='top' title='Bewerbungen einsehen vom {$verfahren}' class='badge badge-info'><a href='einsicht.php?action={$verfahren}&id={$dec_modul}'><i class='fas fa-users'></i></a></span>";
                } else {
                    $einsicht_bewerbungen_windhund_belegwunsch = "";
                }

                if ($verfahren == 'Belegwunschverfahren') {
                    $auswertung = "<a href='beleg.php?action=auswertung&id={$dec_modul}'><i class='fas fa-sync-alt'></i></a>";
                } else {
                    $auswertung = "";
                }
                // Im Modal wird bei Beleg-oderBewerbungsverfahren erwhnt, dass sich das Verfahren zum "Windhundverfahren" geändert wird.
                if ($verfahren == "Windhundverfahren") {
                    $modalTextInhalte = "";
                } else {
                    $modalTextInhalte = "<center><i style='color: red;' class='fas fa-exclamation-triangle'></i> Beachten Sie, dass das Verfahren dieses Moduls automatisch zum <b>\"Windhundverfahren\"</b> umgeändert wird.</center>";
                }

                // Wenn das Modul "vergeben" ist durch Frist_heute > End_Frist und die Anzahl der verfuegbaren Themen > 0
                // Dann gibt es die Möglichkeit ein Nachrückverfahren einzuleiten
                $ThemaAnzahl_verfuegbar = $this->thema->getModulThemaAnzahlVerfuegbar($modul_id, "Verfügbar");
                $ThemaAnzahl_verfuegbar->bind_result($anzahl_thema_verfuegbar);
                $ThemaAnzahl_verfuegbar->store_result();
                while ($ThemaAnzahl_verfuegbar->fetch()) {
                    // Wenn heute > frist ende ODER anzahl der Themen == 0, dann ist das modul vergeben! Ansonsten Verfügbar
                    if (($heute_dt > $frist_end) || ($anzahl_thema_verfuegbar == "0")) {
                        $archivierung = "<span data-toggle='tooltip' data-placement='top' title='Modul archvieren' class='badge badge-warning'><a data-toggle='modal' data-target='#archivierung_{$modul_id}' href='#'><i class='far fa-file-archive'></i></a></span>";
                        $this->modul->updateModulVerfuegbarkeit($modul_id, "Vergeben");
                    } else {
                        $this->modul->updateModulVerfuegbarkeit($modul_id, "Verfügbar");
                        $archivierung = "";
                    }
                    // Ein Nachrückverfahren kann statt finden, wenn heute > ende und anzahl der Themen > 0 ist
                    if (($heute_dt > $frist_end) && ($anzahl_thema_verfuegbar > 0)) {
                        $nachrückverfahren = "<span data-toggle='tooltip' data-placement='top' title='Nachrückverfahren einleiten' class='badge badge-primary'><a data-toggle='modal' data-target='#nachrückverfahren_$modul_id' href='#'><i class='far fa-clock'></i></a></span>"; 
                    } else {
                        $nachrückverfahren = "";
                    }
                    // Anzahl der Themen in Abhängigkeit des Moduls
                    $statement_anzahl = $this->thema->getModulThemaAnzahl($modul_id);
                    $statement_anzahl->bind_result($anzahl);
                    $statement_anzahl->store_result();

                    echo"<table id='mytable' class='table table-striped table-bordered table-list'>";
                    echo"<tr data-status='{$modul_verfuegbarkeit}'>";
                    echo"<td style='width:58px;'><center><a class='collapsed' style='color: #3979b5;' data-toggle='collapse' data-parent='#accordion' href='#modulid_{$modul_id}' aria-expanded='true'><i class='fa' aria-hidden='true'></i></a></center></td>";
                    echo"<td style='width:400px;'><b> {$nachrueck_nachricht} {$modulbezeichnung}</b><br><div class='border_round'>{$start_anzeige} - {$ende_anzeige}</div>";
                    echo"<div class='border_round'>{$verfahren_scheinvariable}</div></td>";
                    echo"<td style='width:120px;'><center>{$modul_verfuegbarkeit}</center></td>";
                    echo"<td style='width:200px;' align='center'>";
                    echo"<span data-toggle='tooltip' data-placement='top' title='Modul editieren' class='badge badge-secondary'><a href='/edit_modul.php?action=editModul&id=$dec_modul'><i class='far fa-edit'></i></a></span>";
                    echo" $delete_modul_btn";
                  //  echo"$auswertung";
                    echo" $nachrückverfahren";
                    echo" $einsicht_bewerbungen_windhund_belegwunsch ";
                    echo" <span data-toggle='tooltip' data-placement='top' title='Thema hinzufügen'  class='badge badge-success'><a href='/add_thema.php?action=addthema&id={$dec_modul}'><i class='far fa-plus-square'></i></a></span>";
                    echo " $archivierung";
                    echo"</td>";
                    echo"</tr></table>";
                    
                // Sicherheitsabfrage, ob man das Nachrückverfahren wirklich einleiten will
                echo"<div class='modal fade' id='nachrückverfahren_$modul_id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle'  aria-hidden='true'>";
                echo"<div class='modal-dialog'>";
                echo"<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Nachrückverfahren einleiten?</h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo"<div class='modal-body'><p>";          
                echo"<div class='well'>";
                echo"Durch das Ausführen des Nachrückverfahrens wird die Endfrist des Moduls um 7 Tage, vom aktuellen Datum an, verlängert. ";
                echo"Der neue Endzeitpunkt wird somit von <b>{$aktuell_datum_anzeige}</b> auf <b>{$frist_ende_neu}</b> verlängert. <br><br>";
                echo"{$modalTextInhalte}</div></p>";
                echo"<p class='debug-url'></p>";
                echo"</div> ";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"<a href='?action=nachrückverfahren&id={$dec_modul}' style='background-color:#3979b5;' class='btn btn-primary'>Nachrückverfahren einleiten</a>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div>"; 

                // Sicherheitsabfrage, ob man das Modul wirklich archvieren will
                echo"<div class='modal fade' id='archivierung_{$modul_id}' tabindex='-1' role='dialog' aria-hidden='true'>";
                echo"<div class='modal-dialog'>";
                echo"<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Modul archvieren?</h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo"<div class='modal-body'><p>";          
                echo"<div class='well'>Wollen sie das Modul \"<b>{$modulbezeichnung}</b>\" mit den dazgehörigen Daten sicher archivieren?</div></p>";
                echo"<p class='debug-url'></p>";
                echo"</div> ";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"<a href='?action=archivierung&id={$dec_modul}' style='background-color:#3979b5;' class='btn btn-primary'>Modul archivieren</a>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                
                // Sicherheitsabfrage,  WENN MAN EIN GESAMTES MODUL LÖSCHEN WILL            
                echo"<div class='modal fade' id='delete_modal_$modul_id' tabindex='-1' role='dialog' aria-hidden='true'>";
                echo"<div class='modal-dialog'>";
                echo"<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Modul löschen?</h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo"<div class='modal-body'>";   
                echo"<div class='well'>";
                echo"<center>Wollen sie das Modul <b>\"{$modulbezeichnung}\"</b> mit den dazugehörigen Themen und Daten wirklich löschen?</center></div>";
                echo"<p class='debug-url'></p>";
                echo"</div>";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"<a href='?action=deleteModul&id=$dec_modul' class='btn btn-danger btn-ok'><i class='far fa-trash-alt'></i> Modul löschen</a>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div>";

                    echo"<inside>";
                    echo"<div id='modulid_{$modul_id}' class='collapse' role='tabpanel' aria-labelledby='headingOne' data-parent='#accordion'>";
                    echo"<table width='100%' id='mytable' class='table table-striped table-bordered table-list'>";
                    
                    while ($statement_anzahl->fetch()) {
                        while ($statement_thema->fetch()) {
                            $dec_thema = base64_encode($thema_id);
                            // Modal Text wenn nur ein Item vorhanden, dann wird im Modal eine Bemerkung erscheinen 
                            // Wenn es nur ein Thema gibt, dann wird der Delete Button zu "Modul löschen" geändert. 
                            if ($anzahl == 1) {
                                $note = "<i style='color: red;' class='fas fa-exclamation-triangle'></i> Beachten Sie, dass das Modul nur <b>dieses Thema</b> beinhaltet, somit wird durch die Löschung dieses Themas das <b>gesamte Modul</b> gelöscht.";
                                $modal_delete_btn = "<a href='?action=deleteModul&id=$dec_modul' class='btn btn-danger btn-ok'><i class='far fa-trash-alt'></i> Modul löschen</a>";
                            } else {
                                $note = "";
                                $modal_delete_btn = "<a href='?action=deleteThema&id=$dec_thema' class='btn btn-danger btn-ok'><i class='far fa-trash-alt'></i> Thema löschen</a>";
                            }

                            if ($start_dt > $heute_dt) {
                                $delete_thema_btn = "<span data-toggle='tooltip' data-placement='top' title='Thema löschen' class='badge badge-danger'><a href='?action=delete&id=$dec_thema' data-toggle='modal' data-target='#confirm-delete_{$thema_id}'><i class='far fa-trash-alt'></i></a></span>";
                            } else {
                                $delete_thema_btn = "";
                            }

                            if ($verfahren == "Bewerbungsverfahren") {
                                $einsicht_bewerbungen = "<span data-toggle='tooltip' data-placement='top' title='Bewerbungen einsehen'  class='badge badge-info'><a href='einsicht.php?action={$verfahren}&id={$dec_thema}'><i class='fas fa-users'></i></a></span>";
                            } else {
                                $einsicht_bewerbungen = "";
                            }
                            echo"<tr data-status='Verfügbar'>";
                            echo"<td style='width:57px;'></td>";
                            echo"<td style='width:395px;'>{$themenbezeichnung}</td>";
                            echo"<td style='130px;'><center>{$thema_verfügbarkeit}</center></td>";
                            echo"<td style='width:198px;' align='center'>";
                            echo"<span data-toggle='tooltip' data-placement='top' title='Thema editieren'  class='badge badge-secondary'><a href='/edit_thema.php?action=editThema&id=$dec_thema'><i class='far fa-edit'></i></a></span> "; 

                            echo"$delete_thema_btn ";
                            echo"$einsicht_bewerbungen </td>";
                            echo"</tr>";
                            
                        // MODAL -> CONFIRMATION  WENN MAN EIN THEMA LÖSCHEN WILL
                        echo"<div class='modal fade' id='confirm-delete_{$thema_id}' tabindex='0' role='dialog'>";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Thema löschen?</h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<div class='well'>";
                        echo"Sind Sie sich sicher, dass das Thema <b>\"{$themenbezeichnung}\"</b> aus dem Modul <b>\"{$modulbezeichnung}\"</b> und die dazgehörigen Daten sicher gelöscht werden sollen?<br><br><center>{$note}</center></div></center></div>";
                        echo"<div class='modal-footer'>";
                        echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                        echo"$modal_delete_btn";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";                       
                        }
                    }
                }echo"</table>";
            }
            echo"</div>";
            echo"</inside>";
        }
        echo"</div>";
        echo"</module>";
        echo"<list><div class='panel-footer'>";
        echo"<button type='button' class='btn'><a style='color:#444444' href='/modul_eintragen.php'><i class='far fa-plus-square'></i> Modul hinzufügen</a></button>";
        echo"</div>";
        echo"</list>";
        echo"</div>";
        echo"</uebersicht><br><br><br><br>";
    }

    public function nachrückverfahren($modul_id) {
        // Es werden sowohl die Fristen des Moduls benötigt
        $statement = $this->modul->getModulFristen($modul_id);
        $statement->bind_result($frist_start, $frist_ende);
        $statement->store_result();

        while ($statement->fetch()) {    
           $aktuell = date('Y-m-d'); 
           $ende_anzeige = date("d-m-Y", strtotime($frist_ende));
           $frist_ende_neu = date("Y.m.d", strtotime($aktuell . "+7 day"));

           // Damit die Zeiten in d m Y angezeigt werden
           $ende_neu_anzeige = date("d-m-Y", strtotime($frist_ende_neu));
           $ende_anzeige = date("d-m-Y", strtotime($frist_ende));
           $status = "Aktiv";
           $this->modul->updateFristEnde($modul_id, $status, $frist_ende_neu);  
            echo"<script> $(window).load(function() { $('#nachrückverfahren_success').modal('show'); }); </script>";
            echo"<success><div class='modal fade' id='nachrückverfahren_success' tabindex='0' role='dialog'>";
            echo"<div class='modal-dialog'>";
            echo"<div class='modal-content'>";
            echo"<div class='modal-header'>";
            echo"<h5 class='modal-title' id='titel'> Nackrückverfahren erfolgreich eingeleitet! </h5>";
            echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo"<span aria-hidden='true'>&times;</span></button>";
            echo"</div>";
            echo"<div class='modal-body'>";
            echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center>Das Nachrückverfahren wurde erfolgreich eingeleitet!<br>Die Endfrist wurde von <b>{$ende_anzeige}</b> auf <b>{$ende_neu_anzeige}</b> geändert. </center></div>";
            echo"<p class='debug-url'></p>";
            echo"</div>";
            echo"<div class='modal-footer'>";
            echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
            echo"</div>";
            echo"</div>";
            echo"</div>";
            echo"</div></success>";            
        }
    }

public function archivierung($modul_id){
    $this->modul->updateModulArchivierung($modul_id,"true");
 
        $statement = $this->modul->getModulbezeichnung($modul_id);
        $statement->bind_result($modulbezeichnung);
        $statement->store_result();

            while ($statement->fetch()) { 
            echo"<script> $(window).load(function() { $('#archivierung_success').modal('show'); }); </script>";
            echo"<success><div class='modal fade' id='archivierung_success' tabindex='0' role='dialog'>";
            echo"<div class='modal-dialog'>";
            echo"<div class='modal-content'>";
            echo"<div class='modal-header'>";
            echo"<h5 class='modal-title' id='titel'> Archivierung erfolgreich durchgeführt! </h5>";
            echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo"<span aria-hidden='true'>&times;</span></button>";
            echo"</div>";
            echo"<div class='modal-body'>";
            echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center>Das Modul \"<b>{$modulbezeichnung}</b>\" wurde erfolgreich archiviert.</center></div>";
            echo"<p class='debug-url'></p>";
            echo"</div>";
            echo"<div class='modal-footer'>";
            echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
            echo"</div>";
            echo"</div>";
            echo"</div>";
            echo"</div></success>";
    }
}

    public function ModulübersichtStudent($statement) {
        $statement->bind_result($modul_id, $modulbezeichnung, $kategorie, $verfahren, $semester, $frist_start, $frist_ende, $benutzer_id, $studiengang, $modul_verfuegbarkeit, $nachrueckverfahren);
        $statement->store_result();
        //Module werden aufgerufen

        while ($statement->fetch()) {       
            if($nachrueckverfahren == "Aktiv"){
                $verfahren_scheinvariable = "Windhundverfahren";
                $nachrueck_nachricht = "[Nachrückverfahren]";
            }
            else{
                $verfahren_scheinvariable = $verfahren;
                $nachrueck_nachricht = '';
            }
            
            // Aktuelle Zeit wird abgerufen
            $dec_modul = base64_encode($modul_id);
            date_default_timezone_set("Europe/Berlin");
            $aktuell_datum = date("Y-m-d");
            $heute_dt = new DateTime($aktuell_datum);
            $end_dt = new DateTime($frist_ende);
            // Ende der aktuellen Zeit

            $statement1 = $this->thema->getModulThema($modul_id);
            $statement1->bind_result($themenbezeichnung, $beschreibung, $thema_id, $thema_verfügbarkeit);
            $statement1->store_result();

            $ThemaAnzahl_verfuegbar = $this->thema->getModulThemaAnzahlVerfuegbar($modul_id, "Verfügbar");
            $ThemaAnzahl_verfuegbar->bind_result($anzahl_thema_verfuegbar);
            $ThemaAnzahl_verfuegbar->store_result();
            while ($ThemaAnzahl_verfuegbar->fetch()) {

                $start_anzeige = date("d-m-Y", strtotime($frist_start));
                $ende_anzeige = date("d-m-Y", strtotime($frist_ende));

                if (($heute_dt > $end_dt) || ($anzahl_thema_verfuegbar == "0")) {
                    $btn = "<button type='button' class='btn btn-secondary disabled btn' style='float: right; min-width: 170px; min-height: 40px; margin-bottom: 15px; margin-right:10px; margin-top: 20px; border-radius: 10px;'>Anmeldung gesperrt</button>";
                    // Wenn die Zeit ueberschritten ist, dann wird die Verfügbarkeit des Themas auf "Vergeben" gesetzt.         
                    $this->modul->updateModulVerfuegbarkeit($modul_id, "Vergeben");
                } else {
                    $this->modul->updateModulVerfuegbarkeit($modul_id, "Verfügbar");
                    $btn = "<a href='bewerbungsformular_{$verfahren}.php?action=bewerbung_{$verfahren}&id={$dec_modul}'> <button type='button' class='btn btn-success btn' style='float: right; min-width: 170px; min-height: 40px; margin-bottom: 15px; margin-right:10px; margin-top: 20px; border-radius: 10px;'>zur Anmeldung</button></a>";
                }
                
              // Wenn Nachrückverfahren aktiv ist, dann ändert sich das Verfahren zum Windhundverfahren - dh es wird kein Update durchgeführt
                $statement_nachrückverfahren = $this->modul->getModulNachrückverfahren($modul_id);
                $statement_nachrückverfahren->bind_result($nachrueckverfahren);
                $statement_nachrückverfahren->store_result();
                

                echo "<div class='modul_anzeige'>";
                echo "<table style='border-top: 4px solid #3979b5;'> ";
                echo "<tr>";
                echo "<th><a class='collapsed' style='margin-left: 10px;' data-toggle='collapse' data-parent='#accordion' href='#modul_{$modul_id}' aria-expanded='true'><i class='fa' aria-hidden='true'></i></a></th>";
                echo "<th><b><titel>{$nachrueck_nachricht} {$modulbezeichnung} {$modul_verfuegbarkeit}</titel></b><br>";
                echo "<div class='border_round'><b>{$kategorie}</b></div>";
                echo "<div class='border_round'><b>{$verfahren_scheinvariable} </b></div>";
                echo "<div class='border_round'><i class='far fa-calendar'></i> <b>{$semester}</b></div>";
                echo "<div class='border_round'><i class='far fa-clock'></i> <b>{$start_anzeige} - {$ende_anzeige}</b></div>";
                echo "</th>";
                echo "<th>$btn</th></tr>";
                echo "</table>";
                echo "<inside>";
                echo "<div id='modul_{$modul_id}' class='collapse' role='tabpanel' aria-labelledby='headingOne' data-parent='#accordion'>";
                echo "<table style='border-bottom: 0px solid #ffffff;'>";
                echo "<tr>";
                echo "<th style='width:5%' class='bold_title'><center>Info</center></th>";
                echo "<th style='width:75%' class='bold_title'><center>Titel</center></th>";
                echo "<th style='width:15%' class='bold_title'><center>Betreuer</center></th>";
                echo "<th style='width:20%' class='bold_title'><center>Verfügbarkeit</center></th>";
                echo "</tr>";
                while ($statement1->fetch()) {
                    if (empty($beschreibung)) {
                        $beschreibung = "Keine Beschreibung vorhanden.";
                    }

                    if ($thema_verfügbarkeit == 'Vergeben') {
                        $vergeben = "class='vergeben';";
                    } else {
                        $vergeben = "class='verfügbar'";
                    }
                    echo"<tr style='border-bottom: 0px solid #ffffff;'>";
                    echo"<td><a class='collapsed' style='margin-left: 10px;' data-toggle='collapse' data-parent='#accordion' href='#inhalt_{$thema_id}' aria-expanded='true'><i class='fa' aria-hidden='true'></i></a></td>";
                    echo"<td>{$themenbezeichnung}</td>";
                    echo"<td><center>{$this->benutzer->getDozent($benutzer_id)}</center></td>";
                    echo"<td><center><div $vergeben>{$thema_verfügbarkeit}</div></center></td>";
                    echo "</tr>";
                    echo "<tr class='nopadding'>";
                    echo"<td class='nopadding' colspan='6'> ";
                    echo " <div id='inhalt_{$thema_id}' class='collapse' role='tabpanel' aria-labelledby='headingOne' data-parent='#accordion'>";
                    echo " <div class='information_content'>";
                    echo " <b class='information_titel'>Inhaltliche Informationen:</b><br>";
                    echo " <div class='information_content_inhalt'> <b>Bevorzugter Studiengang:</b> {$studiengang}<br> ";
                    echo " <b>Beschreibung:</b> {$beschreibung} </div>";
                    echo " </div> </div>";
                    echo " </td></div></tr>";
                }
                echo "</table> ";
                echo "</div></div></td> </tr> </table><br>";
            }
        }
    }

    public function Modulfilter() {
        $statement_semester = $this->modul->showFilterSemester("false");
        $statement_semester->bind_result($semester, $semesterAnzahl);
        $statement_semester->store_result();
        $statement_kategorie = $this->modul->showFilterKategorie("false");
        $statement_kategorie->bind_result($kategorie, $kategorieAnzahl);
        $statement_kategorie->store_result();
        $statement_dozent = $this->modul->showFilterDozent("false");
        $statement_dozent->bind_result($dozent, $dozentAnzahl);
        $statement_dozent->store_result();
        $statement_verfuegbarkeit = $this->modul->showFilterVerfuegbarkeit("false");
        $statement_verfuegbarkeit->bind_result($modul_verfuegbarkeit, $verfuegbarkeitAnzahl);
        $statement_verfuegbarkeit->store_result();

        echo"<div style='text-align: center'>";
        echo"<div class='suche'><table style='width: 100%; text-align: center'>";
        echo"<tr>";
        echo"<th style='width: 20%; padding-right:2%;' class='tg-py0s'><b>Semester</b></th>";
        echo"<th style='width: 20%; padding-right:2%;' class='tg-py0s'><b>Art</b></th>";
        echo"<th style='width: 20%; padding-right:2%;' class='tg-py0s'><b>Betreuer</b></th>";
        echo"<th style='width: 20%; padding-right:2%;' class='tg-py0s'><b>Verfügbarkeit</b></th>";
        echo"</tr>";

        if (isset($_GET['semester'])) {
            $sem_select = trim($_GET['semester']);
        } else {
            $sem_select = '';
        };

        if (isset($_GET['kategorie'])) {
            $kat_select = trim($_GET['kategorie']);
        } else {
            $kat_select = '';
        };

        if (isset($_GET['dozent'])) {
            $dozent_select = trim($_GET['dozent']);
        } else {
            $dozent_select = '';
        };

        if (isset($_GET['modul_verfuegbarkeit'])) {
            $verfuegbarkeit_select = trim($_GET['modul_verfuegbarkeit']);
        } else {
            $verfuegbarkeit_select = '';
        };

        echo"<form style='margin-bottom: 2%;'><tr><td>";
        echo"<select style='width:150px; margin-left: 20px;' class='form-control' name='semester' onchange='this.form.submit();'>";
        echo"<option class='form-control' disabled selected></option>";
        while ($statement_semester->fetch()) {
            if ($sem_select == $semester) {
                $select = "selected='selected'; ";
            } else {
                $select = "";
            }
            echo"<option class='form-control' $select value='{$semester}'> {$semester} ({$semesterAnzahl})</option>";
        }
        echo"</select></td> ";
        echo "</form>";

        echo"<form style='margin-bottom: 2%;'><td>";
        echo"<select style='width:150px; margin-left: 20px;'class='form-control' name='kategorie' onchange='this.form.submit();'>";
        echo"<option class='form-control' disabled selected></option>";
        while ($statement_kategorie->fetch()) {
            if ($kat_select == $kategorie) {
                $select = "selected='selected'; ";
            } else {
                $select = "";
            }
            echo"<option $select class='form-control' value='{$kategorie}'> {$kategorie} ({$kategorieAnzahl})</option>";
        }
        echo"</select></td>";
        echo "</form>";

        echo"<form style='margin-bottom: 2%;'><td>";
        echo"<select style='width:150px; margin-left: 20px;'class='form-control' name='dozent' onchange='this.form.submit();'>";
        echo"<option class='form-control' disabled selected></option>";
        while ($statement_dozent->fetch()) {
            if ($dozent_select == $dozent) {
                $select = "selected='selected'; ";
            } else {
                $select = "";
            }
            echo"<option $select class='form-control' value='{$dozent}'> {$dozent} ({$dozentAnzahl})</option>";
        }
        echo"</select></td>";
        echo "</form>";

        echo"<form style='margin-bottom: 2%;'><td>";
        echo"<select style='width:150px; margin-left: 20px;'class='form-control' name='modul_verfuegbarkeit' onchange='this.form.submit();'>";
        echo"<option class='form-control' disabled selected></option>";
        while ($statement_verfuegbarkeit->fetch()) {
            if ($verfuegbarkeit_select == $modul_verfuegbarkeit) {
                $select = "selected='selected'; ";
            } else {
                $select = "";
            }
            echo"<option $select class='form-control' value='{$modul_verfuegbarkeit}'> {$modul_verfuegbarkeit} ({$verfuegbarkeitAnzahl})</option>";
        }
        echo"</select></td>";
        echo "</tr></table></form>";
        echo"</div></div>";
        echo"<br><br>";

        if (isset($_GET["semester"])) {
            $sem = $_GET["semester"];
            echo "<h5>Ergebnisse gefiltert nach {$_GET["semester"]}</h5>";
            $statement = $this->modul->getFilterModule("semester", $sem, "false");
            $this->ModulübersichtStudent($statement);
             
        } else if (isset($_GET["kategorie"])) {
            $kate = $_GET["kategorie"];
            echo "<h5>Ergebnisse gefiltert nach {$_GET["kategorie"]}</h5>";
            $statement = $this->modul->getFilterModule("kategorie", $kate,"false");
            $this->ModulübersichtStudent($statement);
          
        } else if (isset($_GET["dozent"])) {
            $doze = $_GET["dozent"];
            echo "<h5>Ergebnisse gefiltert nach {$_GET["dozent"]}</h5>";
            $statement = $this->modul->getFilterDozent($doze,"false");
            $this->ModulübersichtStudent($statement);
            
        } else if (isset($_GET["modul_verfuegbarkeit"])) {
            $verfueg = $_GET["modul_verfuegbarkeit"];
            echo "<h5>Ergebnisse gefiltert nach {$_GET["modul_verfuegbarkeit"]}</h5>";
            $statement = $this->modul->getFilterModule("modul_verfuegbarkeit", $verfueg,"false");
            $this->ModulübersichtStudent($statement);
         
        } else {
            // FILTER ENDE
            // Abfrage der Module
            echo"<h5>Alle aktuellen Module im Überblick</h5>";
            $statement = $this->modul->getAllModule("false");
            $this->ModulübersichtStudent($statement);
        }
    }

    public function altesThema($thema_id) {
        $statement = $this->thema->getThemeninfo($thema_id);
        $statement->bind_result($themenbezeichnung, $beschreibung);
        while ($statement->fetch()) {
            echo"<form method='post'>";
            echo"<div class='edit_div'>";
            echo"<table class='edit_div_table'>";
            echo"<tr>";
            echo"<td colspan='2'><h5>Bearbeitung des Themas:<br><span>{$themenbezeichnung}</span></h5></td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td><label for='titel'><b>Titel:</b><red style='color: red'>*</red> </label></td>";
            echo"<td><input type='text' name='themenbezeichnung' class='form-control' value='{$themenbezeichnung}'/></td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td><b>Beschreibung:</b></td>";
            echo"<td><textarea cols='60' rows='5' type='text' name='themenbeschreibung' class='form-control' value=''/>{$beschreibung}</textarea></td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td colspan='2'><br><input type='submit' name='thema_edit' class='btn btn-primary' value='Thema editieren'/></td>";
            echo"</tr></table></div></form>";
        }
    }

    public function updateThema($themenbezeichnung, $themenbeschreibung, $thema_id) {
        $this->thema->updateThema($themenbezeichnung, $themenbeschreibung, $thema_id);
        echo"<script> $(window).load(function() { $('#update_thema').modal('show'); }); </script>";
        echo"<success><div class='modal fade' id='update_thema' tabindex='0' role='dialog'>";
        echo"<div class='modal-dialog'>";
        echo"<div class='modal-content'>";
        echo"<div class='modal-header'>";
        echo"<h5 class='modal-title' id='titel'>Thema erfolgreich bearbeitet!</h5>";
        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
        echo"<span aria-hidden='true'>&times;</span></button>";
        echo"</div>";
        echo"<div class='modal-body'>";
        echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center><b>Das Thema wurde erfolgreich bearbeitet.</b><br>";
        echo"Gehe zur <a style='color: green;' href='mt_verwaltung.php'>Verwaltungsseite für Module und Themen</a></center></div>";
        echo"<p class='debug-url'></p>";
        echo"</div>";
        echo"<div class='modal-footer'>";
        echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
        echo"</div>";
        echo"</div>";
        echo"</div>";
        echo"</div></success>";
    }

    public function addThema($modul_id) {
        $thema = $_POST['themenbezeichnung'];
        $beschreibung = $_POST['themenbeschreibung'];
        if (!empty($thema) && !empty($beschreibung)) {
            for ($i = 0; $i < count($thema); $i++) {
                if (!empty($thema[$i])) {
                    $thema_array = $thema[$i];
                    if (!empty($beschreibung[$i])) {
                        $beschreibung_array = $beschreibung[$i];
                        $this->thema->insertThema($modul_id, $thema_array, $beschreibung_array);
                    } else {
                        $this->thema->insertThema($modul_id, $thema_array, '');
                    }
                }
            } // Text Inhalt wenn ein/mehrere Themen hochgeladen wurden
            if ($i > 1) {
                $text_inhalt = "Die Themen wurden";
            } else {
                $text_inhalt = "Das Thema wurde";
            }
            echo"<script> $(window).load(function() { $('#add_thema').modal('show'); }); </script>";
            echo"<success><div class='modal fade' id='add_thema' tabindex='0' role='dialog'>";
            echo"<div class='modal-dialog'>";
            echo"<div class='modal-content'>";
            echo"<div class='modal-header'>";
            echo"<h5 class='modal-title' id='titel'>$text_inhalt hinzugefügt! </h5>";
            echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo"<span aria-hidden='true'>&times;</span></button>";
            echo"</div>";
            echo"<div class='modal-body'>";
            echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center><b>$text_inhalt erfolgreich zum Modul hinzugefügt.</b></center></div>";
            echo"<p class='debug-url'></p>";
            echo"</div>";
            echo"<div class='modal-footer'>";
            echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
            echo"</div>";
            echo"</div>";
            echo"</div>";
            echo"</div></success>";
        }
    }

    public function deleteThema($thema_id) {
        $statement_modulID = $this->thema->getModulId($thema_id);
        $statement_modulID->bind_result($modul_id);
        $statement_modulID->store_result();

        // Hier wird die Anzahl der themen ID geholt, um zu prüfen, ob es bereits gelöscht worden ist.
        $statement_vorhanden = $this->thema->getThemaAnzahl($thema_id);
        $statement_vorhanden->bind_result($anzahl);
        $statement_vorhanden->store_result();

        while ($statement_vorhanden->fetch()) {

            // ANFANG
            //Es soll geprüft werden, ob das Thema noch vorhanden ist bzw. bereits gelöscht wurde.
            // das Thema nicht existiert (dh anzahl der id = 0), dann erscheint eine Fehlermeldung
            if ($anzahl > 0) {
                while ($statement_modulID->fetch()) {
                    $statement_frist = $this->modul->fristKontrolle($modul_id);
                    $statement_frist->bind_result($frist_start);
                    $statement_frist->store_result();

                    while ($statement_frist->fetch()) {
                        date_default_timezone_set("Europe/Berlin");
                        $aktuell = new DateTime(date("Y-m-d"));
                        $start = new DateTime($frist_start);

                        if ($start < $aktuell) {
                            echo"<div style='top: 30%' class='modal fade' id='deleted_thema' tabindex='0' role='dialog' aria-labelledby='deleted}' >";
                            echo"<div class='modal-dialog'>";
                            echo"<div class='modal-content'>";
                            echo"<div class='modal-header'>";
                            echo"<h5 class='modal-title' id='titel'>Fehler aufgetreten!</h5>";
                            echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                            echo"<span aria-hidden='true'>&times;</span></button>";
                            echo"</div>";
                            echo"<div class='modal-body'>";
                            echo"<p><div style='float:left; width:100%;' class='alert alert-danger' role='alert'> <img style='float:left;' src='img/ups.png'><center><b>Der Anmeldezeitraum ist bereits eingetroffen. <br>Das Thema konnte nicht gelöscht werden.</b></center></div></p>";
                            echo"<p class='debug-url'></p>";
                            echo"</div>";
                            echo"<div class='modal-footer'>";
                            echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                            echo"</div>";
                            echo"</div>";
                            echo"</div>";
                            echo"</div>";
                        } else {
                            $this->thema->deleteThema($thema_id);
                            //MODAL -> THEMA ERFOLGREICH LÖSCHEN CONFIRMATION 
                            echo"<script> $(window).load(function() { $('#thema_deleted').modal('show'); }); </script>";
                            echo"<success><div class='modal fade' id='thema_deleted' tabindex='0' role='dialog'>";
                            echo"<div class='modal-dialog'>";
                            echo"<div class='modal-content'>";
                            echo"<div class='modal-header'>";
                            echo"<h5 class='modal-title' id='titel'>Das Thema wurde gelöscht!</h5>";
                            echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                            echo"<span aria-hidden='true'>&times;</span></button>";
                            echo"</div>";
                            echo"<div class='modal-body'>";
                            echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center><b>Das Thema wurde erfolgreich gelöscht!</b><br><br></center></div>";
                            echo"<p class='debug-url'></p>";
                            echo"</div>";
                            echo"<div class='modal-footer'>";
                            echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                            echo"</div>";
                            echo"</div>";
                            echo"</div>";
                            echo"</div></success>";
                        }
                    }
                }
            } else {
                //MODAL THEMA EXISTIERT NICHT  -> CONFIRMATION 
                echo"<div style='top: 30%' class='modal fade' id='deleted_thema' tabindex='0' role='dialog' aria-labelledby='deleted}' >";
                echo"<div class='modal-dialog'>";
                echo"<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'>Fehler aufgetreten!</h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo"<div class='modal-body'>";
                echo"<p><div style='float:left; width:100%;' class='alert alert-danger' role='alert'> <img style='float:left;' src='img/ups.png'><center><br><b>Das Thema wurde bereits gelöscht.</b></center></div></p>";
                echo"<p class='debug-url'></p>";
                echo"</div>";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
            }
        }
    }

    public function deleteModul($modul_id) {
        $statement_anzahl = $this->modul->getModulAnzahl($modul_id);
        $statement_anzahl->bind_result($anzahl_modul);
        $statement_anzahl->store_result();

        $statement_frist = $this->modul->fristKontrolle($modul_id);
        $statement_frist->bind_result($frist_start);
        $statement_frist->store_result();

        while ($statement_anzahl->fetch()) {
            if ($anzahl_modul > 0) {
                while ($statement_frist->fetch()) {
                    date_default_timezone_set("Europe/Berlin");
                    $aktuell = new DateTime(date("Y-m-d"));
                    $start = new DateTime($frist_start);
                    if ($start < $aktuell) {
                        echo"<div class='modal fade' id='deleted_modul' tabindex='0' role='dialog' aria-labelledby='deleted}' >";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' id='titel'>Fehler aufgetreten!</h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<p><div style='float:left; width:100%;' class='alert alert-danger' role='alert'> <img style='float:left;' src='img/ups.png'><center><b>Der Anmeldezeitraum ist bereits eingetroffen.<br>";
                        echo"Das Modul konnte nicht gelöscht werden.</b></center></div></p>";
                        echo"<p class='debug-url'></p>";
                        echo"</div>";
                        echo"<div class='modal-footer'>";
                        echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                    } else {
                        $this->modul->deleteModul($modul_id);
                        //MODAL -> Modul ERFOLGREICH LÖSCHEN CONFIRMATION 
                        echo"<script> $(window).load(function() { $('#deleted_modul').modal('show'); }); </script>";
                        echo"<success><div class='modal fade' id='deleted_modul' tabindex='0' role='dialog'>";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' id='titel'>Das Modul wurde gelöscht!</h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<div class='alert alert-success' role='alert'> <img src='img/checked.png'><center><b>Das Modul und die dazugehörigen Themen und Daten wurden erfolgreich gelöscht.</b></center></div>";
                        echo"<p class='debug-url'></p>";
                        echo"</div>";
                        echo"<div class='modal-footer'>";
                        echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div></success>";
                    }
                }
            } else {
                //MODAL MODUL EXISTIERT NICHT  -> CONFIRMATION 
                echo"<div style='top: 30%' class='modal fade' id='deleted_thema' tabindex='0' role='dialog' aria-labelledby='deleted}' >";
                echo"<div class='modal-dialog'>";
                echo"<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'>Fehler aufgetreten!</h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo"<div class='modal-body'>";
                echo"<p><div style='float:left; width:100%;' class='alert alert-danger' role='alert'> <img style='float:left;' src='img/ups.png'><center><br><b>Das Modul wurde bereits gelöscht.</b></center></div></p>";
                echo"<p class='debug-url'></p>";
                echo"</div>";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
            }
        }
    }

    public function updateModul($modul_id) {
        $kategorie = $_POST['Kategorie'];
        $modulbezeichnung = $_POST['Bezeichnung'];
        // $start = $_POST["Start"];
        // $ende = $_POST["Ende"];
        $semester = $_POST["Semester"];
        $studiengang = $_POST["Studiengang"];
        $verfahren = $_POST["verfahren"];

        $start_datum = $_POST["Start"]; // DD MM YY
        $start = date("Y-m-d", strtotime($start_datum));

        $ende_datum = $_POST["Ende"];
        $ende = date("Y-m-d", strtotime($ende_datum));

        $this->modul->updateModul($kategorie, $modulbezeichnung, $start, $ende, $semester, $studiengang, $verfahren, $modul_id);
        echo"<script> $(window).load(function() { $('#modulupdate_success').modal('show'); }); </script>";
        echo"<success><div class='modal fade' id='modulupdate_success' tabindex='0' role='dialog' >";
        echo"<div class='modal-dialog'>";
        echo"<div class='modal-content'>";
        echo"<div class='modal-header'>";
        echo"<h5 class='modal-title' id='titel'>Modul erfolgreich bearbeitet!</h5>";
        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
        echo"<span aria-hidden='true'>&times;</span></button>";
        echo"</div>";
        echo"<div class='modal-body'>";
        echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center><b>Das Modul wurde erfolgreich bearbeitet.</b><br>";
        echo"Gehe zur <a style='color: green;' href='mt_verwaltung.php'>Verwaltungsseite für Module und Themen</a></center></div>";
        echo"<p class='debug-url'></p>";
        echo"</div>";
        echo"<div class='modal-footer'>";
        echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
        echo"</div>";
        echo"</div>";
        echo"</div>";
        echo"</div></success>";
    }

}

?>