<?php
include ("header.php");
include ("Controllers/windhund_controller.php");
?>
<br><br>
<?php
$modul_id = base64_decode($_GET['id']);
// WINDHUNDVERFAHREN
if(isset($_GET['action']) && $_GET['action'] == 'bewerbung_Windhundverfahren' && isset($_GET['id'])) 
{
    echo "<div style='width: 100%; margin:0%; font-size: 1.0rem;' class='verwaltungsbox'>";
    echo "<h4 class='card-title'><i class='fa fa-info-circle' aria-hidden='true'></i> Informationen zur Bewerbung</h4>";
        echo "Um eine Anmeldung durchzuführen, sind folgende Hinweise zu beachten:<br>";
        echo "<ul>";
            echo "<li>Informieren Sie sich auf der <a href='index.php'>Informationsseite</a> über das Windhundverfahren.</li>";
            echo "<li>Alle <b>Pflichtfelder ( <red style='color: red'>*</red> )</b> sind auszufüllen.</li>";
            echo "<li>Nach Absenden des Formuolars, werden Sie <b>sofort</b> für das gewünschte Thema eingetragen.</li>";
            echo "<li>Nach Abmeldefrist erhalten Sie <b>Benachrichtung</b> über Ihre angegebene E-Mail-Adresse.</li>";
        echo "</ul>";
    echo "</div><br>";

    $windhund = new windhund_controller();
    $windhund->Windhundformular($modul_id);
}


include("navi.php");
include("footer.php");
?>  