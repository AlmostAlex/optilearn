<?php
include("controller/index_controller.php");
include("db.php");
?>

<?php
 $q=$_GET["q"];
 $control = new index_controller();
 $control->free_user_formular_getBezirk($q);


echo"HIiiiiiiiiii";
?>

