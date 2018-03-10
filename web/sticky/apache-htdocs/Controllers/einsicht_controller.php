<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require("Models/modul_model.php");
require("Models/belegwunsch_model.php");
require("Models/bewerbung_model.php");
require("Models/bewerbung_punkte_model.php");
require("Models/windhund_model.php");

class einsicht_controller
{
    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $modul;

    public function __construct() {
        $this->modul = new modul_model();
        $this->thema = new thema_model();
        $this->belegwunsch = new belegwunsch_model();
        $this->bewerbung = new bewerbung_model();
        $this->punkte = new bewerbung_punkte_model();
        $this->windhund = new windhund_model();
    }

    //Kommentare identisch mit denen von Windhundbewerbung
    public function belegwunschEinsicht($modul_id)
    {
        // Aktuelle Zeit wird abgerufen
        date_default_timezone_set("Europe/Berlin");
        $aktuell_datum = date("Y-m-d");
        $heute_dt = new DateTime($aktuell_datum);
        $frist_ende = $this->modul->getFristEnde($modul_id);
        if($heute_dt > $frist_ende)
        {
            //Festlegen der Bewerberanzahl und der ThemaAnzahl
            //Festlegen der Bewerberanzahl und der ThemaAnzahl
            $bewerberAnzahl = $this->belegwunsch->getBewerberAnzahl($modul_id);
            $themaAnzahl = $this->thema->getModulThemaAnzahldirekt($modul_id);
            
            //Status der Themen auf "Frei" setzen und Status der Bewerber auf "Hat nichts!" setzen.
            $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
            $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
            $statement_thema_bewerber->store_result();
            while($statement_thema_bewerber->fetch())
            {
                $array[$belegwunsch_id]['Status'] = "Hat nichts!";
                $array[$belegwunsch_id]['Thema'] = "kein Thema";
            }
            
            $statement_modul_themen = $this->thema->getAllModulThema($modul_id);
            $statement_modul_themen->bind_result($thema_id);
            $statement_modul_themen->store_result();
            while($statement_modul_themen->fetch())
            {
                $array[$thema_id]['Status'] = "Frei";
                $array[$thema_id]['Punkte'] = 0;
                $array[$thema_id]['Bewerber'] = "Noch kein Bewerber";
            }
            
            //Die Studenten bekommen ihren ersten Wunsch, wenn dieser noch frei ist.
            $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
            $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
            $statement_thema_bewerber->store_result();
            while($statement_thema_bewerber->fetch())
            {
                $statement_modul_themen = $this->thema->getAllModulThema($modul_id);
                $statement_modul_themen->bind_result($thema_id);
                $statement_modul_themen->store_result();
                while($statement_modul_themen->fetch())
                {
                    if($wunsch_1 == $thema_id)
                    {
                        if($array[$thema_id]['Status'] == "Frei")
                        {
                            $array[$thema_id]['Punkte'] = 115;
                            $array[$thema_id]['Bewerber'] = $belegwunsch_id;
                            $array[$thema_id]['Status'] = "Vergeben";
                            $array[$belegwunsch_id]['Status'] = "Hat was!";
                            $array[$belegwunsch_id]['Thema'] = $thema_id;
                        }
                    }
                }
            }
            
            //Die Studenten, die noch nichts haben, bekommen ihren zweiten Wunsch, wenn dieser noch Frei ist.
            $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
            $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
            $statement_thema_bewerber->store_result();
            while($statement_thema_bewerber->fetch())
            {
                $statement_modul_themen = $this->thema->getAllModulThema($modul_id);
                $statement_modul_themen->bind_result($thema_id);
                $statement_modul_themen->store_result();
                while($statement_modul_themen->fetch())
                {
                    if($array[$belegwunsch_id]['Status'] != "Hat was!")
                    {
                        if($wunsch_2 == $thema_id)
                        {
                            if($array[$thema_id]['Status'] == "Frei")
                            {
                                $array[$thema_id]['Punkte'] = 110;
                                $array[$thema_id]['Bewerber'] = $belegwunsch_id;
                                $array[$thema_id]['Status'] = "Vergeben";
                                $array[$belegwunsch_id]['Status'] = "Hat was!";
                                $array[$belegwunsch_id]['Thema'] = $thema_id;
                            }
                        }
                    }
                }
            }
            
            //Die Studenten, die noch nichts haben, bekommen ihren dritten Wunsch, wenn dieser noch Frei ist.
            $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
            $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
            $statement_thema_bewerber->store_result();
            while($statement_thema_bewerber->fetch())
            {
                $statement_modul_themen = $this->thema->getAllModulThema($modul_id);
                $statement_modul_themen->bind_result($thema_id);
                $statement_modul_themen->store_result();
                while($statement_modul_themen->fetch())
                {
                    if($array[$belegwunsch_id]['Status'] != "Hat was!")
                    {
                        if($wunsch_3 == $thema_id)
                        {
                            if($array[$thema_id]['Status'] == "Frei")
                            {
                                $array[$thema_id]['Punkte'] = 105;
                                $array[$thema_id]['Bewerber'] = $belegwunsch_id;
                                $array[$thema_id]['Status'] = "Vergeben";
                                $array[$belegwunsch_id]['Status'] = "Hat was!";
                                $array[$belegwunsch_id]['Thema'] = $thema_id;
                            }
                        }
                    }
                }
            }
            
            //Gesamtpunktzahl nach der ersten iteraltion bestimmen.
            $gesamtPunktzahl = 0;
            $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
            $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
            $statement_thema_bewerber->store_result();
            while($statement_thema_bewerber->fetch())
            {
                if($array[$belegwunsch_id]['Thema'] != "kein Thema")
                {
                    $gesamtPunktzahl += $array[($array[$belegwunsch_id]['Thema'])]['Punkte'];
                }
            }

            //Prüfen, ob es noch Freie Themen gibt, welche vergeben werden können
            //->Bedingung dafür ist, dass es min. soviele Bewerber gibt wie Themen.
            $statement_modul_themen = $this->thema->getAllModulThema($modul_id);
            $statement_modul_themen->bind_result($thema_id);
            $statement_modul_themen->store_result();
            while($statement_modul_themen->fetch())
            {
                if($array[$thema_id]['Status'] == "Frei")
                {
                    if($bewerberAnzahl >= $themaAnzahl)
                    {
                        $bewerbungErhalten = false;
                        //Es wird nach einem Bewerber gesucht, der das Thema als einen seiner Wünsche angegeben hatte.
                        //Wird er gefunden, dann werden seine Daten zwischengespeichert.
                        $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
                        $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
                        $statement_thema_bewerber->store_result();
                        while($statement_thema_bewerber->fetch())
                        {
                            if($wunsch_1 == $thema_id)
                            {
                                $Punktzahl1 = $array[($array[$belegwunsch_id]['Thema'])]['Punkte'];
                                $Punktzahl2 = 115;
                                $TauschThema = $array[$belegwunsch_id]['Thema'];
                                $bewerbungErhalten = true;
                                break;
                            }
                            else if($wunsch_2 == $thema_id)
                            {
                                $Punktzahl1 = $array[($array[$belegwunsch_id]['Thema'])]['Punkte'];
                                $Punktzahl2 = 110;
                                $TauschThema = $array[$belegwunsch_id]['Thema'];
                                $bewerbungErhalten = true;
                                break;
                            }
                            else if($wunsch_3 == $thema_id)
                            {
                                $Punktzahl1 = $array[($array[$belegwunsch_id]['Thema'])]['Punkte'];
                                $Punktzahl2 = 105;
                                $TauschThema = $array[$belegwunsch_id]['Thema'];
                                $bewerbungErhalten = true;
                                break;
                            }
                        }
                        if($bewerbungErhalten == true)
                        {
                            //Nach einem Bewerber suchen, der noch kein Thema hat und das alte Thema nehmen könnte
                            $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
                            $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
                            $statement_thema_bewerber->store_result();
                            while($statement_thema_bewerber->fetch())
                            {
                                if($array[$belegwunsch_id]['Status'] == "Hat nichts!")
                                {
                                    if($wunsch_1 == $TauschThema)
                                    {
                                        //Sollte man mehr Priorität auf die Wünsche und nicht die Themenvergabe
                                        //setzen wollen, dann kann man die Punkte geringer setzen.
                                        //Momentan wird bei den "if"-Abfragen True rauskommen, da die Themenvergabe
                                        //als Priorität angegeben wurde
                                        $Saldo = 115 + $Punktzahl2 - $Punktzahl1;
                                        if($Saldo >= 0)
                                        {
                                            //Hier findet der "tausch" statt.
                                            //Zwischenspeichern des Themas, dass der Bewerber vorher hatte 
                                            $neuesThema = $array[($array[$TauschThema]['Bewerber'])]['Thema'];
                                            //Punkte aktuallisierung
                                            $array[$thema_id]['Punkte'] = $Punktzahl2;
                                            //Das noch nicht vergebene Thema bekommt nun den Bewerber zugewiesen
                                            $array[$thema_id]['Bewerber'] = ($array[$TauschThema]['Bewerber']);
                                            $array[$thema_id]['Status'] = "Vergeben";
                                            //Und dem Bewerber wird das Thema zugeordnet
                                            $array[($array[$TauschThema]['Bewerber'])]['Thema'] = $thema_id;
                                            //Der Bewerber der vorher noch nichts hatte bekommt nun das Thema vom
                                            //vorherigen Bewerber
                                            $array[$neuesThema]['Punkte'] = 115;
                                            $array[$neuesThema]['Bewerber'] = $belegwunsch_id;
                                            $array[$belegwunsch_id]['Status'] = "Hat was!";
                                            $array[$belegwunsch_id]['Thema'] = $neuesThema;
                                        }
                                    }
                                    else if($wunsch_2 == $TauschThema)
                                    {
                                        $Saldo = 110 + $Punktzahl2 - $Punktzahl1;
                                        if($Saldo >= 0)
                                        {
                                            $neuesThema = $array[($array[$TauschThema]['Bewerber'])]['Thema'];
                                            
                                            $array[$thema_id]['Punkte'] = $Punktzahl2;
                                            $array[$thema_id]['Bewerber'] = ($array[$TauschThema]['Bewerber']);
                                            $array[$thema_id]['Status'] = "Vergeben";
                                            $array[($array[$TauschThema]['Bewerber'])]['Thema'] = $thema_id;
                                            
                                            $array[$neuesThema]['Punkte'] = 110;
                                            $array[$neuesThema]['Bewerber'] = $belegwunsch_id;
                                            $array[$belegwunsch_id]['Status'] = "Hat was!";
                                            $array[$belegwunsch_id]['Thema'] = $neuesThema;
                                        }
                                    }
                                    else if($wunsch_3 == $TauschThema)
                                    {
                                        $Saldo = 105 + $Punktzahl2 - $Punktzahl1;
                                        if($Saldo >= 0)
                                        {
                                            $neuesThema = $array[($array[$TauschThema]['Bewerber'])]['Thema'];
                                            
                                            $array[$thema_id]['Punkte'] = $Punktzahl2;
                                            $array[$thema_id]['Bewerber'] = ($array[$TauschThema]['Bewerber']);
                                            $array[$thema_id]['Status'] = "Vergeben";
                                            $array[($array[$TauschThema]['Bewerber'])]['Thema'] = $thema_id;
                                            
                                            $array[$neuesThema]['Punkte'] = 105;
                                            $array[$neuesThema]['Bewerber'] = $belegwunsch_id;
                                            $array[$belegwunsch_id]['Status'] = "Hat was!";
                                            $array[$belegwunsch_id]['Thema'] = $neuesThema;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //In der Datenbank den Bewerben die Themen zuordnen und nochmal die Punkte bestimmen.
        $gesamtPunktzahl = 0;
        $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
        $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
        $statement_thema_bewerber->store_result();
        while($statement_thema_bewerber->fetch())
        {
            if($array[$belegwunsch_id]['Thema'] != "kein Thema")
            {
                $this->belegwunsch->setThema($belegwunsch_id, $array[$belegwunsch_id]['Thema']);
                $gesamtPunktzahl += $array[($array[$belegwunsch_id]['Thema'])]['Punkte'];
            }
        }

        //ENDE DES ALGORITHMUS
        $statement_thema_check = $this->thema->getAllModulThema($modul_id);
        $statement_thema_check->bind_result($thema_id);
        $statement_thema_check->store_result();
        
        while($statement_thema_check->fetch())
        {
            $statement_bewerber_check = $this->belegwunsch->getBewerberAnzahlThema($thema_id);
            $statement_bewerber_check->bind_result($anzahl_bewerber_check);
            $statement_bewerber_check->store_result();
            
            while($statement_bewerber_check->fetch())
            {
                if($anzahl_bewerber_check == '0')
                {
                    echo "<div class='alert alert-secondary' role='alert'> <i style='color: red;' class='fa fa-exclamation-triangle' aria-hidden='true'></i> Es sind zur Zeit keine Bewerbungen eingegangen.</div>";                
                }
                else
                { 
                    ?>
                    <form method="post" action="?action=<?php echo"{$_GET['action']}&id={$_GET['id']}"; ?>" onsubmit="setTimeout('parent.location.reload()',500);">
                        <div class='bewerbung_verwaltung'>
                            <table>
                                <tr>        
                                    <th><center>Thema</center></th>
                                    <th><center>Matrikelnummer</center></th>
                                    <th><center>Name</center></th>        
                                    <th><center>E-Mail</center></th>        
                                    <th><center>Funktionen<BR>
                                    <input type="checkbox" onclick="toggle(this);" /> Alle</center></th>
                                </tr><?php
    
                    $statement = $this->modul->getModulBezeichnungKategorie($modul_id);
                    $statement->bind_result($modulbezeichnung, $kategoriedb, $nachrueckverfahren);
                    $statement->store_result();
                    while($statement->fetch())
                    {
                        $statement_thema = $this->thema->getAllModulThemaDetails($modul_id);
                        $statement_thema->bind_result($thema_id, $themenbezeichnung, $thema_verfuegbarkeit);
                        $statement_thema->store_result();
                        
                        // Anzahl Themen insgesamt
                        $thema_anzahl_gesamt = $this->thema->getModulThemaAnzahlById($modul_id);
                        $thema_anzahl_gesamt->bind_result($anzahl);
                        $thema_anzahl_gesamt->store_result();
                        
                        // Anzahl Themen Vergeben
                        $vergeben = "Vergeben";
                        $thema_anzahl_vergeben = $this->thema->getModulThemaAnzahlVerfuegbar($modul_id, $thema_verfuegbarkeit);
                        $thema_anzahl_vergeben->bind_result($anzahl_vergeben);
                        $thema_anzahl_vergeben->store_result();
                        while($thema_anzahl_gesamt->fetch())
                        {
                            while($thema_anzahl_vergeben->fetch())
                            {
                                echo "<div class='alert alert-secondary' style='background-color: rgba(34,36,38,.025)' role='alert'>Von insgesamt <b>{$anzahl}</b> Themen im Modul \"<b>{$modulbezeichnung}</b>\" sind/ist aktuell <b>{$anzahl_vergeben}</b> Themen vergeben.</div>";
                            }
                        }
                        while($statement_thema->fetch())
                        {
                            $statement_bewerber = $this->belegwunsch->getBewerberDetailsThema($thema_id);
                            $statement_bewerber->bind_result($belegwunsch_id, $vorname, $nachname, $matrikelnummer, $email, $status);
                            $statement_bewerber->store_result();
                            while($statement_bewerber->fetch())
                            {
                                echo"<tr>";
                                echo"<td style='color: #000000;'>{$themenbezeichnung}</td>";  
                                echo"<td><center>{$matrikelnummer}</center></td>";
                                echo"<td><center>{$nachname},{$vorname}</center></td>";
                                echo"<td><center>{$email}</center></td>";      
                                if($status == "angenommen")
                                {
                                    echo"<td><center><div class='status_annahme'>Angenommen</div></center></td>"; 
                                }      
                                else
                                {
                                    echo"<td><center><input value='{$email}' name='email[]' type='checkbox'> <i class='fa fa-envelope' aria-hidden='true'></i></input></center></td>"; 
                                } 
                            }
                        }       
                    }    
                    echo"</tr>"; 
                    echo"<tr>";
                    echo"<td colspan='4'></td>";
                    echo"<td colspan='1'><center><a data-toggle='modal' data-target='#annahme' title='Annahme per E-Mail'><annahme>✓</annahme></a></center></td>";
                    // Sicherheitsabfrage wenn Annahme
                    echo"<div class='modal fade' id='annahme' tabindex='-1' role='dialog' aria-labelledby='annahme' aria-hidden='true'>";
                    echo"<div class='modal-dialog'>";
                    echo"<div class='modal-content'>";
                    echo"<div class='modal-header'>";
                    echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Annahme(n) per E-Mail verschicken</h5>";
                    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo"<span aria-hidden='true'>&times;</span></button>";
                    echo"</div>";
                    echo"<div class='modal-body'>";
                    echo"<div class='alert alert-secondary' role='alert'><p style='margin: 0px; padding px;'><center>Sind sie sich sicher, dass Sie die Bewerber über ihre <b>Annahme</b> per E-Mail benachrichtigen wollen?</center></div></p>";
                    echo"<p class='debug-url'></p>";
                    echo"</div>";
                    echo"<div class='modal-footer'>";
                    echo"<input type='submit' style='background-color:#4bc671; color:#ffffff;' class='btn btn-default' name='annahme_belegwunsch'  data-toggle='tooltip' value='Annahme(n) verschicken'></input>";
                    echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</tr>";
                    echo"</table>"; 
                    echo"</div></form>";         
                }
            }
            break; 
        }
    }

    public function windhundEinsicht($modul_id)
    {
        $statement_bewerbungaufmodul = $this->windhund->bewerbungAnzahlGesamt($modul_id);
        $statement_bewerbungaufmodul->bind_result($windhund_id);
        $statement_bewerbungaufmodul->store_result();
        
        //Wenn Eintragungen auf Themen in diesem Modul gefunden worden sind
        if(($statement_bewerbungaufmodul->num_rows) !== 0)
        {
            //Dann hole all diese aus der Datenbank und stelle diese mit den entsprechenden Informationen dar.
            while($statement_bewerbungaufmodul->fetch())
            {
                $statement_thema_check = $this->thema->getAllModulThema($modul_id);
                $statement_thema_check->bind_result($thema_id);
                $statement_thema_check->store_result();
                while($statement_thema_check->fetch())
                {
                ?>  <form method="post" action="?action=<?php echo"{$_GET['action']}&id={$_GET['id']}"; ?>" onsubmit="setTimeout('parent.location.reload()',500);">
                        <div class='bewerbung_verwaltung'>
                            <table>
                                <tr>        
                                    <th><center>Thema</center></th>
                                    <th><center>Matrikelnummer</center></th>
                                    <th><center>Name</center></th>        
                                    <th><center>E-Mail</center></th>        
                                    <th><center>Funktionen<BR>
                                    <input type="checkbox" onclick="toggle(this);" /> Alle</center></th>
                                </tr>
                    <?php
                    $statement = $this->modul->getModulBezeichnungKategorie($modul_id);
                    $statement->bind_result($modulbezeichnung, $kategorie, $nachrueckverfahren);
                    $statement->store_result();
                    while($statement->fetch())
                    {
                        $statement_thema = $this->thema->getAllModulThemaDetailsVergeben($modul_id);
                        $statement_thema->bind_result($thema_id, $themenbezeichnung, $thema_verfuegbarkeit);
                        $statement_thema->store_result();
            
                        // Anzahl Themen insgesamt
                        $thema_anzahl_gesamt = $this->thema->getModulThemaAnzahlById($modul_id);
                        $thema_anzahl_gesamt->bind_result($anzahl);
                        $thema_anzahl_gesamt->store_result();
                        
                        // Anzahl Themen insgesamt
                        $vergeben = "Vergeben";
                        $thema_anzahl_vergeben = $this->thema->getModulThemaAnzahlVerfuegbar($modul_id, $vergeben);
                        $thema_anzahl_vergeben->bind_result($anzahl_vergeben);
                        $thema_anzahl_vergeben->store_result();
            
                        while($thema_anzahl_gesamt->fetch())
                        {
                            while($thema_anzahl_vergeben->fetch())
                            {
                                echo "<div class='alert alert-secondary' style='background-color: rgba(34,36,38,.025)' role='alert'>Von insgesamt <b>{$anzahl}</b> Themen im Modul \"<b>{$modulbezeichnung}</b>\" sind/ist aktuell <b>{$anzahl_vergeben}</b> Themen vergeben.</div>";
                            }
                        }
            
                        while($statement_thema->fetch())
                        {
                            $statement_bewerber = $this->windhund->getThemaBewerber($thema_id);
                            $statement_bewerber->bind_result($windhund_id, $vorname, $nachname, $matrikelnummer, $email, $status);
                            $statement_bewerber->store_result();
                            while($statement_bewerber->fetch())
                            {
                                echo"<tr>";
                                echo"<td style='color: #000000;'>{$themenbezeichnung}</td>";
                                echo"<td><center>{$matrikelnummer}</center></td>";
                                echo"<td><center>{$nachname},{$vorname}</center></td>";
                                echo"<td><center>{$email}</center></td>";      
                                if($status == "angenommen")
                                {
                                    echo"<td><center><div class='status_annahme'>Angenommen</div></center></td>"; 
                                }      
                                else
                                {
                                    echo"<td><center><input value='{$email}' name='email[]' type='checkbox'> <i class='fa fa-envelope' aria-hidden='true'></i></input></center></td>"; 
                                } 
                            }
                        }       
                    }    
                    echo"</tr>";
                    echo"<tr>";
                    echo"<td colspan='4'></td>";
                    echo"<td colspan='1'><center><a data-toggle='modal' data-target='#annahme' title='Annahme per E-Mail'><annahme>✓</annahme></a></center></td>";
                    
                    // Sicherheitsabfrage wenn Annahme
                    echo"<div class='modal fade' id='annahme' tabindex='-1' role='dialog' aria-labelledby='annahme' aria-hidden='true'>";
                    echo"<div class='modal-dialog'>";
                    echo"<div class='modal-content'>";
                    echo"<div class='modal-header'>";
                    echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Annahme(n) per E-Mail verschicken</h5>";
                    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo"<span aria-hidden='true'>&times;</span></button>";
                    echo"</div>";
                    echo"<div class='modal-body'>";
                    echo"<div class='alert alert-secondary' role='alert'><p style='margin: 0px; padding px;'><center>Sind sie sich sicher, dass Sie die Bewerber über ihre <b>Annahme</b> per E-Mail benachrichtigen wollen?</center></div></p>";echo"<p class='debug-url'></p>";
                    echo"</div>";
                    echo"<div class='modal-footer'>";
                    echo"<input type='submit' style='background-color:#4bc671; color:#ffffff;' class='btn btn-default' name='annahme_windhund'  data-toggle='tooltip' value='Annahme(n) verschicken'></input>";
                    echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</tr>";
                    echo"</table>"; 
                    echo"</div></form>";   
                    break;        
                }           
                break;  
            }
        }
        //Werden keine Eintragungen auf Themen in diesem Modul gefunden, so wird eine rote Meldung angezeigt,
        // dass noch keine Eintragungen erfolgt sind.
        else
        {
            echo "<div class='alert alert-secondary' role='alert'> <i style='color: red;' class='fa fa-exclamation-triangle' aria-hidden='true'></i> Es sind zur Zeit keine Bewerbungen eingegangen.</div>";
        } 
    
    }

    public function bewerbungEinsicht($thema_id)
    {
        $bewerber_anz_check = $this->bewerbung->getBewerberAnzahlThema($thema_id);
        $bewerber_anz_check ->bind_result($anzahl_bewerber_check);
        $bewerber_anz_check ->store_result();
        while($bewerber_anz_check->fetch())
        {
            if($anzahl_bewerber_check == '0')
            {
                echo "<div class='alert alert-secondary' role='alert'> <i style='color: red;' class='fa fa-exclamation-triangle' aria-hidden='true'></i> Es sind zur Zeit keine Bewerbungen eingegangen.</div>";
            }
            else
            {
                $statement_modul = $this->thema->getThemaDetails($thema_id);
                $statement_modul->bind_result($modul_id, $themenbezeichnung, $thema_verfuegbarkeit);
                $statement_modul->store_result();
                while($statement_modul->fetch())
                {
                    $statement_mod = $this->modul->getModulbezeichnungEnde($modul_id);
                    $statement_mod->bind_result($modulbezeichnung, $frist_ende);
                    $statement_mod->store_result();
                    while($statement_mod->fetch())
                    {
                        date_default_timezone_set("Europe/Berlin");
                        $aktuell = new DateTime(date("Y-m-d"));
                        $ende= new DateTime($frist_ende);
                        
                        // Hole die bewerber zum Thema raus
                        $bewerber = $this->bewerbung->getBewerberDetails($thema_id);
                        $bewerber->bind_result($bewerbung_id, $matrikelnummer, $email, $studiengang, $fachsemester, $credit_anzahl, $seminar_teilnahme, $status);
                        $bewerber->store_result();
                        
                        // Hole die Anzahl der bewerber
                        $bewerber_anz = $this->bewerbung->getBewerberAnzahlThema($thema_id);
                        $bewerber_anz ->bind_result($anzahl_bewerber);
                        $bewerber_anz ->store_result();
                        while($bewerber_anz ->fetch())
                        {
                            echo "<div class='alert alert-secondary' style='background-color: rgba(34,36,38,.025)' role='alert'>Aktuell existieren <b>{$anzahl_bewerber}</b> Bewerber für das Thema <b>\"{$themenbezeichnung}\"</b>.</div>";  
                        }
                        
                        ?><form method="post" action="?action=<?php echo"{$_GET['action']}&id={$_GET['id']}";  ?>" onsubmit="setTimeout('parent.location.reload()',500);"><?php
                        echo " <div class='bewerbung_verwaltung'> ";
                        echo " <table id='row'>";
                        echo "    <tr>   ";     
                        echo "        <th><center>Matrikelnummer</center></th>   ";
                        echo "        <th><center>Studiengang</center></th>";
                        echo "        <th>Semester</th>";
                        echo "         <th>Credits</th>";
                        echo "         <th><center>Scoring</center></th>   ";
                        echo "         <th><center>Funktionen<BR>         ";
                        echo "        <input type='checkbox' onclick='toggle(this);' /> Alle</center></th>";
                        echo "    </tr>";
    
                        while($bewerber->fetch())
                        {
                            //Hole die gesamten Punkte des Bewerbers
                            $score_gesamt = $this->punkte->getPunkteGesamt($bewerbung_id);
                            $score_gesamt->bind_result($gesamt_punkte);
                            $score_gesamt->store_result();
                            echo "<tr>";
                            echo "<td><center>{$matrikelnummer}</center></td>";
                            echo" <td><center>{$studiengang}</center></td>";
                            echo "<td><center>{$fachsemester}</center></td>";
                            echo "<td><center>{$credit_anzahl}</center></td>";  
                            
                            while($score_gesamt->fetch())
                            {
                                echo "<td><center>{$gesamt_punkte}</center></td>";
                            }
                            if($aktuell<$ende)
                            {
                                echo"<td><center><div class='status_ausstehend'>Ausstehend</div></center></td>"; 
                            }
                            else
                            {
                                // Wenn bewerber angenommen wurde
                                if($status == "angenommen")
                                {
                                    echo"<td><center><div class='status_annahme'>Angenommen</div></center></td>";
                                }
                                // oder abgelehnt wurde
                                elseif($status == "abgelehnt")
                                {
                                    echo"<td><center><div class='status_ablehnung'>Abgelehnt</div></center></td>";
                                }
                                //Noch keine Rückmeldung
                                else 
                                {
                                    echo"<td><center><input value='{$email}' name='email[]' type='checkbox'> <i class='fa fa-envelope' aria-hidden='true'></i></input></center></td>"; 
                                }
                            }
                            echo "</tr>";
                        }
                        echo "<tr>";
                        echo "<td colspan='5'></td>";
                        echo "<td colspan='1'><center><a data-toggle='modal' data-target='#annahme' title='Annahme per E-Mail'><annahme>✓</annahme></a> ";
                        echo "<a data-toggle='modal' data-target='#ablehnung' title='Ablehnung per E-Mail'><ablehnung>X</ablehnung></a></center></td>";
                        echo "</tr>";

                        // Sicherheitsabfrage wenn auf ANNAHME geklickt wird
                        echo"<div class='modal fade' id='annahme' tabindex='-1' role='dialog' aria-labelledby='annahme' aria-hidden='true'>";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' id='titel'>Sicherheitsabfrage: Annahme(n) per E-Mail verschicken</h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<div class='alert alert-success' role='alert'><p style='margin: 0px; padding px;'><center>Sind sie sich sicher, dass Sie die Bewerber über ihre <b>Annahme</b> per E-Mail benachrichtigen wollen?</center></div></p>";
                        echo"<p class='debug-url'></p>";
                        echo"</div>";
                        echo"<div class='modal-footer'>";
                        echo"<input type='submit' style='background-color:#4bc671; color:#ffffff;' class='btn btn-default' name='annahme_bewerbung'  data-toggle='tooltip' value='Annahme(n) verschicken'></input>";
                        echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                        
                        // Sicherheitsabfrage wenn auf ABLEHNUNG geklickt wird
                        echo"<div class='modal fade' id='ablehnung' tabindex='-1' role='dialog' aria-labelledby='ablehnung' aria-hidden='true'>";
                        echo"<div class='modal-dialog'>";
                        echo"<div class='modal-content'>";
                        echo"<div class='modal-header'>";
                        echo"<h5 class='modal-title' style='font-size: 16.5px;' id='titel'>Sicherheitsabfrage: Ablehnung(en) per E-Mail verschicken</h5>";
                        echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo"<span aria-hidden='true'>&times;</span></button>";
                        echo"</div>";
                        echo"<div class='modal-body'>";
                        echo"<div class='alert alert-danger' role='alert'><p style='margin: 0px; padding px;'><center>Sind sie sich sicher, dass Sie die Bewerber über ihre <b>Ablehnung</b> per E-Mail benachrichtigen wollen?</center></div></p>";
                        echo"<p class='debug-url'></p>";
                        echo"</div>";
                        echo"<div class='modal-footer'>";
                        echo"<input type='submit' style='background-color:red; color:#ffffff;' class='btn btn-default' name='ablehnung_bewerbung'  data-toggle='tooltip' value='Ablehnung(en) verschicken'></input>";
                        echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                        echo"</div>";
                        echo "</table>";
                        echo "</div>";
                        echo "</form>";
                    }
                }
            }
        }
    }

    public function emailBelegwunschWindhund($modul_id, $email, $verfahren, $annahme)
    {
        // EMAIL CONTENT
        //Load composer's autoloader
        $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'stickywebsinfo@gmail.com';         // SMTP username
        $mail->Password = 'sticky112';                        // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->CharSet = 'utf-8';
        $mail->SetLanguage ("de");
        $mail->setFrom('stickywebsinfo@gmail.com', 'Sticky Webs');  // Absender
        $mail->addReplyTo('stickywebsinfo@gmail.com', 'Annahme');
        $mail->addCC('stickywebsinfo@gmail.com');
        $mail->addBCC('stickywebsinfo@gmail.com');
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML

        //CONFIGURATIONEN ENDE
        //###########################################################
        
        $statement = $this->modul->getModulbezeichnung($modul_id);
        $statement->bind_result($modulbezeichnung);
        $statement->store_result();
        while($statement->fetch())
        {
            try 
            {
                //Betreff definieren
                $mail->Subject = 'Annahmebestätigung';
                //Alle ausgewählten emails werden hier durchlaufen
                for($i = 0; $i < count($_POST['email']); $i++)
                {
                    //Status der Bewerber anpassen, sowohl auch den Status der Themen anpassen
                    if($verfahren == "windhund")
                    {
                        $this->windhund->updateStatusGetMail($annahme, $email[$i]);
                        $this->windhund->updateThemaMail("Vergeben", $email[$i]);
                    }
                    else
                    {
                        $this->belegwunsch->updateStatusGetMail($annahme, $email[$i]);
                        $this->belegwunsch->updateThemaMail("Vergeben", $email[$i]);

                    }
                    $email2= $email[$i];
                    $mail->addAddress($email[$i], 'Bewerber');     // Add a recipient

                    //Anhand der Mail die Themenbezeichnung aus der DB holen
                    $statement_thema = $this->thema->getMailThemenbezeichnung($verfahren, $modul_id, $email2);
                    $statement_thema->bind_result($themenbezeichnung);
                    $statement_thema->store_result();

                    //Inhalt der Mail definieren
                    while($statement_thema->fetch())
                    {
                        $mail->Body    = 'Sehr geehrte Studierende,<br><br>
                        Hiermit bestätigen wir Ihnen die Annahme zum Modul <b>"' . $modulbezeichnung . '"</b> und den Erhalt des Themas <b>"' . $themenbezeichnung . '".<br></b>
                        Bitte denken Sie daran, dass Sie sich später auch noch über FlexNow für die Veranstaltung anmelden müssen.<br> 
                        Die FlexNow-Anmeldefristen sowie alle weiteren Informationen zum Modul werden Sie demnächst direkt von der Professur erhalten. <br><br> 
                        Wir wünschen Ihnen viel Erfolg beim Modul!<br><br>
                        Mit freundlichen Grüßen,<br>
                        M.Sc. in Wirtsch.-Inf. Henrik Wesseloh<br><br>
                        Wirtschaftswissenschaftliche Fakultät<br>
                        Georg-August-Universität Göttingen<br>
                        Platz der Göttinger Sieben 3 (MZG 5.121)<br>
                        37073 Göttingen';

                        //Absenden der Mail
                        $mail->send();
                    }
                }
                // Modal zum Erfolgreichen absenden
                echo"<script>
                $(window).load(function()
                {
                    $('#email_sucess').modal('show');
                });
                </script>";
                echo "<div id='email_sucess' class='modal fade' role='dialog'>";
                echo "<div class='modal-dialog'>";
                echo "<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'>E-Mail(s) erfolgreich verschickt.</h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo "<div class='modal-body'>";
                echo"<p><div style='float:left; width:100%;'class='alert alert-success' role='alert'> <img style='float:left;' src='img/checked.png'><center><br><b>Die Bestätigungs-Email(s) wurde(n) erfolgreich versendet.</b></center></div></p>";
                echo"<p class='debug-url'></p>";
                echo"</div>";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
            }
            //Bei misserfolg der Mailversendung wird ein Modal angezeigt, welches darüber berichtet
            catch (Exception $e) 
            {
                echo"<script>
                $(window).load(function()
                {
                    $('#email_fail').modal('show');
                });
                </script>";
                echo "<div style='top: 30%' id='email_fail' class='modal fade' role='dialog'>";
                echo"<div class='modal-dialog'>";
                echo"<div class='modal-content'>";
                echo"<div class='modal-header'>";
                echo"<h5 class='modal-title' id='titel'>Fehler aufgetreten!</h5>";
                echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo"<span aria-hidden='true'>&times;</span></button>";
                echo"</div>";
                echo"<div class='modal-body'>";
                echo"<p><div style='float:left; width:100%;' class='alert alert-danger' role='alert'> <img style='float:left;' src='img/ups.png'><center><br><b>Beim versenden einer Bestätigung, ist ein Fehler aufgetreten.<br></b></center></div></p>";
                echo"<p class='debug-url'></p>";
                echo"</div>";
                echo"<div class='modal-footer'>";
                echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
            }  
        }
    }

    public function emailBewerbung($thema_id, $email, $ablehnung, $annahme)
    {
        // EMAIL CONTENT
        //Load composer's autoloader
        $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'stickywebsinfo@gmail.com';         // SMTP username
        $mail->Password = 'sticky112';                        // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->CharSet = 'utf-8';
        $mail->SetLanguage ("de");
        $mail->setFrom('stickywebsinfo@gmail.com', 'Sticky Webs');  // Absender
        $mail->addReplyTo('stickywebsinfo@gmail.com', 'Annahme');
        $mail->addCC('stickywebsinfo@gmail.com');
        $mail->addBCC('stickywebsinfo@gmail.com');
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML

        //CONFIGURATIONEN ENDE
        //###########################################################
        
        $statement_modul = $this->thema->getBezeichnungModulId($thema_id);
        $statement_modul->bind_result($modul_id, $themenbezeichnung);
        $statement_modul->store_result();
        while($statement_modul->fetch())
        {
            $statement = $this->modul->getModulbezeichnung($modul_id);
            $statement->bind_result($modulbezeichnung);
            $statement->store_result();
            while($statement->fetch())
            {
                try 
                {
                    //Wenn der bewerber angenommen wird, dann wird der Status des Bewerbers auf "angenommen" gesetzt
                    //und das Thema wird auf "vergeben" gesetzt
                    if(isset($_POST['annahme_bewerbung']))
                    {
                        for($i = 0; $i < count($_POST['email']); $i++)
                        {
                            $this->bewerbung->updateStatusGetMail($annahme, $email, $i);
                            $this->thema->updateVerfuegbarkeit($thema_id, "Vergeben");
                            $email2= $email[$i];
                            $mail->addAddress($email[$i], 'Bewerber');     // Add a recipient
                        }
                        $mail->Subject = 'Annahmebestätigung'; 
                        $mail->Body    = 'Sehr geehrte Studierende,<br><br>
                        Hiermit bestätigen wir Ihnen die Annahme zum Modul <b>"' . $modulbezeichnung . '"</b> und den Erhalt des Themas <b>"' . $themenbezeichnung . '".<br></b>
                        Bitte denken Sie daran, dass Sie sich später auch noch über FlexNow für die Veranstaltung anmelden müssen.<br> 
                        Die FlexNow-Anmeldefristen sowie alle weiteren Informationen zum Modul werden Sie demnächst direkt von der Professur erhalten. <br><br> 
                        Wir wünschen Ihnen viel Erfolg beim Modul!<br><br>
                        Mit freundlichen Grüßen,<br>
                        M.Sc. in Wirtsch.-Inf. Henrik Wesseloh<br><br>
                        Wirtschaftswissenschaftliche Fakultät<br>
                        Georg-August-Universität Göttingen<br>
                        Platz der Göttinger Sieben 3 (MZG 5.121)<br>
                        37073 Göttingen';
                    }
                    //Wenn der Bewerber abgelehnt wird, dann wird nur der Bewerberstatus geändert -> auf "abgelehnt"
                    if(isset($_POST['ablehnung_bewerbung']))
                    {
                        for($i = 0; $i < count($_POST['email']); $i++)
                        {
                            $statement = $this->bewerbung->updateStatusGetMail($ablehnung, $email, $i);
                            $email2= $email[$i];
                            $mail->addAddress($email[$i], 'Bewerber');     // Add a recipient 
                       
                        }
                        $mail->Subject = 'Ablehnungsbestätigung';
                        $mail->Body    = 'Sehr geehrte Studierende,<br><br>
                        Leider müssen wir Ihnen verkünigen, dass sie keinen Platz innerhalb des Moduls <b>"' . $modulbezeichnung . '"</b> mit dem von Ihnen beworbene Thema <b>"' . $themenbezeichnung . '"</b> erhalten haben.<br>
                        Sollte ein Nackrückverfahren stattfinden, können Sie sich nachträglich auf eines der freien Themen bewerben.<br>
                        Die Vergabe des Themas erfolgt durch das Windhundverfahren und sie erhalten das Thema sicher.<br><br>
                        Mit freundlichen Grüßen,<br>
                        M.Sc. in Wirtsch.-Inf. Henrik Wesseloh<br><br>
                        Wirtschaftswissenschaftliche Fakultät<br>
                        Georg-August-Universität Göttingen<br>
                        Platz der Göttinger Sieben 3 (MZG 5.121)<br>
                        37073 Göttingen';
                    }
                    // Die Mail wird versendet
                    $mail->send();

                    //Modale zum Erfolg/Misserfolg werden angezeigt
                    echo"<script>
                    $(window).load(function()
                    {
                        $('#email_sucess').modal('show');
                    });
                    </script>";
                    echo "<div style='top: 30%' id='email_sucess' class='modal fade' role='dialog'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo"<div class='modal-header'>";
                    echo"<h5 class='modal-title' id='titel'>E-Mail(s) erfolgreich verschickt.</h5>";
                    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo"<span aria-hidden='true'>&times;</span></button>";
                    echo"</div>";
                    echo "<div class='modal-body'>";
                    echo"<p><div style='float:left; width:100%;'class='alert alert-success' role='alert'> <img style='float:left;' src='img/checked.png'><center><br><b>Die Bestätigungs-Email(s) wurde(n) erfolgreich versendet.</b></center></div></p>";
                    echo"<p class='debug-url'></p>";
                    echo"</div>";echo"<div class='modal-footer'>";
                    echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                }
                catch (Exception $e) 
                {
                    echo"<script>
                    $(window).load(function()
                    {
                        $('#email_fail').modal('show');
                    });
                    </script>";
                    echo "<div style='top: 30%' id='email_fail' class='modal fade' role='dialog'>";
                    echo"<div class='modal-dialog'>";
                    echo"<div class='modal-content'>";
                    echo"<div class='modal-header'>";
                    echo"<h5 class='modal-title' id='titel'>Fehler aufgetreten!</h5>";
                    echo"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo"<span aria-hidden='true'>&times;</span></button>";
                    echo"</div>";
                    echo"<div class='modal-body'>";
                    echo"<p><div style='float:left; width:100%;' class='alert alert-danger' role='alert'> <img style='float:left;' src='img/ups.png'><center><br><b>Beim versenden einer Bestätigung, ist ein Fehler aufgetreten.<br></b></center></div></p>";
                    echo"<p class='debug-url'></p>";
                    echo"</div>";
                    echo"<div class='modal-footer'>";
                    echo"<button type='button' class='btn btn-default' data-dismiss='modal'>Fenster schließen</button>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                    echo"</div>";
                }
            }
        }
    }
}