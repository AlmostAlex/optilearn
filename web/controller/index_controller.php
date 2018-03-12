<?php
include("model/benutzer_model.php");
include("model/stadt_model.php");
include("model/stadtbezirk_model.php");
include("model/student_model.php");
include("model/business_model.php");
include("model/uni_model.php");

class index_controller 
{

    //Erstellen einer Variable vom Typ benutzer_model, 
    //damit alle Funktionen Zugriff auf diese über $this->modul haben
    public $benutzer;

    public function __construct() 
    {
        $this->benutzer = new benutzer_model();
        $this->stadt = new stadt_model();
        $this->stadtbezirk = new stadtbezirk_model();
        $this->student = new student_model();
        $this->uni = new uni_model();
        $this->business = new business_model();
    }

    //Eintragung des Bewerbers in dem Modul (windhund)
    public function login() 
    {
        $passwort = $_POST["passwort"];
        $benutzername = $_POST["benutzername"];
        $pass_corr = $this->benutzer->LoginKontrolle($benutzername, $passwort);
        if ($pass_corr == TRUE) 
        {
            $_SESSION['login'] = $this->benutzer->getBenutzerId($benutzername); // Loggt einen ein!
            $_SESSION['typ'] = $this->benutzer->getBenutzerTyp($_SESSION["login"]);
            echo"<div class='alertlogin'><div class='alert alert-success' role='alert'><b>Anmeldung war erfolreich!</b><br>Die Weiterleitung erfolgt in wenigen Sekunden. <br> <img src='img/ajax-loader.gif'></div></div>";
            echo"<meta http-equiv='refresh' content='1.5; URL=/blank.php'>"; // Weiterleitung zur Verwaltung 
        } 
        else 
        {
            echo "<div class='alertlogin'><div class='alert alert-danger role='alert'><b>Achtung!</b><br>Das Passwort und der Benutzername stimmen nicht überein.</div></div>";
        }
    }

    public function freeLogin()
    {
        $_SESSION['stadt'] = $_POST["stadt"];
        $_SESSION['bezirk'] = $_POST["bezirk"];
        $_SESSION['typ'] = 3;
        echo "DAS IST DIE SESSION: ".$_SESSION['login'];
        echo"<div class='alertlogin'><div class='alert alert-success' role='alert'><b>Räume werden aufgerufen!</b><br>Die Weiterleitung erfolgt in wenigen Sekunden. <br> <img src='img/ajax-loader.gif'></div></div>";
        echo"<meta http-equiv='refresh' content='5.0; URL=/blank.php'>"; // Weiterleitung zur Verwaltung 

    }

    public function registrieren()
    {
        if($_POST["passwort1"] == $_POST["passwort2"])
        {
            if($_POST["nutzertyp"] == "student")
            {
                $benutzername = $_POST["benutzername"];
                $passwort = password_hash($_POST["passwort1"], PASSWORD_DEFAULT);
                $vorname = $_POST["vorname"];
                $nachname = $_POST["nachname"];
                $email = $_POST["email"];
                $nutzertyp = 1;
                $stadt = $_POST["stadt"];
                $uni = $_POST["uni"];

                $benutzerduplikat = $this->benutzer->duplikatBenutzer($benutzername);
                $emailduplikat = $this->benutzer->duplikatEmail($email);

                if(($benutzerduplikat != $benutzername) && ($emailduplikat != $email))
                {
                    $last_id = $this->benutzer->insertBenutzer($benutzername, $passwort, $email, $nutzertyp, $vorname, $nachname);
                    $this->student->insertStudent($last_id, $uni, $stadt);
                }
                else
                {
                    if($benutzerduplikat != $benutzername)
                    {
                        echo "BENUTZERNAME IST BEREITS VERGEBEN!";
                    }
                    else
                    {
                        echo "EMAIL IST BEREITS VERGEBEN!";
                    }
                }
            }
            elseif($_POST["nutzertyp"] == "business")
            {
                $benutzername = $_POST["benutzername"];
                $passwort = password_hash($_POST["passwort1"], PASSWORD_DEFAULT);
                $vorname = $_POST["vorname"];
                $nachname = $_POST["nachname"];
                $email = $_POST["email"];
                $nutzertyp = 2;
                if(isset($_POST["kreditkarte"]))
                {
                    $kreditkarte = $_POST["kreditkarte"];
                }
                else
                {
                    $kreditkarte = "kein index";
                }
                $kreditkartenNr = $_POST["kreditkartenNr"];
                $stadt = $_POST["stadt"];

                $benutzerduplikat = $this->benutzer->duplikatBenutzer($benutzername);
                $emailduplikat = $this->benutzer->duplikatEmail($email);

                if(($benutzerduplikat != $benutzername) && ($emailduplikat != $email))
                {
                    $last_id = $this->benutzer->insertBenutzer($benutzername, $passwort, $email, $nutzertyp, $vorname, $nachname);
                    $this->business->insertBusiness($last_id, $kreditkarte, $kreditkartenNr, $stadt);
                }
                else
                {
                    if($benutzerduplikat != $benutzername)
                    {
                        echo "BENUTZERNAME IST BEREITS VERGEBEN!";
                    }
                    else
                    {
                        echo "EMAIL IST BEREITS VERGEBEN!";
                    }
                }
            }
        }
        else
        {
            echo "DIE PASSWÖRTER SIND NICHT IDENTISCH";
        }
    }

    public function formularStadtDropdown() 
    {
        $statement = $this->stadt->getAllBezeichnung();
        $statement->bind_result($stadtbezeichnung, $stadt_id);
        $statement->store_result();
        ?>
            <tr>
                <td><label>Stadt</label></td> 
                <td><select class="form-control" id="stadt" name="stadt"onchange="showUni(this.value)">
                        <?php
                        echo "<option value=''>Wähle eine Stadt aus!</option>";
                        while ($statement->fetch()) 
                        {
                            echo "<option value='{$stadt_id}'>{$stadtbezeichnung}</option>";
                        }
                        ?>
                    </select> 
                </td>
            <tr>
        <?php
    }

    public function free_user_formular_getBezirk($stadt_id) 
    {
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
                            while ($statement->fetch()) 
                            {
                                echo "<option value='{$Bezirk_id}'>{$Bezirkbezeichnung}</option>";
                            }
                            ?>
                        </select> 
                    </td>
                <tr>
            </table>
        </div>
        <button class="button" name = 'freelogin' type="submit">Als Free-User einloggen</button>  
        <?php

    }

    public function free_user_formular_getUni($stadt_id) 
    {
        echo $stadt_id;
        $statement = $this->uni->getAllUni($stadt_id);
        $statement->bind_result($uni_id, $unibezeichnung);
        $statement->store_result();
        ?>
            <tr>
                <td><label>Universität</label></td> 
                <td><select class="form-control" id="uni" name="uni">
                        <?php
                        echo "<option id=''>Wähle eine Universität aus!</option>";
                        while ($statement->fetch()) 
                        {
                            echo "<option value='{$uni_id}'>{$unibezeichnung}</option>";
                        }
                        ?>
                    </select> 
                </td>
            <tr>
        <?php
    }

    public function free_user_formular() 
    {
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
                        while ($statement->fetch()) 
                        {
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
}
