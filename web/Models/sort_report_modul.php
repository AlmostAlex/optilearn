<?php

require("db.php");
$order = $_POST["order"];
$output = '';
$modulbezeichnung = $_POST["modulbezeichnung"];


 if($order == 'desc')  
 {  
      $order = 'asc';  
 }  
 else  
 {  
      $order = 'desc';  
 }  

$list = $_POST['column_name'];

 $output .= ' 

                <semester><table class="table table-bordered">  
                        <tr>  
                            <th><span class="column_sort" id="thema.thema_id" data-order="'.$order.'">ID</span></th>  
                            <th><span class="column_sort" id="thema.themenbezeichnung" data-order="'.$order.'">Themenbezeichnung</span></th> 
                            <th><span class="column_sort" id="thema.thema_verfuegbarkeit" data-order="'.$order.'">Verfügbarkeit</span></th> 
                        </tr>      
';

$statement = $dbh->prepare("SELECT thema.thema_id, thema.themenbezeichnung, thema.thema_verfuegbarkeit FROM thema,modul WHERE modul.modul_id = thema.modul_id AND modul.modulbezeichnung=?
ORDER BY {$list} {$order} ");
$statement->bind_param('s', $modulbezeichnung);
$statement->execute();
$statement->bind_result($thema_id, $themenbezeichnung, $thema_verfuegbarkeit);
$statement->store_result();

while ($statement->fetch()) {
 $output .="    
    <tr>
    <td>{$thema_id}</td>
    <td>{$themenbezeichnung}</td>
    <td>{$thema_verfuegbarkeit}</td>
    </tr> 
    ";
}

 $output .='    </table>    
              </semester> ';

echo $output;

?>
