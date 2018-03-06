<?php 
include 'header.php';
include ("Controllers/reporting_controller.php");
require ('db.php')
?>
<br><br>
<h3><i class="fas fa-align-justify"></i> Report-System Inhalte</h3><br>
<?php
if (isset($_POST['report'])) {
    $semester = $_POST['semester']; 
    $modul_aktuell = $_POST['modulbezeichnung'];
    $report = new reporting_controller();
    $report->ReportBasis($semester,$modul_aktuell);  
}

?>  

<?php
include("navi.php");
include("footer.php");
?>  
