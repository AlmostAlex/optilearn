<?php
include("model/benutzer_model.php");
include("model/stadt_model.php");
include("model/stadtbezirk_model.php");

class index_controller {

    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $benutzer;

    public function __construct() {
        $this->benutzer = new benutzer_model();
        $this->stadt = new stadt_model();
        $this->stadtbezirk = new stadtbezirk_model();
    }

    //Eintragung des Bewerbers in dem Modul (windhund)
    public function login() {
        $passwort = $_POST["passwort"];
        $benutzername = $_POST["benutzername"];
        $pass_corr = $this->benutzer->LoginKontrolle($benutzername, $passwort);
        if ($pass_corr == TRUE) {
            $_SESSION['login'] = $this->benutzer->getBenutzerId($benutzername); // Loggt einen ein!
            echo"<div class='alertlogin'><div class='alert alert-success' role='alert'><b>Anmeldung war erfolreich!</b><br>Die Weiterleitung erfolgt in wenigen Sekunden. <br> <img src='img/ajax-loader.gif'></div></div>";
            echo "<meta http-equiv='refresh' content='1.5; URL=/blank.php'>"; // Weiterleitung zur Verwaltung 
        } else {
            echo "<div class='alertlogin'><div class='alert alert-danger role='alert'><b>Achtung!</b><br>Das Passwort und der Benutzername stimmen nicht überein.</div></div>";
        }
    }

    public function free_user_formular_getBezirk($stadt_id) {
        $statement = $this->stadtbezirk->getAllBezirk($stadt_id);
        $statement->bind_result($Bezirk_id, $Bezirkbezeichnung);
        $statement->store_result();
        ?>
        <div class="form-group">
            <table>
                <tr>
                    <td><label class="col-sm-2 col-form-label">Stadtbezirk</label></td> 
                    <td><select class="form-control" id="bezirk" name="bezirk">
                            <?php
                            echo "<option id=''>Wähle einen Stadtbezirk aus!</option>";
                            while ($statement->fetch()) {
                                echo "<option value='{$Bezirk_id}'>{$Bezirkbezeichnung}</option>";
                            }
                            ?>
                        </select> 
                    </td>
                <tr>
            </table>
        </div>
        <button class="button" type="submit">Als Free-User einloggen</button>  
        <?php
    }

    public function free_user_formular() {
        $statement = $this->stadt->getAllBezeichnung();
        $statement->bind_result($stadtbezeichnung, $stadt_id);
        $statement->store_result();
        ?>
            <div class="form-group">
                <table>
                    <tr>
                        <td><label class="col-sm-2 col-form-label">Stadt</label></td> 
                        <td><select class="form-control" id='stadt' name="stadt" onchange="showBezirk(this.value)">
                                <?php
                                echo "<option id=''>Wähle eine Stadt aus!</option>";
                                while ($statement->fetch()) {
                                    echo "<option value='{$stadt_id}'>{$stadtbezeichnung}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    <tr>
                </table>
                <div id="waehle_stadt">Wähle eine Stadt aus.</div>
                <div id="txtHint"></div>  
            </div>

        <?php
    }

    public function registrieren() 
    {
        if($_POST["passwort"] == $_POST[""])
        if($_POST["Nutzertyp"] == "Student")
        {
            
        }
        $passwort = $_POST["passwort"];
        $benutzer = $_POST["benutzername"];
        if (!empty($password) && !empty($benutzer)) 
        {
            $pass_corr = $this->model->LoginKontrolle($benutzer, $passwort);

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
