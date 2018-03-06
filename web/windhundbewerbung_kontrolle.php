<?php
include ("header.php");
include ("Controllers/bewerbung_controller.php");
?>
<br><h4>Bewerbungsformular</h4><br>
<?php

echo "<div class='form_thema'>";
    echo "<div class='form_ueberschrift'><i class='fa fa-info-circle' aria-hidden='true'></i> Kontrollieren Sie bitte Ihre Eingaben!</div><br> ";
    echo "<li>Nach erfolgreicher Anmeldung, erhalten sie eine <b>Benachrichtung</b> über Ihre angegebene E-Mail-Adresse.</li>";
echo "</div><br>";
?>
<table>
<tr>
    <td> <b> Vorname: </b> </td>
    <td> <?php echo $_POST["Vorname"]; ?> </td>
</tr>
<tr>
    <td> <b> Nachname: </b> </td>
    <td> <?php echo $_POST["Nachname"]; ?> </td>
</tr>
<tr>
    <td> <b> Matrikelnummer: </b> </td>
    <td> <?php echo $_POST["Matrikelnummer"]; ?> </td>
</tr>
<tr>
    <td> <b> E-Mail: </b> </td>
    <td> <?php echo $_POST["Email"]; ?> </td>
</tr>
<tr>
    <td> <b> Modul: </b> </td>
    <td> <?php echo $modulbezeichnung; ?> </td>
</tr>
<tr>
    <td> <b> Thema: </b> </td>
    <td> <?php echo $_POST["Thema"]; ?> </td>
</tr>
</table>
<?php


    $windhund = new bewerbung_controller();
    $windhund->Windhundformular($modul_id);


include("navi.php");
include("footer.php");
?>  
