<?php
include("model/lernumgebung_model.php");
include("model/student_model.php");
include("model/business_model.php");


class lernumgebung_controller 
{
    public $benutzer;


    public function __construct() 
    {
        $this->lernumgebung = new lernumgebung_model();
        $this->student = new student_model();
        $this->business = new business_model();
    }

    public function lernumgebungStudent()
    {
        $uni_id = $this->student->getUniID($_SESSION["login"]);

        $statement = $this->lernumgebung->getAllLernumgebungFree();
        $statement->bind_result($lernumgebung_id,$lernbezeichnung,$plaetze,$lernart);
        $statement->store_result();
        while ($statement->fetch())
        {
            echo"<div class='content_raeume'>";
            echo"<a href='details.php?action=einsicht&id={$lernumgebung_id}' target='_blank'>";
            echo"<div class='content_raeume-overlay'></div>";
            echo"<img class='content_raeume-image' src='images/raum.png'>";
            echo"<div class='content_raeume-details fadeIn-bottom'>";
            echo"<h3 class='content_raeume-title'>ID: {$lernumgebung_id}</h3>";
            echo"<p class='content_raeume-text'>This is a short description</p>";
            echo"</div>";
            echo"</a>";
            echo"</div>";
        }
        $statement = $this->lernumgebung->getAllLernumgebungStudent($uni_id);
        $statement->bind_result($lernumgebung_id,$lernbezeichnung,$plaetze,$lernart);
        $statement->store_result();
        while ($statement->fetch())
        {
            echo"<div class='content_raeume'>";
            echo"<a href='details.php?action=einsicht&id={$lernumgebung_id}' target='_blank'>";
            echo"<div class='content_raeume-overlay'></div>";
            echo"<img class='content_raeume-image' src='images/raum.png'>";
            echo"<div class='content_raeume-details fadeIn-bottom'>";
            echo"<h3 class='content_raeume-title'>ID: {$lernumgebung_id}</h3>";
            echo"<p class='content_raeume-text'>This is a short description</p>";
            echo"</div>";
            echo"</a>";
            echo"</div>";
        }
    }

    public function lernumgebungBusiness()
    {
        $statement = $this->lernumgebung->getAllLernumgebungFree();
        $statement->bind_result($lernumgebung_id,$lernbezeichnung,$plaetze,$lernart);
        $statement->store_result();
        while ($statement->fetch())
        {
            echo"<div class='content_raeume'>";
            echo"<a href='details.php?action=einsicht&id={$lernumgebung_id}' target='_blank'>";
            echo"<div class='content_raeume-overlay'></div>";
            echo"<img class='content_raeume-image' src='images/raum.png'>";
            echo"<div class='content_raeume-details fadeIn-bottom'>";
            echo"<h3 class='content_raeume-title'>ID: {$lernumgebung_id}</h3>";
            echo"<p class='content_raeume-text'>This is a short description</p>";
            echo"</div>";
            echo"</a>";
            echo"</div>";
        }

        $statement = $this->lernumgebung->getAllLernumgebungBusiness();
        $statement->bind_result($lernumgebung_id,$lernbezeichnung,$plaetze,$lernart,$kosten);
        $statement->store_result();
        while ($statement->fetch())
        {
            echo"<div class='content_raeume'>";
            echo"<a href='details.php?action=einsicht&id={$lernumgebung_id}' target='_blank'>";
            echo"<div class='content_raeume-overlay'></div>";
            echo"<img class='content_raeume-image' src='images/raum.png'>";
            echo"<div class='content_raeume-details fadeIn-bottom'>";
            echo"<h3 class='content_raeume-title'>ID: {$lernumgebung_id}</h3>";
            echo"<p class='content_raeume-text'>This is a short description</p>";
            echo"</div>";
            echo"</a>";
            echo"</div>";
        }
    }

    public function lernumgebungFree()
    {
        $statement = $this->lernumgebung->getAllLernumgebungFree();
        $statement->bind_result($lernumgebung_id,$lernbezeichnung,$plaetze,$lernart);
        $statement->store_result();
        while ($statement->fetch())
        {
            echo"<div class='content_raeume'>";
            echo"<a href='details.php?action=einsicht&id={$lernumgebung_id}' target='_blank'>";
            echo"<div class='content_raeume-overlay'></div>";
            echo"<img class='content_raeume-image' src='images/raum.png'>";
            echo"<div class='content_raeume-details fadeIn-bottom'>";
            echo"<h3 class='content_raeume-title'>ID: {$lernumgebung_id}</h3>";
            echo"<p class='content_raeume-text'>This is a short description</p>";
            echo"</div>";
            echo"</a>";
            echo"</div>";
        }
    }
}


