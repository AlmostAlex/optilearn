<?php
require("Models/modul_model.php");
require("Models/bewerbung_model.php");
require("Models/bewerbung_punkte_model.php");

class bewerbung_controller
{
    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $modul;

    public function __construct() {
        $this->modul = new modul_model();
        $this->thema = new thema_model();
        $this->bewerbung = new bewerbung_model();
        $this->bewerbung_punkte = new bewerbung_punkte_model();
    }

    //Erzeugen des Bewerbungsformulars
    public function Bewerbungsformular($modul_id)
    {
        //Wenn das Formular abgeschickt wird, dann werden die Eingaben übergeben
        if(isset($_POST["bewerbung_bewerbung"]))
        {
            
            $vorname = $_POST["Vorname"];
            $nachname = $_POST["Nachname"];
            $matrikelnummer = $_POST["Matrikelnummer"];
            $email = $_POST["Email"];
            $thema_id = $_POST['Thema'];
            
            if(isset($_POST['Credit_Anzahl']))
            { 
                $credit_anzahl = $_POST['Credit_Anzahl'];
            } 
            else{$credit_anzahl='';}
            
            if(isset($_POST['Studiengang']))
            { 
                $studiengang = $_POST['Studiengang'];
            } 
            else{$studiengang='';}
            
            if(isset($_POST['Fachsemester']))
            { 
                $fachsemester = $_POST['Fachsemester'];
            } 
            else{$fachsemester='';}
            
            if(isset($_POST['Teilgenommen']))
            { 
                $seminar_teilnahme = $_POST['Teilgenommen'];
            } 
            else
            {
                $seminar_teilnahme='';
            }
            //Nachübergabe der Eingaben wird die Funktion zur Eintragung aufgerufen
            $bewerbung = new bewerbung_controller();
            $bewerbung->Bewerbungbewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $modul_id);
        }

        $verfuegbar = "Verfügbar";
        $statement_modul = $this->modul->getModulBezeichnungKategorie($modul_id);
        $statement_modul->bind_result($modulbezeichnung, $kategorie, $nachrueckverfahren);
        $statement_modul->store_result();
    
        $statement_themen = $this->thema->getModulThemaVerfuegbar($modul_id, $verfuegbar);
        $statement_themen->bind_result($themenbezeichnung, $thema_id);
        $statement_themen->store_result();

        while($statement_modul->fetch())
        {
            //Wenn kein Nachrückverfahren eingeleitet ist, dann wird das normale Bewerbungsformular erzeugt
            if($nachrueckverfahren == 'Geschlossen')
            {
                echo"<div class='form_thema'>";
                echo"<form method='post'>";
                echo"<h5>Bewerbungsmodul: {$modulbezeichnung}</h5>";
                echo"<h6>Bewerbungsverfahren</h6><br>";
                echo"<table>";   
                echo"<tr>";
                echo"<td style='width: 40%'><label for='Vorname'><b>Vorname:</b><red style='color: red'>*</red></label></td>";
                echo"<td style='width: 60%'><input style='width: 100%' type='text class='form-control' name='Vorname' id='Vorname'  placeholder='Vorname' required> </td>";
                echo "</tr> ";
                echo"<tr>";
                echo"<td style='width: 40%'><label for='Nachname'><b>Nachname:</b><red style='color: red'>*</red></label></td>";
                echo"<td style='width: 60%'><input style='width: 100%' type='text class='form-control' name='Nachname' id='Nachname'  placeholder='Nachname' required> </td>";
                echo "</tr> ";
                echo"<tr>";
                echo"<td style='width: 30%'><label for='matrikelnummer'><b>Matrikelnummer:</b><red style='color: red'>*</red></label></td>";
                echo"<td style='width: 65%'><input style='width: 100%' type='text class='form-control' name='Matrikelnummer' id='Matrikelnummer' required></td>";
                echo "</tr>";
                echo"<tr>";
                echo"<td style='width: 30%'><label for='E-Mail'><b>E-Mail:</b><red style='color: red'>*</red></label></td>";
                echo"<td style='width: 65%'><input style='width: 100%' type='text class='form-control' name='Email' id='Email' placeholder='@stud.uni-goettingen.de' required></td>";
                echo "</tr>";
                echo"<tr>";
                echo"<td style='width: 30%'><label for='Fachsemester'><b>Aktuelles Fachsemester:</b><red style='color: red'>*</red></label></td>";
                echo"<td style='width: 65%'><input style='width: 100%' type='text class='form-control' name='Fachsemester' id='Fachsemester' required></td>";
                echo "</tr>";
                echo"</table><br>";
                echo"<table><tr>";                
                echo"<td><label style='padding-bottom: 0px;' for='Teilgenommen'><b>Haben Sie bereits an einem Seminarthema teilgeommen?</b> <red style='color: red'>*</red></label></td>"; 
                echo"<td><input style='margin-left: 10px;' type='radio' name='Teilgenommen' value='Ja' class='Kategorie' />Ja</input></td>";
                echo"<td><input style='margin-left: 10px;' type='radio' name='Teilgenommen' value='Nein' class='Kategorie' />Nein</input></td>";
                echo"</tr>";
                echo"</table><br>";
                echo"<table style='width: 81%;'><tr>";
                echo"<td style='width: 5%'><label for='Studiengang'><b>Studiengang:</b><red style='color: red'>*</red></label></td>";
                echo"<td>";
                echo" <select style='width: 75%;' class='form-control' name='Studiengang' id='Studiengang' required>";
                echo"   <option value='Betriebswirtschaftlehre'>Betriebswirtschaftslehre</option>";
                echo"  <option value='Wirtschaftsinformatik'>Wirtschaftsinformatik</option>";
                echo"   <option value='Volkswirtschaftslehre'>Volkswirtschaftslehre</option>";
                echo"   <option value='Wirtschaftspädagogik'>Wirtschaftspädagogik</option>";                   
                echo" </select></td>";
                echo "</tr>";
                echo"<tr>";
                echo"<td style='width: 33%'><label for='Credits'><b>Anzahl Credits:</b><red style='color: red'>*</red></label></td>";
                echo"<td><input style='width: 75%;' type='text class='form-control' name='Credit_Anzahl' id='Credits_Anzahl' placeholer='Anzahl' required></td>";
                echo "</tr>";
                echo"<tr>";
                echo"<td style='width: 33%'><label for='Thema'><b>Thema:</b><red style='color: red'>*</red></label></td>";
                echo"<td>";
                echo"<select style='width: 75%;' class='form-control' id='Thema' name='Thema' required>";
                while($statement_themen->fetch())
                {
                    echo "<option value='{$thema_id}'>$themenbezeichnung </option>";
                }
                echo "</select>";
                echo "</td>";
                echo "</tr>";
                echo"<tr><td><br><input type='submit' name='bewerbung_bewerbung' class='btn btn-primary' value='Bewerbung absenden'/> </tr> </td>";
                echo"</table>";
                echo"</form></div>";
            }
            //Wenn das Nachrückverfahren eingeleitet ist, dann wird das Windhund-Formular erstellt
            else
            {
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
                        echo "<option value='{$thema_id}'> {$themenbezeichnung} {$thema_id}</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";
                    echo"<tr><td><br><input type='submit' name='bewerbung_bewerbung' class='btn btn-primary' value='Formular absenden' data-toggle='modal' data-target='#myModal'> </tr> </td>";
                    echo"</table>";
                    echo"</form></div></div><br>";
                }
            }
        }
    }

    //Kommentare identisch mit denen von Windhundbewerbung
    public function Bewerbungbewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $modul_id)
    {
        //Beschaffen einiger Variabeln zur Prüfung
        $statement_kategorie = $this->modul->getModulBezeichnungKategorie($modul_id);
        $statement_kategorie->bind_result($modulbezeichnung, $kategoriedb, $nachrueckverfahrendb);
        while($statement_kategorie->fetch())
        {
            $kategorie = $kategoriedb;
            $nachrueckverfahren = $nachrueckverfahrendb;
        }
        $geschlossen = "Geschlossen";
        //Wenn das Nachrückverfahren nicht eingeleitet ist, dann wird eine normale Prüfung + Eintragung ausgeführt
        if($nachrueckverfahren == $geschlossen)
        {
            //Prüfung, ob sich Duplikate in der Datenbank befinden
            $prüfung = $this->bewerbung->duplikatPrüfung($modul_id);
            $vorhanden = 0;
            $gleichesThema = 0;
            if($prüfung != "leere DB")
            {
                $prüfung->bind_result($matrikelDB, $status, $thema_idDB);
                $prüfung->store_result();
                while($prüfung->fetch())
                {
                    if(($matrikelnummer == $matrikelDB) && ($status != "abgelaufen"))
                    {
                        //Wenn sich bereits auf ein Thema im Modul beworden wurde, dann notieren wir das
                        $vorhanden += 1;
                        if($thema_id == $thema_idDB)
                        {
                            //Sollte das Thema das gleiche sein wie in der DB, dann notieren wir das auch (Um die alte Bewerbung zu überschreiben)
                            $gleichesThema +=1;
                        }
                    }
                }
            }
            //Wenn keine duplikate vorhanden sind, dann werden die Punkte berechnet
            if ($vorhanden == 0)
            {
                $studiengangDB = $this->modul->getModulStudiengang($modul_id);
                if($studiengang == $studiengangDB)
                {
                    $studiengang_punkte = 20;
                }
                else
                {
                    $studiengang_punkte = 0;
                }
                $fachsemester_punkte = pow(2, ($fachsemester));
                $credit_anzahl_punkte = $credit_anzahl*0.5;
                if($kategorie == "Seminararbeit")
                {
                    $seminar_teilnahme = $_POST['Teilgenommen'];
                    if($seminar_teilnahme == "Ja")
                    {
                        $seminar_teilnahme_punkte = 0;
                    }
                    else
                    {
                        $seminar_teilnahme_punkte = 15;
                    }
                }
                else
                {
                    $seminar_teilnahme = " ";
                    $seminar_teilnahme_punkte = 0;
                }
                $gesamt_punkte = $studiengang_punkte + $fachsemester_punkte + $credit_anzahl_punkte + $seminar_teilnahme_punkte;
                
                //Eintragen der Bewerbung und der Punkte zu dieser.
                $last_id = $this->bewerbung->insertBewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $seminar_teilnahme, "offen");
                $this->bewerbung_punkte->insertBewerbungPunkte($studiengang_punkte, $fachsemester_punkte, $credit_anzahl_punkte, $seminar_teilnahme_punkte, $gesamt_punkte, $last_id);
               
                //Modelabfrage, um die Bezeichnung und die Kategorie des Moduls zu bekommen   
                $statement = $this->modul->getModulbezeichnung($modul_id);
                $statement->bind_result($modulbezeichnung);
                $statement->store_result();
            
                $statement_thema = $this->thema->getThemenbezeichnung($modul_id);
                $statement_thema->bind_result($themenbezeichnung);
                $statement_thema->store_result();
                
                //Anzeigen eines Modals, welches über die Erfolgreiche Bewerbung informiert.
                while ($statement->fetch()) 
                { 
                    while ($statement_thema->fetch()) 
                    {
                        echo"<script> $(window).load(function() { $('#bewerbung_windhund_erfolgreich').modal('show'); }); </script>";
                        echo"<success><div class='modal fade' id='bewerbung_windhund_erfolgreich' tabindex='0' role='dialog'>";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' id='titel'> Sie haben sich erfolgreich eingetragen! </h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center>Sie haben sich erfolgreich für das Modul <b>\"{$modulbezeichnung}\"</b>";
                        echo" mit dem Thema <b>\"{$themenbezeichnung}\"</b> beworben. ";
                        echo" Eine Benachrichtigung erhalten Sie nach Ablauf der Frist.</center></div>";
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
            //Wenn der Bewerber sich erneut auf das selbe Thema beworben hat
            else if($gleichesThema == 1)
            {
                //Dann werden zunächst die Punkte ausgerechnet
                $studiengangDB = $this->modul->getModulStudiengang($modul_id);
                if($studiengang == $studiengangDB)
                {
                    $studiengang_punkte = 20;
                }
                else
                {
                    $studiengang_punkte = 0;
                }
                $fachsemester_punkte = pow(2, ($fachsemester));
                $credit_anzahl_punkte = $credit_anzahl*0.5;
                if($kategorie == "Seminararbeit")
                {
                    $seminar_teilnahme = $_POST['Teilgenommen'];
                    if($seminar_teilnahme == "Ja")
                    {
                        $seminar_teilnahme_punkte = 0;
                    }
                    else
                    {
                        $seminar_teilnahme_punkte = 15;
                    }
                }
                else
                {
                    $seminar_teilnahme = "";
                    $seminar_teilnahme_punkte = 0;
                }
                $gesamt_punkte = ($studiengang_punkte + $fachsemester_punkte + $credit_anzahl_punkte + $seminar_teilnahme_punkte);
                
                //Und dann wird der vorherige Eintrag überschrieben (Sowohl die Bewerbung, als auch die Punkte)
                $this->bewerbung->updateBewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, $seminar_teilnahme);
                $last_id = $this->bewerbung->getBewerberID($matrikelnummer);
                $this->bewerbung_punkte->updateBewerbungPunkte($studiengang_punkte, $fachsemester_punkte, $credit_anzahl_punkte, $seminar_teilnahme_punkte, $gesamt_punkte, $last_id);
           
                //Anzeigen eines Modals für die erfolgreiche neueintragung
                echo"<script> $(window).load(function() { $('#bewerbung_update').modal('show'); }); </script>";
                echo"<success><div class='modal fade' id='bewerbung_update' tabindex='0' role='dialog' aria-labelledby='added'>";
                echo"<div class='modal-dialog'>";
                echo"<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'> Sie haben sich erfolgreich beworben! </h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo"<div class='modal-body'>";
                echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center><b>Sie haben sich erfolgreich eingetragen!</b><br>";
                echo"Da es bereits einen Datensatz mit Ihren Informationen gab, wurde dieser nun ersetzt.</center></div>";
                echo"<p class='debug-url'></p>";
                echo"</div>";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div></success>";
            }
            //Wenn sich bereits auf ein anderes Thema im selben Modul beworben wurde, dann wird ein Modal zur
            //Fehlgeschlagenen Eintragung angezeigt
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
        //Wenn das Nachrückverfahren eingeleitet ist
        else 
        {
            //Dann wird auf Duplikate geprüft
            $prüfung = $this->bewerbung->duplikatPrüfung($modul_id);
            $prüfung->bind_result($matrikelDB, $status,$thema_iddb);
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
                $this->bewerbung->insertBewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id, $studiengang, $fachsemester, $credit_anzahl, '', 'angenommen');            
                $vergeben = "Vergeben";
                $last_id = $this->bewerbung->getBewerberID($matrikelnummer);
                $this->bewerbung_punkte->updateBewerbungPunkte(0, 0, 0, 0, 0, $last_id);
                $this->thema->updateVerfuegbarkeit($thema_id, $vergeben);
                $statement = $this->modul->getModulbezeichnung($modul_id);
                $statement->bind_result($modulbezeichnung);
                $statement->store_result();
                
                $statement_thema = $this->thema->getThemenbezeichnung($modul_id);
                $statement_thema->bind_result($themenbezeichnung);
                $statement_thema->store_result();
                
                while ($statement->fetch()) 
                { 
                    while ($statement_thema->fetch()) 
                    { 
                        echo"<script> $(window).load(function() { $('#bewerbung_bewerbung_erfolgreich').modal('show'); }); </script>";
                        echo"<success><div class='modal fade' id='bewerbung_bewerbung_erfolgreich' tabindex='0' role='dialog' aria-labelledby='added'>";
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
            //Wenn sich bereits auf ein Thema in dem Modul beworben wurde, schlägt die Eintragung fehlt und ein Modal
            //Hierfür wird angezeigt
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
    }
}

?>