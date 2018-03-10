<?php
require("model/benutzer_model.php");
require("model/stadt_model.php");

class index_controller {

    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $benutzer;

    public function __construct() {
        $this->benutzer = new benutzer_model();
        $this->stadt = new stadt_model();
    }

    //Eintragung des Bewerbers in dem Modul (windhund)
    public function login() {
        $passwort = $_POST["passwort"];
        $benutzername = $_POST["benutzername"];
        if (!empty($password) && !empty($benutzer)) {
            $pass_corr = $this->benutzer->LoginKontrolle($benutzername, $passwort);

            if ($pass_corr == TRUE) {
                $_SESSION['login'] = $this->benutzer->getBenutzerId($benutzername); // Loggt einen ein!
                echo"<div class='alertlogin'><div class='alert alert-success' role='alert'><b>Anmeldung war erfolreich!</b><br>Die Weiterleitung erfolgt in wenigen Sekunden. <br> <img src='img/ajax-loader.gif'></div></div>";
                echo "<meta http-equiv='refresh' content='1.5; URL=/verwaltung.php'>"; // Weiterleitung zur Verwaltung 
            } else {
                echo "<div class='alertlogin'><div class='alert alert-danger role='alert'><b>Achtung!</b><br>Das Passwort und der Benutzername stimmen nicht überein.</div></div>";
            }
        } else {
            echo "<div class='alertlogin'><div class='alert alert-danger' role='alert'><b>Achtung!</b><br>Bitte fÃ¼lle alle Eingabefelder aus!</div></div>";
        }
    }

    public function free_user_formular() {
        $statement = $this->stadt->getAllBezeichnung();
        $statement->bind_result($stadtbezeichnung, $stadt_id);
        $statement->store_result();
        ?>
        <form>
            <label>Stadt</label>
            <select name="users" onchange="showUser(this.value)">
        <?php
        while ($statement->fetch()) {
            echo "<option value='{$stadt_id} '>{$stadtbezeichnung}</option>";
        }
        ?>
            </select>
        </form>
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
