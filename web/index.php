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
            <div style='float:left;' class="contact1-pic js-tilt" data-tilt>
                <img src="images/login_logo.png" alt="IMG">
            </div>
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
                <td><input type='Benutzername' class='form-control' placeholder="Benutzername" required name='Benutzername' required></td>
            </tr>

            <tr>      
                <td>                
                    <label>Passwort:</label>
                </td>
                <td><input type='Passwort' class='form-control' placeholder="Passwort" required name='Passwort' required></td>
            </tr>
            <tr>      
                <td>                
                    <label>Passwort wiederholen:</label>
                </td>
                <td><input type='Passwort2' class='form-control' placeholder="Passwort2" required name='Passwort2' required></td>
            </tr>                
            <tr>      
                <td>                
                    <label>E-Mail:</label>
                </td>
                <td><input type='Email' class='form-control' placeholder="Email" required name='Email' required></td>
            </tr>                
            <tr>      
                <td>                
                    <label>Name:</label>
                </td>
                <td><input type='Name' class='form-control' placeholder="Name" required name='Name' required></td>
            </tr> 
            <tr>      
                <td>                
                    <label>Nachname:</label>
                </td>
                <td><input type='Nachname' class='form-control' placeholder="Nachname" required name='Nachname' required></td>
            </tr>
            <script>
                $(document).ready(function () {
                    $('#purpose').on('change', function () {
                        if (this.value == '1')
                        {
                            $("#business").slideDown("slow")
                        } else
                        {
                            $("#business").hide();
                        }
                    });
                });
            </script>
            <tr>   
                <td>
                    <label>Nutzen als:</label>
                </td>
                <td><select id='purpose'>
                        <option>Als was nutzt du die Anwendung?</option>
                        <option value="0">Personal use</option>
                        <option value="1">Business use</option>
                    </select></td>
            <tr>
        </table>

        <div style='display:none;' id='business'>
            <table>
                <tr>
                    <td> 
                        Business Name teste undso               
                    </td>
                </tr>           
            </table> 
        </div>
       <div style='display:none;' id='student'>
            <table>
                <tr>
                    <td> 
                        Student Name teste undso               
                    </td>
                </tr>           
            </table> 
        </div>
        
    </form>
    <form id="free">
        <h1>Sign Up on w3iscool</h1>
        <div class="input-field">
            <div style='float:left;' class="contact1-pic js-tilt" data-tilt>
                <img src="images/free_logo.png" alt="IMG">
            </div>
            <?php
            $control = new index_controller();
            $control->free_user_formular();
            ?>
        </div>
    </form>  
</div>

<?php
include('navi.php');
include('footer.php');
?>