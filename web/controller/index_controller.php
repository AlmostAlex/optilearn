<?php
require("model/benutzer_model.php");
require("model/stadt_model.php");

class index_controller 
{

    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $benutzer;

    public function __construct() 
    {
        $this->benutzer = new benutzer_model();
        $this->stadt = new stadt_model();
    }

    public function login() 
    {
        echo $_POST["benutzername"];
        echo $_POST["passwort"];
        $passwort = $_POST["passwort"];
        $benutzername = $_POST["benutzername"];
        echo "....".$passwort."...".$benutzername;
        if (!empty($password) && !empty($benutzer)) 
        {
            $pass_corr = $this->benutzer->LoginKontrolle($benutzername, $passwort);

            if ($pass_corr == TRUE) 
            {
                $_SESSION['login'] = $this->benutzer->getBenutzerId($benutzername); // Loggt einen ein!
                echo"<div class='alertlogin'><div class='alert alert-success' role='alert'><b>Anmeldung war erfolreich!</b><br>Die Weiterleitung erfolgt in wenigen Sekunden. <br> <img src='img/ajax-loader.gif'></div></div>";
                echo "<meta http-equiv='refresh' content='1.5; URL=/blank.php'>"; // Weiterleitung zur Verwaltung 
            } 
            else 
            {
                echo "<div class='alertlogin'><div class='alert alert-danger role='alert'><b>Achtung!</b><br>Das Passwort und der Benutzername stimmen nicht überein.</div></div>";
            }
        } 
        else 
        {
            echo "<div class='alertlogin'><div class='alert alert-danger' role='alert'><b>Achtung!</b><br>Bitte fülle alle Eingabefelder aus!</div></div>";
        }
    }

    public function free_user_formular() 
    {
        ?>
        <script>
            <script>
                function showCD(str) {
                        if (str == "") {
                document.getElementById("txtHint").innerHTML= "";         
                return;
            } 
            if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                } else {  // code for IE6, IE5
                        xmlhtt p  = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (this.readyState == 4 && this.status == 200) {
                document.ge t Elem entById("txtHint").innerHTML = this.responseText;
                }
                }
                xmlhttp.open("GET","/ajax/getbezirk.php?q="+str,true);
                    xmlhttp.send();
                    }
        </script>
            <?php
            $statement = $this->stadt->getAllBezeichnung();
            $statement->bind_result($stadtbezeichnung, $stadt_id);
            $statement->store_result();
            ?>
                    <form>
                        <label>Stadt</label>
                        <select name="users" onchange="showStadtbezirk(this.value)">
                            <?php
                            echo "<option value=''>Wähle eine Stadt aus!</option>";
                            while ($statement->fetch()) {
                                echo "<option id='{$stadt_id}'>{$stadtbezeichnung}</option>";
                            }
                            ?>
                        </select>
                    </form>
                        <div id="txtHint"><b>CD info will be listed here...</b></div>
                    <?php
                }

                public function registrieren() {
                    $password = $_POST["passwort"];
                    $benutzer = $_POST["benutzername"];
                    if (!empty($password) && !empty($benutzer)) {
                        $pass_corr = $this->model->LoginKontrolle($benutzer, $password);

                        if ($pass_corr == TRUE) {

                            $_SESSION['login'] = $this->model->getId($benutzer); // Loggt einen ein!           
                            echo"<div class='alertlogin'><div class='alert alert-success' role='alert'><b>Anmeldung war erfolreich!</b><br>Die Weiterleitung erfolgt in wenigen Sekunden. <br> <img src='img/ajax-loader.gif'></div></div>";
                            echo "<meta http-equiv='refresh' content='1.5; URL=/verwaltung.php'>"; // Weiterleitung zur Verwaltung 
                        } else {
                            echo "<div class='alertlogin'><div class='alert alert-danger role='alert'><b>Achtung!</b><br>Das Passwort und der Benutzername stimmen nicht Ã¼berein.</div></div>";
                        }
                    } else {
                        echo "<div class='alertlogin'><div class='alert alert-danger' role='alert'><b>Achtung!</b><br>Bitte fÃ¼lle alle Eingabefelder aus!</div></div>";
                    }
                }

            }
            