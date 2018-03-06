<?php
require("Models/modul_model.php");
require("Models/belegwunsch_model.php");

class belegwunsch_controller
{
    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $modul;

    public function __construct() {
        $this->modul = new modul_model();
        $this->thema = new thema_model();
        $this->belegwunsch = new belegwunsch_model();

    }

    //Kommentare identisch mit denen von Windhundbewerbung
    public function Belegwunschbewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id1, $thema_id2, $thema_id3, $modul_id, $thema_id)
    {
        $statement_kategorie = $this->modul->getModulBezeichnungKategorie($modul_id);
        $statement_kategorie->bind_result($modulbezeichnung, $kategoriedb, $nachrueckverfahrendb);
        while($statement_kategorie->fetch())
        {
            $kategorie = $kategoriedb;
            $nachrueckverfahren = $nachrueckverfahrendb;
        }
        //Wenn kein Nachrückverfahren eingeleitet ist, dann werden normal die eingaben aus dem Belegwunschformular eingetragen
        if($nachrueckverfahren == "Geschlossen")
        {
            //Wenn die ausgewählten Themen sich unterscheiden, dann kommt keine Fehlermeldung
            if(($thema_id1 != $thema_id2 && $thema_id1 != $thema_id3 && $thema_id2 != $thema_id3) || ($thema_id1 == '' && $thema_id2 == '' && $thema_id3 == ''))
            {
                //Prüfung, ob bereits eine Bewerbung in diesem Modul mit der gleichen Matrikelnummer existiert.
                $prüfung = $this->belegwunsch->duplikatPrüfung($modul_id);
                $vorhanden = 0;
                if($prüfung != "leere DB")
                {
                    $prüfung->bind_result($matrikelDB, $status);
                    $prüfung->store_result();
                    while($prüfung->fetch())
                    {
                        //Wird nur als duplikat gezählt, wenn die vorhandene Bewerbung nicht abgelaufen ist.
                        if(($matrikelnummer == $matrikelDB) && ($status != "abgelaufen"))
                        {
                            $vorhanden += 1;
                        }
                    }
                }
                //Wenn kein Duplikat existiert, dann wird die Bewerbung unter einem neuen Datensatz abgespeichert
                if ($vorhanden == 0)
                {
                    $this->belegwunsch->insertBelegwunsch($vorname, $nachname, $matrikelnummer, $email, $modul_id, $thema_id1, $thema_id2, $thema_id3, "offen", $thema_id);
                    $statement = $this->modul->getModulbezeichnung($modul_id);
                    $statement->bind_result($modulbezeichnung);
                    $statement->store_result();
                    while ($statement->fetch()) 
                    {
                    
                    }
                    $statement = $this->thema->getBezeichnung($thema_id1);
                    $statement->bind_result($themenbezeichnung);
                    $statement->store_result();        
                    while ($statement->fetch()) 
                    {
                        $bezeichnung1 = $themenbezeichnung;    
                    }
                    $statement = $this->thema->getBezeichnung($thema_id2);
                    $statement->bind_result($themenbezeichnung);
                    $statement->store_result();        
                    while ($statement->fetch())
                    {
                        $bezeichnung2 = $themenbezeichnung;    
                    }
                    $statement = $this->thema->getBezeichnung($thema_id3);
                    $statement->bind_result($themenbezeichnung);
                    $statement->store_result();        
                    while ($statement->fetch()) 
                    {
                        $bezeichnung3 = $themenbezeichnung;    
                    }
                    echo"<script> $(window).load(function() { $('#beleg_success').modal('show'); }); </script>";
                    echo"<success><div class='modal fade' id='beleg_success' tabindex='0' role='dialog'>";
                    echo"<div class='modal-dialog'>";
                    echo"<div class='modal-content'>";
                    echo"<div class='modal-header'>";
                    echo"<h5 class='modal-title' id='titel'> Sie haben sich erfolgreich eingetragen! </h5>";
                    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo"<span aria-hidden='true'>&times;</span></button>";
                    echo"</div>";
                    echo"<div class='modal-body'>";
                    echo"<div class='alert alert-success' role='alert'><img src='img/checked.png'><center>Sie haben sich erfolgreich für das Modul <b>\"{$modulbezeichnung}\"</b> mit den folgenden Themen: ";
                    echo"<b>\"{$bezeichnung1}\"</b>, <b>\"{$bezeichnung2}\"</b> und \"<b>{$bezeichnung3}</b>\" beworben. ";
                    echo"</div>";
                    echo"<p class='debug-url'></p>";
                    echo"</div>";
                    echo"<div class='modal-footer'>";
                    echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div></success>";
                }
                //Wenn ein Duplikat existiert, dann wird die bewerbung nicht eingetragen und man erhält eine Fehlermeldung
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
                            <div class="modal-content"><div class="modal-header">
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
            //Wenn man bei den 3 Prioritäten ein Fach öfter als einmal gewählt hat, dann erhält man eine Fehlermeldung
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
                                    <p>Sie dürfen ein Fach nicht mehr als max. 1 mal auswählen! ->Keine Duplikate!</p>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-danger" href="bewerbungsformular_Belegwunschverfahren.php?action=bewerbung_Belegwunschverfahren&id=<?php echo base64_encode($modul_id);?>">Fertig</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
            }
        }
        //Wenn das Nachrückverfahren eingeleitet ist, dann wird wieder nach nach duplikaten geprüft
        else 
        {
            $prüfung = $this->belegwunsch->duplikatPrüfung($modul_id);
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
                //Direkter eintrag des erhaltenen Themas (da Nachrückverfaren)
                $this->belegwunsch->insertBelegwunsch($vorname, $nachname, $matrikelnummer, $email, $modul_id, $thema_id1, $thema_id2, $thema_id3, 'angenommen',  $thema_id);            
                $vergeben = "Vergeben";

                $this->thema->updateVerfuegbarkeit($thema_id, $vergeben);
                $statement = $this->modul->getModulbezeichnung($modul_id);
                $statement->bind_result($modulbezeichnung);
                $statement->store_result();
                    
                $statement_thema = $this->thema->getThemenbezeichnung($modul_id);
                $statement_thema->bind_result($themenbezeichnung);
                $statement_thema->store_result();
                    
                //Bestätidung der erfolgreichen Eintragung
                while ($statement->fetch()) 
                { 
                    while ($statement_thema->fetch()) 
                    { 
                        echo"<script> $(window).load(function() { $('#belegwunsch_belegwunsch_erfolgreich').modal('show'); }); </script>";
                        echo"<success><div class='modal fade' id='belegwunsch_belegwunsch_erfolgreich' tabindex='0' role='dialog' aria-labelledby='added'>";
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
            //Bei Dulplikat wird eine Fehlermeldung ausgegeben und nicht eingetragen
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

    public function Belegwunschformular($modul_id)
    {
        //Wenn das Formular abgeschickt wird, dann werden die Eingaben weitergegeben
        if(isset($_POST["bewerbung_belegwunsch"]))
        {
            $vorname = $_POST["Vorname"];
            $nachname = $_POST["Nachname"];
            $matrikelnummer = $_POST["Matrikelnummer"];
            $email = $_POST["Email"];
            if(isset($_POST['Thema1']))
            {
                $thema_id1 = $_POST['Thema1'];
            }
            else
            {
                $thema_id1 = "";
            }
            if(isset($_POST['Thema2']))
            {
                $thema_id2 = $_POST['Thema2'];
            }
            else
            {
                $thema_id2 = "";
            }
            if(isset($_POST['Thema3']))
            {
                $thema_id3 = $_POST['Thema3'];
            }
            else
            {
                $thema_id3 = "";
            }
            if(isset($_POST['Thema']))
            {
                $thema_id = $_POST['Thema'];
            }
            else
            {
                $thema_id = "";
            }
            //Und es wird die Auswertung der Eingaben aufgerufen
            $belegwunsch = new belegwunsch_controller();
            $belegwunsch->Belegwunschbewerbung($vorname, $nachname, $matrikelnummer, $email, $thema_id1, $thema_id2, $thema_id3, $modul_id, $thema_id);
        }

        //Aus der Datenbank nötige Variabeln beschaffen
        $verfuegbar = "Verfügbar";
        $statement_modul = $this->modul->getModulBezeichnungKategorie($modul_id);
        $statement_modul->bind_result($modulbezeichnung, $kategorie, $nachrueckverfahren);
        $statement_modul->store_result();
    
        $statement_themen1 = $this->thema->getModulThemaVerfuegbar($modul_id, $verfuegbar);
        $statement_themen1->bind_result($themenbezeichnung, $thema_id);
        $statement_themen1->store_result();
    
        $statement_themen2 = $this->thema->getModulThemaVerfuegbar($modul_id, $verfuegbar);
        $statement_themen2->bind_result($themenbezeichnung, $thema_id);
        $statement_themen2->store_result();
    
        $statement_themen3 = $this->thema->getModulThemaVerfuegbar($modul_id, $verfuegbar);
        $statement_themen3->bind_result($themenbezeichnung, $thema_id);
        $statement_themen3->store_result();
    
        while($statement_modul->fetch())
        {
            //Wenn kein Nachrückverfahren eingeleitet ist, dann wird das normale Belegwunschformular angezeigt
            if($nachrueckverfahren == 'Geschlossen')
            {
                echo"<div style='margin-bottom: 100px; border-top: 4px solid #3979b5;' class='form_thema'>";
                echo"<form method='post'>"; 
                echo "<h5>Bewerbungsmodul: {$modulbezeichnung}</h5>";
                echo "<h6>Belegwunschverfahren</h6><br>";
                echo"<table  style='width: 67%;'>";   
                echo"<tr>";
                echo"<td style='width: 40%'><label for='Vorname'><b>Vorname:</b><red style='color: red'>*</red></label></td>";
                echo"<td style='width: 60%'><input style='width: 100%' type='text class='form-control' name='Vorname' id='Vorname' placeholder='Vorname' required> </td>";
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
                echo"</table><br>";
                echo"<table style='width: 81%;'>";
                echo"<tr>";
                echo"<td style='width: 33%'><label for='Thema'><b>Thema 1:</b><red style='color: red'>*</red></label></td>";
                echo"<td>";
                echo"<select style='width: 75%;' class='form-control' name='Thema1' id='Thema1' required>";
                
                while($statement_themen1->fetch())
                {
                    echo "<option value='{$thema_id}'>$themenbezeichnung </option>";
                }                    
            
                echo "</select>";
                echo "</td>";
                echo "</tr>";  
                echo"<tr>";
                echo"<td style='width: 33%'><label for='Thema'><b>Thema 2:</b><red style='color: red'>*</red></label></td>";
                echo"<td>";
                echo"<select style='width: 75%;' class='form-control' name='Thema2' id='Thema2' required>";
                
                while($statement_themen2->fetch())
                {
                    echo "<option value='{$thema_id}'>$themenbezeichnung </option>";
                }
                
                echo "</select>";
                echo "</td>";
                echo "</tr>";  
                echo"<tr>";
                echo"<td style='width: 33%'><label for='Thema'><b>Thema 3:</b><red style='color: red'>*</red></label></td>";
                echo"<td>";
                echo"<select style='width: 75%;' class='form-control' name='Thema3' id='Thema3' required>";
                
                while($statement_themen3->fetch())
                {
                    echo "<option value='{$thema_id}'>$themenbezeichnung </option>";
                }
            
                echo "</select>";
                echo "</td>";
                echo "</tr>";  
                echo"<tr><td><br><input type='submit' name='bewerbung_belegwunsch' class='btn btn-primary' value='Bewerbung absenden'/> </tr> </td>";
                echo"</table>";
                echo"</form></div>";
            }
            
            //Erzeugung des Windhund-formulars, wenn das Nachrückverfahren eingeleitet ist
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
                    echo"<tr><td><br><input type='submit' name='bewerbung_belegwunsch' class='btn btn-primary' value='Formular absenden' data-toggle='modal' data-target='#myModal'> </tr> </td>";
                    echo"</table>";
                    echo"</form></div></div><br>";
                }
            }
        }
    }
}

?>