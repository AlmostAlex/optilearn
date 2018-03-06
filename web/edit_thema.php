<?php
include ("header.php");
include ("Controllers/modul_controller.php");
?>

<?php

if (isset($_POST["thema_edit"])) {
    $id = base64_decode($_GET['id']);
    $thema_id = $id;
    $themenbezeichnung = $_POST['themenbezeichnung'];        
    $themenbeschreibung = $_POST['themenbeschreibung'];
    $thema = new modul_controller();
    $thema->updateThema($themenbezeichnung, $themenbeschreibung, $thema_id);    
}

if (isset($_GET['action']) && $_GET['action'] == 'editThema' && isset($_GET['id'])) 
{
    $id = base64_decode($_GET['id']);
    $thema_id = $id; 
    $thema = new modul_controller();
    $thema->altesThema($thema_id);
}
else
{
    echo"ne";
}
include("navi.php");
include("footer.php");
?>