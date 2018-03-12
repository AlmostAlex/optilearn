<?php
require("controller/index_controller.php");
require("db.php");
?>

<?php
 $q=$_GET["q"];
 $control = new index_controller();
 $control->free_user_formular_getUni($q);

?>

