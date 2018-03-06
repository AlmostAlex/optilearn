<?php
	ob_start (); 
	session_start (); 
	session_unset (); 
	session_destroy (); 
	ob_end_flush ();
	//Zurueck zum Login
	header("Location: index.php");
?>


