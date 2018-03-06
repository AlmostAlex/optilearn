<?php
include ("header.php");
include ("Controllers/bewerbung_controller.php");
?>

<?php
$modul_id = base64_decode($_GET['id']);
// WINDHUNDVERFAHREN
if(isset($_GET['action']) && $_GET['action'] == 'bewerbung_Windhundverfahren' && isset($_GET['id'])) 
{
    echo "<div class='form_thema'>";
        echo "<div class='form_ueberschrift'><i class='fa fa-info-circle' aria-hidden='true'></i> Informationen zur Bewerbung</div><br> ";
        echo "Um eine Anmeldung durchzuführen, sind folgende Hinweise zu beachten:<br>";
        echo "<ul>";
            echo "<li>Informieren Sie sich auf der <a href='index.php'>Informationsseite</a> über das Windhundverfahren.</li>";
            echo "<li>Alle <b>Pflichtfehlder ( <red style='color: red'>*</red> )</b> sind auszufüllen.</li>";
            echo "<li>Nach Absenden des Formuolars, werden Sie <b>sofort</b> für das gewünschte Thema eingetragen.</li>";
            echo "<li>Nach erfolgreicher Anmeldung, erhalten sie eine <b>Benachrichtung</b> über Ihre angegebene E-Mail-Adresse.</li>";
        echo "</ul>";
    echo "</div><br>";

    $windhund = new bewerbung_controller();
    $windhund->Windhundformular($modul_id);
}

// BEWERBUNGSVERFAHREN
elseif (isset($_GET['action']) && $_GET['action'] == 'bewerbung_Bewerbungsverfahren' && isset($_GET['id'])) 
{
    echo "<div class='form_thema'>";
    echo "<div class='form_ueberschrift'><i class='fa fa-info-circle' aria-hidden='true'></i> Informationen zur Bewerbung</div><br> ";
    echo "Um eine Anmeldung durchzuführen, sind folgende Hinweise zu beachten:<br>";
    echo "<ul>";
    echo "<li>Informieren Sie sich auf der <a href='index.php'>Informationsseite</a> über das Bewerbungsverfahren.</li>";
    echo "<li>Alle <b>Pflichtfehlder ( <red style='color: red'>*</red> )</b> sind auszufüllen.</li>";
    echo "<li>Alle Angaben sind wahrheitsgemäß auszufüllen.</li>";        
    echo "<li>Eine Auswertung erfolgt erst nach Fristende.</li>";
    echo "<li>Eine Zu- oder Absage zur Bewerbung erhalten Sie nach Fristende und durch eine <b>Benachrichtung</b> über Ihre angegebene E-Mail-Adresse.</li>";
    echo "</ul>";
    echo "</div><br>";
    
    $bewerbung = new bewerbung_controller();
    $bewerbung->Bewerbungsformular($modul_id);

    if(isset($_POST["bewerbung_bewerbung"]))
    {
        $vorname = $_POST["Vorname"];
        $nachname = $_POST["Nachname"];
        $matrikelnummer = $_POST["Matrikelnummer"];
        $email = $_POST["Email"];
        if (isset($_POST['Thema2'])) {
            $thema_id2 = $_POST['Thema2'];
        }
        $credit_anzahl = $_POST['Credit_Anzahl'];
        if (isset($_POST['Studiengang2'])) {
            $studiengang2 = $_POST['Studiengang2'];
        }
        $fachsemester = $_POST['Fachsemester'];
        $bewerbung = new bewerbung_controller();
        $bewerbung->Bewerbungbewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id2, $studiengang2, $fachsemester, $credit_anzahl, $modul_id);
    }

}

// BELEGWUNSCH
elseif (isset($_GET['action']) && $_GET['action'] == 'bewerbung_Belegwunschverfahren' && isset($_GET['id'])) 
{
    echo "<div class='form_thema'>";
    echo "<div class='form_ueberschrift'><i class='fa fa-info-circle' aria-hidden='true'></i> Informationen zur Bewerbung</div><br> ";
    echo "Um eine Anmeldung durchzuführen, sind folgende Hinweise zu beachten:<br>";
    echo "<ul>";
    echo "<li>Informieren Sie sich auf der <a href='index.php'>Informationsseite</a> über das Bewerbungsverfahren.</li>";
    echo "<li>Alle <b>Pflichtfehlder ( <red style='color: red'>*</red> )</b> sind auszufüllen.</li>";
    echo "<li>Alle Angaben sind wahrheitsgemäß auszufüllen.</li>";
    echo "<li>Es sind drei Themen absteigend nach Ihrer Priorität zu wählen.</li>";
    echo "<li>Bei diesem Modulen mit dem <b>Belegwunschverfahren</b>, erfolgt eine Auswertung nach Fristende.</li>";
    echo "<li>Eine Zu- oder Absage zur Bewerbung erhalten Sie nach Fristende und durch eine <b>Benachrichtung</b> über Ihre angegebene E-Mail-Adresse.</li>";
    echo "</ul>";
    echo "</div><br>";

    $belegwunsch = new bewerbung_controller();
    $belegwunsch->Belegwunschformular($modul_id);
}
else
{
echo"Wähle ein Modul.";
}

include("navi.php");
include("footer.php");
?>  
