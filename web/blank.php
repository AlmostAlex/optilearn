<?php
include("header.php");
require("controller/lernumgebung_controller.php");
require("db.php");
?>


<center>
    <div class="title">
        <h2>Optilearn - Übersicht der Räume</h2>
    </div>
</center>
<?php

if($_SESSION["typ"] == 1)
{
    $control = new lernumgebung_controller();
    $control->lernumgebungStudent();
}
else if($_SESSION["typ"] == 2)
{
    $control = new lernumgebung_controller();
    $control->lernumgebungBusiness();
}

elseif($_SESSION["typ"] == 3)
{
    $control = new lernumgebung_controller();
    $control->lernumgebungFree();
}




include("navi.php");
include("footer.php");
?>
