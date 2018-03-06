<?php

include("header.php");

$host = "127.0.0.1";
$port = 3306;
$socket = "";
$user = "web171";
$password = "s5TZ.MZqEBuD";
$dbname = "web171db";
$dbh = new mysqli($host, $user, $password, $dbname, $port, $socket);
$dbh->set_charset("utf8");
?>


<h4>Verwaltung der Module und Modulthemen</h4><br>
<div class="form_thema">
    <div class="form_ueberschrift"><i class="fa fa-info-circle" aria-hidden="true"></i> Zur Verwaltung der Module und Themen</div><br>
    Auf der Verwaltungsseite für Module und Modulthemen, können folgende Funktionen ausgeführt werden:
    <ul>
        <li>Module können <b>bearbeitet</b> und <b>gelöscht</b> werden.</li>
        <li>Existiert nur <b>ein Thema im Modul</b>, das gelöscht werden soll, wird das <b>gesamte Modul</b> gelöscht.</li>
        <li>Zudem können zu den Modulen Bewerbungen eingesehen und verwaltet werden.</li>
        <li>Modulthemen können <b>bearbeitet</b> und <b>gelöscht</b> werden.</li>
        <li>Es können zudem Themen zusätzlich zu den Modulen hinzugefügt werden.</li>
    </ul>
    Es können keine Module und Themen gelöscht werden, sobald der Starttermin eingetroffen ist.<br>
    Sobald der Starttermin gültig ist, sind keine Bearbeitungen im Bezug auf das ausgewählte Verfahren und Termine mehr möglich.<br>
</div>
<br>
<br><br>

Randnotiz:<br>
wenn nur ein them vorhanden ist, was gelöscht werden soll, wird das gesamte modul gelöscht (da bedingung minds. 1 thema)<br>
Fehlermeldungen wenn: <br>
1. Wenn man in der URL eingibt: id=x, was nicht existiert, dann kommt auch eine Fehlermeldung, dass das Modul bereits gelöscht wurde.(Kann haeufig passieren, wenn mehere Admins zur gleichen Zeit tätig sind)<br>
2. Wenn man versucht, ein Thema zu löschen, wobei der Anmeldezeitraum bereits eingetroffen ist<br>
3. Wenn das Thema geloescht werden konnte, erscheint eine Meldung (erfolgreich gelöscht)<br>
4. Das selbe gilt für Module. <br>

<br>

<?php

// DELETE THEMA ACTION WIRD AUSGELÖST
// Wenn der Delete via link getätigt wurde und dieser "deleteThema" heisst, und die Variable ID existiert und nicht NULL ist dann wird weiter die ausgeführt
if (isset($_GET['action']) && $_GET['action'] == 'deleteThema' && isset($_GET['id'])) {

// Da der Anmeldezeitraum geprüft werden soll, wird zunächst die modul id durch die uebermittelte thema id geholt
    $stmt_pruefung_zeit = "SELECT modul_id FROM thema WHERE thema_id = ?";
    $stmt_zeit = $dbh->prepare($stmt_pruefung_zeit);
    $stmt_zeit->bind_param('i', $_GET['id']);
    $stmt_zeit->execute();
    $stmt_zeit->bind_result($modul_id);
    $stmt_zeit->store_result();

    // Hier wird die Anzahl der themen ID geholt
    $stmt_pruefung = "SELECT count(thema_id) as anzahl FROM thema WHERE thema_id = ?";
    $stmt_vorhanden = $dbh->prepare($stmt_pruefung);
    $stmt_vorhanden->bind_param('i', $_GET['id']);
    $stmt_vorhanden->execute();
    $stmt_vorhanden->bind_result($anzahl);
    $stmt_vorhanden->store_result();
    while ($stmt_vorhanden->fetch()) {

// ANFANG
        //Es soll geprüft werden, ob das Thema noch vorhanden ist bzw. bereits gelöscht wurde.
        // das Thema nicht existiert (dh anzahl der id = 0), dann erscheint eine Fehlermeldung
        if ($anzahl > 0) {
            while ($stmt_zeit->fetch()) {
                $stmt_pruefung_zeit2 = "SELECT frist_start FROM modul WHERE modul_id = ?";
                $stmt_zeit2 = $dbh->prepare($stmt_pruefung_zeit2);
                $stmt_zeit2->bind_param('i', $modul_id);
                $stmt_zeit2->execute();
                $stmt_zeit2->bind_result($frist_start);
                $stmt_zeit2->store_result();

                while ($stmt_zeit2->fetch()) {
                    date_default_timezone_set("Europe/Berlin");
                    $aktuelles_datum = date("Y-m-d");
                    $aktuell = new DateTime($aktuelles_datum);
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
                        $delete = "DELETE FROM thema WHERE thema_id=?";
                        $delete_statement = $dbh->prepare($delete);
                        $delete_statement->bind_param('i', $_GET['id']);
                        $delete_statement->execute();

                        //MODAL -> THEMA ERFOLGREICH LÖSCHEN CONFIRMATION 
                        echo"<div style='top: 30%' class='modal fade' id='deleted_thema' tabindex='0' role='dialog' aria-labelledby='deleted}' >";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' id='titel'>Thema gelöscht!</h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<p><div style='float:left; width:100%;'class='alert alert-success' role='alert'> <img style='float:left;' src='img/checked.png'><center><br><b>Das Thema wurde erfolgreich gelöscht.</b></center></div></p>";
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
// ENDE
// ANFANG
// WENN MAN EIN MODUL LÖSCHEN WILL 
if (isset($_GET['action']) && $_GET['action'] == 'deleteModul' && isset($_GET['id'])) {
    $stmt_pruefung_modul_anzahl = "SELECT count(modul_id) as anzahl_modul FROM modul WHERE modul_id = ?";
    $stmt_modul_anzahl = $dbh->prepare($stmt_pruefung_modul_anzahl);
    $stmt_modul_anzahl->bind_param('i', $_GET['id']);
    $stmt_modul_anzahl->execute();
    $stmt_modul_anzahl->bind_result($anzahl_modul);
    $stmt_modul_anzahl->store_result();

    $stmt_modul_pruefung_zeit = "SELECT frist_start FROM modul WHERE modul_id = ?";
    $stmt_modul_zeit = $dbh->prepare($stmt_modul_pruefung_zeit);
    $stmt_modul_zeit->bind_param('i', $_GET['id']);
    $stmt_modul_zeit->execute();
    $stmt_modul_zeit->bind_result($frist_start);
    $stmt_modul_zeit->store_result();

    while ($stmt_modul_anzahl->fetch()) {
        if ($anzahl_modul > 0) {

            while ($stmt_modul_zeit->fetch()) {
                date_default_timezone_set("Europe/Berlin");
                $aktuelles_datum = date("Y-m-d");
                $aktuell = new DateTime($aktuelles_datum);
                $start = new DateTime($frist_start);

                if ($start < $aktuell) {
                    echo"<div style='top: 30%' class='modal fade' id='deleted_modul' tabindex='0' role='dialog' aria-labelledby='deleted}' >";
                    echo"<div class='modal-dialog'>";
                    echo"<div class='modal-content'>";
                    echo"<div class='modal-header'>";
                    echo"<h5 class='modal-title' id='titel'>Fehler aufgetreten!</h5>";
                    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo"<span aria-hidden='true'>&times;</span></button>";
                    echo"</div>";
                    echo"<div class='modal-body'>";
                    echo"<p><div style='float:left; width:100%;' class='alert alert-danger' role='alert'> <img style='float:left;' src='img/ups.png'><center><b>Der Anmeldezeitraum ist bereits eingetroffen. <br>Das Modul konnte nicht gelöscht werden.</b></center></div></p>";
                    echo"<p class='debug-url'></p>";
                    echo"</div>";
                    echo"<div class='modal-footer'>";
                    echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                } else {

                    $delete = "DELETE FROM thema WHERE modul_id=?";
                    $delete_statement = $dbh->prepare($delete);
                    $delete_statement->bind_param('i', $_GET['id']);
                    $delete_statement->execute();
                    
                    $delete = "DELETE FROM modul WHERE modul_id=?";
                    $delete_statement = $dbh->prepare($delete);
                    $delete_statement->bind_param('i', $_GET['id']);
                    $delete_statement->execute();
                     
                        //MODAL -> THEMA ERFOLGREICH LÖSCHEN CONFIRMATION 
                        echo"<div style='top: 30%' class='modal fade' id='deleted_modul' tabindex='0' role='dialog' aria-labelledby='deleted}' >";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' id='titel'>Modul gelöscht!</h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<p><div style='float:left; width:100%;'class='alert alert-success' role='alert'> <img style='float:left;' src='img/checked.png'><center><br><b>Das Modul und die dazugehörigen Themen und Daten wurde erfolgreich gelöscht.</b></center></div></p>";
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
// ENDE


$stmt = "SELECT modul_id,  modulbezeichnung, kategorie, verfahren, semester, jahr, frist_start, frist_ende, id FROM modul";
$statement = $dbh->prepare($stmt);
$statement->execute();
$statement->bind_result($modul_id, $modulbezeichnung, $kategorie, $verfahren, $semester, $jahr, $frist_start, $frist_ende, $id);
$statement->store_result();

echo"<verwaltung>";
echo" <table>";
echo" <tr>";
echo"<th style='width:80%'>Modul</th>";
echo"<th style='width:20%'>Funktionen</th>";
echo"</tr>";
echo"</table>";

while ($statement->fetch()) {
    // Aktuelle Zeit wird abgerufen
    date_default_timezone_set("Europe/Berlin");
    $aktuell_datum = date("Y-m-d");
    $heute_dt = new DateTime($aktuell_datum);
    $start_dt = new DateTime($frist_start);

    // Wenn der Starttermin noch nicht eingetroffen ist, dann können Themen noch gelöscht werden
    if ($start_dt > $heute_dt) {
        $delete_modul_btn = "<a href='?action=deleteModul&id={$modul_id}' data-toggle='modal' data-target='#confirm-delete_{$modul_id}'><i style='color:red;' class='fa fa-minus-circle' aria-hidden='true'></i></a>";
    } else {
        $delete_modul_btn = "";
    }

    // Themen werden geholt in Abh. der ID des Moduls
    $stmt1 = "SELECT themenbezeichnung,beschreibung, thema_id FROM thema WHERE modul_id = ?";
    $statement1 = $dbh->prepare($stmt1);
    $statement1->bind_param('i', $modul_id);
    $statement1->execute();
    $statement1->bind_result($themenbezeichnung, $beschreibung, $thema_id);
    $statement1->store_result();

    // Anzahl der Themen in Abhängigkeit des Moduls
    $stmt3 = "SELECT count(thema_id) as anzahl from thema WHERE modul_id = ? group by modul_id";
    $statement3 = $dbh->prepare($stmt3);
    $statement3->bind_param('i', $modul_id);
    $statement3->execute();
    $statement3->bind_result($anzahl);
    $statement3->store_result();

    echo"<table>";
    echo"<tr>";
    echo"<td style='border-left: 3px solid #3979b5; width:80%'>";
    echo"<a style='font-size:15px;' href='#modul_{$modul_id}' data-toggle='collapse' aria-expanded='true' aria-controls='modul_{$modul_id}'><b>{$modulbezeichnung}</b></a><br>";
    echo"<small>{$frist_start} - {$frist_ende}</small> <small>{$verfahren}</small></td>";
    echo"<td style='width:20%'> $delete_modul_btn <a href='/edit_modul.php?action=editModul&id={$modul_id}'><i class='fa fa-cog' aria-hidden='true'></i></a></td>";
    echo"</tr>";

    // MODAL -> CONFIRMATION  WENN MAN EIN GESAMTES MODUL LÖSCHEN WILL
    echo"<div style='top: 30%' class='modal fade' id='confirm-delete_{$modul_id}' tabindex='0' role='dialog' aria-labelledby='thema_confirmation_{$modul_id}' >";
    echo"<div class='modal-dialog'>";
    echo"<div class='modal-content'>";
    echo"<div class='modal-header'>";
    echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Modul löschen</h5>";
    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo"<span aria-hidden='true'>&times;</span></button>";
    echo"</div>";
    echo"<div class='modal-body'>";
    echo"<p>Wollen sie das Modul <b>\"{$modulbezeichnung}\"</b> mit den dazugehörigen Themen und Daten wirklich löschen?</p>";
    echo"<p class='debug-url'></p>";
    echo"</div>";
    echo"<div class='modal-footer'>";
    echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
    echo"<a href='?action=deleteModul&id={$modul_id}' class='btn btn-danger btn-ok'>Modul löschen</a>";
    echo"</div>";
    echo"</div>";
    echo"</div>";
    echo"</div>";

    echo"</table>";
    echo"<div id='modul_{$modul_id}' class='collapse' role='tabpanel' aria-labelledby='headingOne' data-parent='#accordion'>";
    echo"<table><liste>";

    // Modal Text wenn nur ein Item vorhanden, dann wird im Modal eine Bemerkung erscheinen 
    // Wenn es nur ein Thema gibt, dann wird der Delete Button zu "Modul löschen" geändert. 
    while ($statement3->fetch()) {
        while ($statement1->fetch()) {
            if ($anzahl == 1) {
                $note = "<div class='alert alert-danger' role='alert'><b>Bemerkung:</b> Da das Modul nur dieses Thema beinhaltet, wird durch Löschung dieses Themas das gesamte Modul gelöscht.</div>";
                $modal_delete_btn = "<a href='?action=deleteModul&id={$modul_id}' class='btn btn-danger btn-ok'>Modul löschen</a>";
            } else {
                $note = "";
                $modal_delete_btn = "<a href='?action=deleteThema&id={$thema_id}' class='btn btn-danger btn-ok'>Thema löschen</a>";
            }

            if ($start_dt > $heute_dt) {
                $delete_thema_btn = "<a href='?action=delete&id={$thema_id}' data-toggle='modal' data-target='#confirm-delete_{$thema_id}'><i style='color:red;' class='fa fa-minus-circle' aria-hidden='true'></i></a>";
            } else {
                $delete_thema_btn = "";
            }

            echo"<tr><td style='width:5%; border-left: 3px solid #99ccff;'>{$thema_id}.</td>";
            echo"<td style='width:75%;'>{$themenbezeichnung}</td>";
            echo"<td style='width:20%'> $delete_thema_btn ";
            echo"<a href='/edit_thema.php?action=editThema&id={$thema_id}'><i class='fa fa-cog' aria-hidden='true'></i></td></tr>";

            // MODAL -> CONFIRMATION  WENN MAN EIN THEMA LÖSCHEN WILL
            echo"<div style='top: 30%' class='modal fade' id='confirm-delete_{$thema_id}' tabindex='0' role='dialog' aria-labelledby='thema_confirmation_{$thema_id}' >";
            echo"<div class='modal-dialog'>";
            echo"<div class='modal-content'>";
            echo"<div class='modal-header'>";
            echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Thema löschen</h5>";
            echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo" <span aria-hidden='true'>&times;</span></button>";
            echo"</div>";
            echo"<div class='modal-body'>";
            echo"<p>Wollen Sie das Thema <b>\"{$themenbezeichnung}\"</b>  aus dem Modul <b>\"{$modulbezeichnung}\"</b> und die dazgehörigen Daten sicher löschen? <br><br> {$note}</p>";
            echo"<p class='debug-url'></p>";
            echo"</div>";
            echo"<div class='modal-footer'>";
            echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
            echo"$modal_delete_btn";
            echo"</div>";
            echo"</div>";
            echo"</div>";
            echo"</div>";
        }
    }
    echo" </liste>";
    echo"<tr><td><a href='add_thema_{$modul_id}'><i class='fa fa-plus' aria-hidden='true'></i></a></td></tr>";
    echo"</table></div>";
}
echo"</verwaltung> <br><br>";

include("navi.php");
include("footer.php");
?>  
