<?php
include 'header.php';
require "controller/index_controller.php";
require "db.php";
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

<div class="forms">
    <ul class="tab-group">
        <li class="tab active"><a href="#login">LogIn</a></li>
        <li class="tab"><a href="#signup">Registrierung</a></li>
        <li class="tab"><a href="#free">Login als Free-User</a></li>
    </ul>
    <form method='post' id="login">
        <h1>Login auf Optilearn</h1>
        <div class="input-field">
            <div style='float:left; margin-top: -100px;' class="contact1-pic js-tilt" data-tilt>
                <img src="images/login_logo.png" alt="IMG">
            </div>
            <table>
                <tr>
			<td><label>Benutzername:</label></td>
                    <td>
                            <input type='text' class='form-control' placeholder="Benutzername" required name='benutzername' required>
                    </td>
                </tr>
                <tr>
			<td><label>Passwort:</label></td>
                    <td>
                            <input type='password' class='form-control' placeholder="Passwort" required name='passwort' required>

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type='submit' class='buttons' name='einloggen' value='Login'>
			</td>
                </tr>
            </table>
            <?php
if (isset($_POST["einloggen"])) {
    $control = new index_controller();
    $control->login();
}
?>
        </div>
    </form>
    <form method='post' id="signup">
        <h1>Registrierung</h1>
        <div class="input-field">
            <div style='float:left;' class="contact1-pic js-tilt" data-tilt>
                <img src="images/register_logo.png" alt="IMG">
            </div>
        </div>
        <table>
            <tr>
                <td>
                    <label>Benutzername:</label>
                </td>
                <td><input type='Benutzername' class='form-control' placeholder="Benutzername" name='benutzername' required></td>
            </tr>

            <tr>
                <td>
                    <label>Passwort:</label>
                </td>
                <td><input type='Passwort' class='form-control' placeholder="Passwort" name='passwort1' required></td>
            </tr>
            <tr>
                <td>
                    <label>Passwort wiederholen:</label>
                </td>
                <td><input type='Passwort' class='form-control' placeholder="Passwort2" name='passwort2' required></td>
            </tr>
            <tr>
                <td>
                    <label>E-Mail:</label>
                </td>
                <td><input class='form-control' placeholder="Email"  name='email' required></td>
            </tr>
            <tr>
                <td>
                    <label>Name:</label>
                </td>
                <td><input class='form-control' placeholder="Name"  name='vorname' required></td>
            </tr>
            <tr>
                <td>
                    <label>Nachname:</label>
                </td>
                <td><input class='form-control' placeholder="Nachname"  name='nachname' required></td>
            </tr>
            <script>
                $(document).ready(function () {
		$("#business").hide();
		$("#student").hide();
                    $('#nutzertyp').on('change', function () {
                        if (this.value == 'business')
                        {
                            $("#business").slideDown("slow");

                            $("#student").slideUp("slow");

                        }     if (this.value == 'student')
			{

			$("#business").slideUp("slow");

                        $("#student").slideDown("slow");
                        }
                    });
                });
            </script>

			<?php
$control = new index_controller();
$control->formularStadtDropdown();
?>


            <tr>
                <td>
                    <label>Nutzen als:</label>
                </td>
                <td>
			<select name="nutzertyp" id="nutzertyp" >
                        <option>Als was nutzt du die Anwendung?</option>
                        <option value="business">Business/Arbeit</option>
                     	<option value="student">Student</option>
                    </select>
		</td>
            <tr>
        </table>

	<!-- WENN BUSINESS GEWäHLT WIRD-->
        <div style='display:none;' id='business'>
            <table>
                <tr>
                    <td>
                       <label>Kreditkarte:</label>
                    </td>
			<td>
			<select name='kreditkarte' id='kreditkarte'>
                        <option>Ihr Anbieter</option>
                        <option value="Visa">Visa</option>
                     	<option value="MasterCard">MasterCard</option>
                    </select>
		</td>
                </tr>
                <tr>
                    <td>
                       <label>Kreditkartennummer</label>
                    </td>
			<td>
			  <td><input class='form-control' placeholder="Kreditnr" name='kreditkartenNr'></td>
			</td>
                </tr>
            </table>
        </div>

       <div style='display:none;' id='student'>
            <table>
                <tr>
                    <td>
			 <div id="txtHint2"></div>
                    </td>
                </tr>
            </table>
        </div>
                <tr>
                    <td>
                        <input style='padding-left: 7%; padding-right: 7%;  float:right; ' type='submit' class='buttons' name='register' value='Registrieren!'>
			</td>
                </tr>
    </form>

<?php
if (isset($_POST["register"])) 
{
    $control = new index_controller();
    $control->registrieren();
}
?>

<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/tilt/tilt.jquery.min.js"></script>
    <form id="free">
        <h1>Sign Up on w3iscool</h1>
        <div class="input-field">
            <div style='float:left;' class="contact1-pic js-tilt" data-tilt>
                <img src="images/free_logo.png" alt="IMG">
            </div>
            <?php
$control->free_user_formular();
?>
        </div>
    </form>
</div>

<?php
include 'navi.php';
include 'footer.php';
?>