<?php
include('header.php');
require("db.php");
require("controller/index_controller.php");
?>

<div class="title">
    <span class="byline">Fragen und Antworten</span>
</div> 

<answer>
    <ul>
        <li>
            <div class="panel-heading"><a style='border-top: 1px dotted #000000;' class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Results</a></div>
        </li>      
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
                ongue rutnt a lacus atongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesenongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesen urnantum nibh augue praesent
            </div>
        </div>  
        
        <li>
            <div class="panel-heading"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">Results</a></div>
        </li>      
        <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
                ongue rutnt a lacus atongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesenongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesen urnantum nibh augue praesent
            </div>
        </div> 
    </ul>
</answer>
		
<br><br>
<center><div class="title">
    <h2>Optilearn - Login-System</h2>
    <span class="byline">Als registrierter User oder Free-User!</span>
</div> 
</center>

<?php
    $control = new index_controller();
    $control->free_user_formular();
    ?>

<div class="contact1">
		<div class="container-contact1">
            <div class="contact1-pic js-tilt" data-tilt>
                <img src="images/Login.png" alt="IMG">
            </div>
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
</div></div></div>




<?php
include('navi.php');
include('footer.php');
?>