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


<! ----------------------------------------------------------->
<link rel="stylesheet" type="text/css" href="java/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="java/vendor/animate/animate.css">
<link rel="stylesheet" type="text/css" href="java/vendor/css-hamburgers/hamburgers.min.css">
<link rel="stylesheet" type="text/css" href="java/vendor/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<! ----------------------------------------------------------->

<div class="contact1">
	<div class="container-contact1">
        <div class="contact1-pic js-tilt" data-tilt>
            <img src="images/Login.png" alt="IMG">
        </div>
        <!--    Einfügen der Form zum einloggen    -->
        <div class='logform'>
            <form class="contact1-form validate-form" method='post'>
                <table style='width: 90%; margin: 5%;'>
                    <tr>
                        <td colspan='3'><h4 class='card-title'><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i> Login-Bereich</h4></td>
                    </tr>
                    <tr>      
                        <td>                
                            <div class="input-group">
                                <span style='background-color: white; padding-left: 15px; padding-right: 14px;' class="input-group-addon"> <i class="fa fa-user" aria-hidden="true"></i></span>
                                <input type='text' class='form-control' placeholder="Benutzername" required name='benutzername' required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>                
                            <div class="input-group">
                                <span style='background-color: white;' class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                                <input type='password' class='form-control' placeholder="Passwort" required name='passwort' required>
                            </div>
                        </td>
                    </tr>
                    <tr>      
                        <td>
                            <br><input style='padding-left: 7%; padding-right: 7%;  float:right; ' type='submit' class='buttons' name='einloggen' value='Login'></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<! ----------------------------------------------------------->
<script src="java/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="java/vendor/bootstrap/js/popper.js"></script>
<script src="java/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="java/vendor/select2/select2.min.js"></script>
<script src="java/vendor/tilt/tilt.jquery.min.js"></script>
<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
</script>
<! ----------------------------------------------------------->
<?php
if (isset($_POST["einloggen"])) {
    $control = new index_controller();
    $control->login();
}



<?php
include('navi.php');
include('footer.php');
?>