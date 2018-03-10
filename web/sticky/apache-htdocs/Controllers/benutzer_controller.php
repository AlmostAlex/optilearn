<?php
require("Models/benutzer_model.php");

class benutzer_controller
{
    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->model haben
    public $model;

    public function __construct() {
        $this->model = new benutzer_model();
    }

    public function einloggen()
    {
        //Übergabe der Formeingaben, Kontrolle ob diese auch ausgefüllt worden sind und
        //Aufruf der Modelfunktion "LoginKontrolle" mit diesen.
        $password = $_POST["passwort"];
        $benutzer = $_POST["benutzername"];
        if (!empty($password) && !empty($benutzer))
        {  
            $pass_corr = $this->model->LoginKontrolle($benutzer,$password);
            
            if ($pass_corr == TRUE) 
            {

                $_SESSION['login'] = $this->model->getId($benutzer); // Loggt einen ein!           
                echo"<div class='alertlogin'><div class='alert alert-success' role='alert'><b>Anmeldung war erfolreich!</b><br>Die Weiterleitung erfolgt in wenigen Sekunden. <br> <img src='img/ajax-loader.gif'></div></div>";
                echo "<meta http-equiv='refresh' content='1.5; URL=/verwaltung.php'>"; // Weiterleitung zur Verwaltung 
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
}
    ?>