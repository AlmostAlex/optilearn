<?php
include "header.php";
?>
<br>

<div style='font-size: 1.0rem;' class="verwaltungsbox">
    <h4 class='card-title'>Verwaltungsbereich</h4>
            Folgende Funktionen stehen zur Verfügung: <br>
        <b>1.</b> Es können Module mit den dazugehörigen Themen eingetragen werden.<br>
        <b>2.</b> Es können eingetragene Module und Themen verwaltet, bearbeitet und gelöscht werden.<br>
        <b>3.</b> Zudem können Themen nachträglich zum Modul hinzugefügt werden.<br>
        <b>4.</b> Es kann ein Report erstellt und exportiert werden.
</div>
 
<div style='margin-left:10%;'class="Verwaltungsbereich">
        <ul>
                <li class='Thema_uebersicht'><a href='/mt_verwaltung.php'>Übersicht &<br>Verwaltung<span></span></a></li>
                <li class='thema_hochladen'><a href='/blubb'>Archivierung<br>von Modulen<span></span></a></li>
                <li class='inf_verwalten'><a href='/modul_eintragen.php'>Modul <br>eintragen<span></span></a></li>
                <li class='report_erstellen'><a href='/reporting.php'>Report <br>erstellen<span></span></a></li>
        </ul>
</div>

<?php
include "navi.php";
include "footer.php";
?>


