<?php
include("header.php");
require("controller/lernumgebung_controller.php");
require("db.php");
?>


<center><div class="title">
        <h2>Optilearn - �bersicht der R�ume</h2>
    </div>
</center>

            <?php
                $control = new lernumgebung_controller();
                $control->lernumgebung();
            
            ?>


<?php
include("navi.php");
include("footer.php");
?>
