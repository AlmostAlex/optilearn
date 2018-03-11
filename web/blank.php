<?php
include('header.php');
require("controller/index_controller.php");
require("db.php");
?> 

<br><br><br>
<div class="contact1">
		<div class="container-contact1">
			<div class="contact1-pic js-tilt" data-tilt>
				<img src="images/img-01.png" alt="IMG">
			<!--    EinfÃ¼gen der Form zum einloggen    -->
			</div>
	</div>
</div>

<!--<script src="vendor/jquery/jquery-3.2.1.min.js"></script>-->
<!--<script src="vendor/bootstrap/js/popper.js"></script>-->
<!--<script src="vendor/bootstrap/js/bootstrap.min.js"></script>-->
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/tilt/tilt.jquery.min.js"></script>


	























<?php
if (isset($_POST["einloggen"])) 
{
    $control = new index_controller();
    $control->login();
}

include('navi.php');
include('footer.php');
?>