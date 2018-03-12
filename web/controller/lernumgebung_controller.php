<?php
include("model/lernumgebung_model.php");


class lernumgebung_controller 
{
    public $benutzer;


    public function __construct() 
    {
        $this->lernumgebung = new lernumgebung_model();
    }

    public function lernumgebung() 
    {
	
        $statement = $this->lernumgebung->getAllLernumgebung();
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
?>
	

<?php

    }
}


