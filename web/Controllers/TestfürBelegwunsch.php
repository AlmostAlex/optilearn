<?php

//Festlegen der Bewerberanzahl und der ThemaAnzahl
$bewerberAnzahl = $this->belegwunsch->getBewerberAnzahl($modul_id);
$themaAnzahl = $this->thema->getModulThemaAnzahldirekt($modul_id);
echo "modul ID: ".$modul_id."</br>";

//Status der Themen auf "Frei" setzen und Status der Bewerber auf "Hat nichts!" setzen.
$statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
$statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
$statement_thema_bewerber->store_result();
while($statement_thema_bewerber->fetch())
{
    echo $belegwunsch_id."----";
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

//Testausgabe aller Bewerber + Thema + Punkte + Gesamtpunktzahl
$statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
$statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
$statement_thema_bewerber->store_result();
while($statement_thema_bewerber->fetch())
{
    echo "Bewerber_ID: "."\t".$belegwunsch_id."</br>";
    echo "Status: "."\t".$array[$belegwunsch_id]['Status']."</br>";
    echo "Erhaltenes Thema: "."\t".$array[$belegwunsch_id]['Thema']."</br>";
    echo "Punkzahl: "."\t".$array[($array[$belegwunsch_id]['Thema'])]['Punkte']."</br></br></br>";
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
                }
                else if($wunsch_2 == $thema_id)
                {
                    $Punktzahl1 = $array[($array[$belegwunsch_id]['Thema'])]['Punkte'];
                    $Punktzahl2 = 110;
                    $TauschThema = $array[$belegwunsch_id]['Thema'];
                    $bewerbungErhalten = true;
                }
                else if($wunsch_3 == $thema_id)
                {
                    $Punktzahl1 = $array[($array[$belegwunsch_id]['Thema'])]['Punkte'];
                    $Punktzahl2 = 105;
                    $TauschThema = $array[$belegwunsch_id]['Thema'];
                    $bewerbungErhalten = true;
                }
            }
            if($bewerbungErhalten == true)
            {
                $statement_thema_bewerber = $this->belegwunsch->getThemaBewerber($modul_id);
                $statement_thema_bewerber->bind_result($belegwunsch_id, $wunsch_1, $wunsch_2, $wunsch_3);
                $statement_thema_bewerber->store_result();
                while($statement_thema_bewerber->fetch())
                {
                    if($array[$belegwunsch_id]['Status'] == "Hat nichts!")
                    {
                        if($wunsch_1 == $TauschThema)
                        {
                            $Saldo = 115 + $Punktzahl2 - $Punktzahl1;
                            echo $Saldo;
                            if($Saldo >= 0)
                            {
                                $neuesThema = $array[($array[$TauschThema]['Bewerber'])]['Thema'];

                                $array[$thema_id]['Punkte'] = $Punktzahl2;
                                $array[$thema_id]['Bewerber'] = ($array[$TauschThema]['Bewerber']);
                                $array[$thema_id]['Status'] = "Vergeben";
                                $array[($array[$TauschThema]['Bewerber'])]['Thema'] = $thema_id;

                                $array[$neuesThema]['Punkte'] = 115;
                                $array[$neuesThema]['Bewerber'] = $belegwunsch_id;
                                $array[$belegwunsch_id]['Status'] = "Hat was!";
                                $array[$belegwunsch_id]['Thema'] = $neuesThema;
                            }
                        }
                        else if($wunsch_2 == $TauschThema)
                        {
                            $Saldo = 110 + $Punktzahl2 - $Punktzahl1;
                            echo $Saldo;
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
                            echo $Saldo;
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

?>