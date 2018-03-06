<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class reporting_model
{
public $dbh;

    public function __construct() 
    {
        require("db.php");
        $this->dbh = $dbh;
    }
    
    
    }
?>
