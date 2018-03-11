<?php
include('header.php');
require("controller/index_controller.php");
require("db.php");
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

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function showBezirk(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            $("#waehle_stadt").slideDown();
            $("#bezirk").slideUp();
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                    $("#waehle_stadt").slideUp();
                    $("#bezirk").slideDown();
                }
            };
            xmlhttp.open("GET", "getBezirk.php?q=" + str, true);
            xmlhttp.send();
        }
    }
</script>
<br><br>
<center><div class="title">
        <h2>Optilearn - Login-System</h2>
        <span class="byline">Als registrierter User oder Free-User!</span>
    </div> 
</center>



<div class="forms">
	<ul class="tab-group">
		<li class="tab active"><a href="#login">Log In</a></li>
		<li class="tab"><a href="#signup">Sign Up</a></li>
	</ul>
	<form action="#" id="login">
	      <h1>Login on w3iscool</h1>
	      <div class="input-field">
                    feld 1
	      </div>
	  </form>
	  <form action="#" id="signup">
	      <h1>Sign Up on w3iscool</h1>
	      <div class="input-field">
                  feld 2
	      </div>
	  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
	  $('.tab a').on('click', function (e) {
	  e.preventDefault();
	  
	  $(this).parent().addClass('active');
	  $(this).parent().siblings().removeClass('active');
	  
	  var href = $(this).attr('href');
	  $('.forms > form').hide();
	  $(href).fadeIn(500);
	});
});
</script>


<box>

<?php
$control = new index_controller();
$control->free_user_formular();
?>
</box>

<br><br><br>
<!--    EinfÃ¼gen der Form zum einloggen    -->
            <form method='post'>
                <table>
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
<?php
if (isset($_POST["einloggen"])) 
{
    $control = new index_controller();
    $control->login();
}

include('navi.php');
include('footer.php');
?>