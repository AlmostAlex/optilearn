<?php
include ("header_admin.php");
include ("Controllers/belegwunsch_controller.php");
?>


<?php
if (isset($_GET['action']) && $_GET['action'] == 'auswertung' && isset($_GET['id'])) {
$modul_id = base64_decode($_GET['id']);

    $auswertung = new belegwunsch_controller();
    $auswertung->Belegwunschauswertung($modul_id);

}

else{
echo "nix";
}

?>
<?php
include("navi.php");
include("footer.php");
?>  