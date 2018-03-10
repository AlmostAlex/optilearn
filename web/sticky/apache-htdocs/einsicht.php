<?php
include ("header.php");
include ("Controllers/einsicht_controller.php");
?>

<br><h4>Verwaltung der Bewerbungen</h4>

<?php

$verfahrenanzeige = new einsicht_controller();

if(isset($_GET['action']) && $_GET['action'] == 'Belegwunschverfahren' && isset($_GET['id'])) 
{
    $modul_id =  base64_decode($_GET['id']);
    $verfahrenanzeige->belegwunschEinsicht($modul_id);
}

?><!-- WINDHUND --><?php

if(isset($_GET['action']) && ($_GET['action'] == 'Windhundverfahren') && isset($_GET['id'])) 
{
    $modul_id =  base64_decode($_GET['id']);
    $verfahrenanzeige->windhundEinsicht($modul_id);
}

// BEWERBUNGSVERFAHREN BEWERBUNGEN

if(isset($_GET['action']) && $_GET['action'] == 'Bewerbungsverfahren' && isset($_GET['id'])) 
{
    $thema_id =  base64_decode($_GET['id']);
    $verfahrenanzeige->bewerbungEinsicht($thema_id);

    if(isset($_POST['annahme_bewerbung']) || isset($_POST['ablehnung_bewerbung']) && isset($_GET['action'])) 
    {
        if(!empty($_POST['email']))
        {
            $thema_id =  base64_decode($_GET['id']);
            $email = $_POST['email'];      
    
            $verfahrenanzeige->emailBewerbung($thema_id, $email, "abgelehnt", "angenommen");
        }
    }

}

if((isset($_POST['annahme_windhund']) || isset($_POST['annahme_belegwunsch']) ) && isset($_GET['action'])) 
{ 
    if(isset($_POST['annahme_belegwunsch']))
    {
        $verfahren = "belegwunsch";
    }
    else
    {
        $verfahren = "windhund";
    }
    if(!empty($_POST['email']))
    {
        $modul_id =  base64_decode($_GET['id']);
        $email = $_POST['email'];      

        $verfahrenanzeige->emailBelegwunschWindhund($modul_id, $email, $verfahren, "angenommen");
    }
}



include("navi.php");
include("footer.php");
?>  
