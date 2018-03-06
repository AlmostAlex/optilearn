<?php
include ("header.php");
include ("Controllers/modul_controller.php");
?>

<br><br>
<div style='width: 95%; margin: 0%; font-size: 1.0rem;' class="verwaltungsbox">
        <h4 class='card-title'><i class="fa fa-info-circle" aria-hidden="true"></i> Zur Verwaltung der Module und Themen</h4>
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

<?php

// DELETE THEMA ACTION WIRD AUSGELÖST
// Wenn der Delete via link getätigt wurde und dieser "deleteThema" heisst, und die Variable ID existiert und nicht NULL ist dann wird weiter die ausgeführt
if (isset($_GET['action']) && $_GET['action'] == 'deleteThema' && isset($_GET['id'])) 
{
    $thema_id = base64_decode($_GET['id']);
    $delete_thema = new modul_controller();
    $delete_thema->deleteThema($thema_id); 
}

// DELETE MODUL ACTION WIRD AUSGELÖST
if (isset($_GET['action']) && $_GET['action'] == 'deleteModul' && isset($_GET['id'])) 
{
    $modul_id = base64_decode($_GET['id']);
    $delete = new modul_controller();
    $delete->deleteModul($modul_id);
}

if (isset($_GET['action']) && $_GET['action'] == 'nachrückverfahren' && isset($_GET['id'])) 
{
    $modul_id = base64_decode($_GET['id']);
    $delete = new modul_controller();
    $delete->nachrückverfahren($modul_id);
}



echo "<verwaltung>";
echo "<table>";
    echo"<tr>";
        echo"<th style='width:80%'>Modul</th>";
        echo"<th style='width:20%'>Funktionen</th>";
    echo"</tr>";
echo"</table>";

$Übersicht = new modul_controller();
$Übersicht->ModulübersichtDozent();

echo"</verwaltung> <br><br>";


if (isset($_GET['action']) && $_GET['action'] == 'auswertung' && isset($_GET['id'])) {
$modul_id = base64_decode($_GET['id']);

    $auswertung = new belegwunsch_controller();
    $auswertung->Belegwunschauswertung($modul_id);

}



include("navi.php");
include("footer.php");
?>  