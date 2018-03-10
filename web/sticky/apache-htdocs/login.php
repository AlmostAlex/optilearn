<?php
include("header.php");
require_once("Controllers/benutzer_controller.php");
?>

<!--    Einfügen der Form zum einloggen    -->
<div class='logform'>
    <form method='post'>
        <table style='width: 90%; margin: 5%;'>
            <tr>
                <td colspan='3'><h4 class='card-title'><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i> Login-Bereich</h4></td>
            </tr>
            <tr>      
                <td>                
                    <div class="input-group">
                        <span style='background-color: white; padding-left: 15px; padding-right: 14px;' class="input-group-addon"> <i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type='text' class='form-control' placeholder="Benutzername" required name='benutzername' required>
                    </div></td>
            </tr>
            <tr>

                <td>                
                    <div class="input-group">
                        <span style='background-color: white;' class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                        <input type='password' class='form-control' placeholder="Passwort" required name='passwort' required>
                    </div></td>
            </tr>
            <tr>      
                <td><br><input style='padding-left: 7%; padding-right: 7%;  float:right; ' type='submit' class='buttons' name='einloggen' value='Login'></td>
            </tr>
        </table>
    </form>
</div>


<?php
//  Prüfung, ob die Form abgeschickt wurde und weiterleitung zur "einloggen"-funktion im Controller
if (isset($_POST["einloggen"])) {
    $control = new benutzer_controller();
    $control->einloggen();
}

include 'navi.php';
include("footer.php");
?>