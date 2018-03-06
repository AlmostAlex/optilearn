<?php
include ("header.php");
include ("Controllers/bewerbung_controller.php");
?>
<br><br>
<?php
$modul_id = base64_decode($_GET['id']);
// BEWERBUNGSVERFAHREN
if (isset($_GET['action']) && $_GET['action'] == 'bewerbung_Bewerbungsverfahren' && isset($_GET['id'])) 
{
    echo "<div style='width: 100%; margin:0%; font-size: 1.0rem;' class='verwaltungsbox'>";
    echo "<h4 class='card-title'><i class='fa fa-info-circle' aria-hidden='true'></i> Informationen zur Bewerbung</h4>";
    echo "Um eine Bewerbung durchzuführen, sind folgende Hinweise zu beachten:<br>";
    echo "<ul>";
    echo "<li>Informieren Sie sich auf der <a href='index.php'>Informationsseite</a> über das Bewerbungsverfahren.</li>";
    echo "<li>Alle <b>Pflichtfelder ( <red style='color: red'>*</red> )</b> sind auszufüllen.</li>";
    echo "<li>Alle Angaben sind wahrheitsgemäß auszufüllen.</li>";        
    echo "<li>Eine Auswertung erfolgt erst nach Fristende.</li>";
    echo "<li>Eine Zu- oder Absage zur Bewerbung erhalten Sie nach Fristende und durch eine <b>Benachrichtung</b> über Ihre angegebene E-Mail-Adresse.</li>";
    echo "</ul>";
    echo "</div><br>";
    
    $bewerbung = new bewerbung_controller();
    $bewerbung->Bewerbungsformular($modul_id);
    
}

include("navi.php");
include("footer.php");
?>  
