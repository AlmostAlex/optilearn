<?php
include ("header.php");
include ("Controllers/modul_controller.php");

echo"<h2 style='margin-top: 20px;' class='card-title'>Übersicht der Seminar- / Abschlussarbeitsthemen</h2>";
?>
<br> 

<?php

// FILTER OPTIONEN ANZEIGE! HIER 
//Filter Option mit Semester
$modul = new modul_controller();
$statement = $modul->Modulfilter();

//Filter Option mit Art (Abschluss- oder Seminararbeit)
//Filter Option mit Verfügbarkeit
//Filter Option mit Betreuer (name)
// ANZEIGE VORBEI

// FILTERUNG ABFRAGE SEMESTER

   

echo"<br><br><br>";         
include("navi.php");
include("footer.php");
?>  