<?php
require("Models/modul_model.php");
require("Models/windhund_model.php");
require("Models/bewerbung_model.php");

class windhund_controller 
{

    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $modul;

    public function __construct() 
    {
        $this->modul = new modul_model();
        $this->thema = new thema_model();
        $this->windhund = new windhund_model();
    }

    //Eintragung des Bewerbers in dem Modul (windhund)
    public function Windhundbewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $modul_id) 
    {
        //Hier wird geprüft, ob der Student sich bereits auf ein Thema in dem Modul beworben hat oder schon genommen wurde
        $prüfung = $this->windhund->duplikatPrüfung($modul_id);
        $prüfung->bind_result($matrikelDB, $status);
        $prüfung->store_result();
        $vorhanden = 0;
        while ($prüfung->fetch()) 
        {
            if (($matrikelnummer == $matrikelDB) && ($status != "abgelehnt")) 
            {
                $vorhanden += 1;
            }
        }

        //Wenn er sich noch nicht beworben hat, dann werden seine Infromationen dem Thema zugeordnet
        //Und das Thema wird auf vergeben gestellt
        if ($vorhanden == 0) 
        {
            $this->windhund->insertWindhund($vorname, $nachname, $matrikelnummer, $email, $thema_id, "offen");            
            $this->thema->updateVerfuegbarkeit($thema_id, "Vergeben");
            $statement = $this->modul->getModulbezeichnung($modul_id);
            $statement->bind_result($modulbezeichnung);
            $statement->store_result();
            
            $statement_thema = $this->thema->getThemenbezeichnung($modul_id);
            $statement_thema->bind_result($themenbezeichnung);
            $statement_thema->store_result();
                     
            while ($statement->fetch()) 
            { 
                //Modal zur erfolgreichen Eintragung anzeigen
                while ($statement_thema->fetch()) 
                {
                    echo"<script> $(window).load(function() { $('#bewerbung_windhund_erfolgreich').modal('show'); }); </script>";
                    echo"<success><div class='modal fade' id='bewerbung_windhund_erfolgreich' tabindex='0' role='dialog' aria-labelledby='added'>";
                    echo"<div class='modal-dialog'>";
                    echo"<div class='modal-content'>";
                    echo"<div class='modal-header'>";
                    echo"<h5 class='modal-title' id='titel'> Sie haben sich erfolgreich eingetragen! </h5>";
                    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo"<span aria-hidden='true'>&times;</span></button>";
                    echo"</div>";
                    echo"<div class='modal-body'>";
                    echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center>Sie haben sich erfolgreich für das Modul <b>\"{$modulbezeichnung}\"</b>";
                    echo" mit dem Thema <b>\"{$themenbezeichnung}\"</b> eingetragen. ";
                    echo" Eine Bestätigung erhalten Sie vom Dozenten demnächst.</center></div>";
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
        //Wenn bereits in ein Thema im selben Modul eingetragen, adnn Modal zur Fehlgeschlagenen Eintragung
        else 
        {
            echo"<script>
            $(window).load(function()
            {
                $('#myModal2').modal('show');
            });
            </script>";
            ?>
            <!-- Modal -->
            <div id="myModal2" class="modal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eintragung ist Fehlgeschlagen!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Sie haben sich bereits auf ein Thema in diesem Modul beworben/eingetragen!.</p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="btn btn-danger" href="Themen_uebersicht_student.php">Fertig</a> 
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    //Erzeugen des Windhundformulars
    public function Windhundformular($modul_id) 
    {
        if (isset($_POST['bewerbung_windhund'])) 
        {
            $vorname = $_POST["Vorname"];
            $nachname = $_POST["Nachname"];
            $matrikelnummer = $_POST["Matrikelnummer"];
            $email = $_POST["Email"];
            $thema_id = $_POST["Thema"];
            $this->Windhundbewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $modul_id);
        }

        //Modelabfrage, um die Bezeichnung und die Kategorie des Moduls zu bekommen
        $statement_bezeichnung = $this->modul->getModulBezeichnungKategorie($modul_id);
        $statement_bezeichnung->bind_result($modulbezeichnung, $kategorie, $nachrueckverfahren);
        $statement_bezeichnung->store_result();

        //Abfrage, um alle verfügbaren Themen in dem Modul zu erhalten
        $statement_themen = $this->thema->getModulThemaVerfuegbar($modul_id, 'Verfügbar');
        $statement_themen->bind_result($themenbezeichnung, $thema_id);
        $statement_themen->store_result();

        //Formular
        while ($statement_bezeichnung->fetch()) 
        {
            echo"<div class='windhund'><div style='margin-bottom: 100px; border-top: 4px solid #3979b5;' class='form_thema'>";
            echo"<form method='post'>";
            echo "<h4 class='bew_ue'>Bewerbungsmodul: {$modulbezeichnung}</h4>";
            echo "<h6>Windhundverfahren</h6><br>";
            echo"<table>";
            echo"<tr>";
            echo"<td><label for='Vorname'><b>Vorname:</b><red style='color: red'>*</red></label></td>";
            echo"<td><input style='width: 100%' type='text class='form-control' id='Vorname'  name='Vorname' placeholder='Vorname' required> </td>";
            echo "</tr> ";
            echo"<tr>";
            echo"<td><label for='Nachname'><b>Nachname:</b><red style='color: red'>*</red></label></td>";
            echo"<td><input style='width: 100%' type='text class='form-control' id='Nachname' name='Nachname'  placeholder='Nachname' required> </td>";
            echo "</tr> ";
            echo"<tr>";
            echo"<td><label for='matrikelnummer'><b>Matrikelnummer:</b><red style='color: red'>*</red></label></td>";
            echo"<td><input style='width: 100%' type='text class='form-control' id='Matrikelnummer' name='Matrikelnummer' required></td>";
            echo "</tr>";
            echo"<tr>";
            echo"<td><label for='E-Mail'><b>E-Mail:</b><red style='color: red'>*</red></label></td>";
            echo"<td><input style='width: 100%' type='text class='form-control' id='Email' name='Email' placeholder='@stud.uni-goettingen.de' required></td>";
            echo "</tr>";
            echo"<tr>";
            echo"<td style='width: 33%'><label for='Thema'><b>Thema:</b><red style='color: red'>*</red></label></td>";
            echo"<td>";
            echo"<select class='form-control' id='Thema' name='Thema' required>";
            //Select, der verfügbaren Themen
            while ($statement_themen->fetch()) 
            {
                echo "<option value='{$thema_id}'> $themenbezeichnung</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "</tr>";
            echo"<tr><td><br><input type='submit' name='bewerbung_windhund' class='btn btn-primary' value='Formular absenden' data-toggle='modal' data-target='#myModal'> </tr> </td>";
            echo"</table>";
            echo"</form></div></div><br>";
        }
    }
}
