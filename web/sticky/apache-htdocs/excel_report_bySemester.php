<?php 
require ('db.php');

if(isset($_POST['export_excel'])){
   $ausgabe='';
   $semester = $_GET['semester'];
        $statement = $dbh->prepare("SELECT modul_id, modulbezeichnung,verfahren, frist_start, frist_ende, nachrueckverfahren FROM modul WHERE semester = ?");
        $statement->bind_param('s', $semester);
        $statement->execute();
        $statement->bind_result($modul_id, $modulbezeichnung,$verfahren, $frist_start, $frist_ende, $nachrueckverfahren);
        $statement->store_result();
        
   echo '"Id";"Modulbezeichnung";"Verfahren";"Starttermin";"Endtermin"' . "\n";
      while($statement->fetch()){  
          $ausgabe .= "{$modul_id}; {$modulbezeichnung}; {$verfahren}; {$frist_start}; {$frist_ende} "."\n";
      }    
      
function convertToWindowsCharset($string) {
    $charset =  mb_detect_encoding(
    $string,
    "UTF-8, ISO-8859-1, ISO-8859-15",
    true
  );
  $string =  mb_convert_encoding($string, "Windows-1252", $charset);
  return $string;
}

$str = convertToWindowsCharset($ausgabe);
echo $str;

    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header("Content-disposition: attachment; filename=filename.csv");
    header("Pragma: public");
    header("Expires: 0"); 
  die();

}
   ?>
