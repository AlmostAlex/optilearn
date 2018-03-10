<?php
include ("header.php");
include ("Controllers/modul_controller.php");
?>

<?php
if (isset($_POST["modul_edit"])) {
    $modul_id = base64_decode($_GET['id']); 
    $update_modul = new modul_controller();
    $update_modul->updateModul($modul_id);
}

if (isset($_GET['action']) && $_GET['action'] == 'deleteThema' && isset($_GET['id'])) 
{
    $thema_id = base64_decode($_GET['id']);
    $delete_thema = new modul_controller();
    $delete_thema->deleteThema($thema_id); 
}

if (isset($_GET['action']) && $_GET['action'] == 'editModul' && isset($_GET['id'])) {
    $modul_id = base64_decode($_GET['id']);

    $Übersicht = new modul_controller();
    $Übersicht->ModelübersichtEdit($modul_id);
}
else 
{
    echo"<meta http-equiv='refresh' content='0; URL=/mt_verwaltung.php'>";
}

echo"<br><br><br>";
include("navi.php");
include("footer.php");
?>  
