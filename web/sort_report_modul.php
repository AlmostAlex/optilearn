<?php

require("db.php");
$order_thema  = $_POST["order_thema"];
$output_thema  = '';
$modulbezeichnung = $_POST["modulbezeichnung"];

 if($order_thema  == 'desc')  
 {  
      $order_thema  = 'asc';  
 }  
 else  
 {  
      $order_thema  = 'desc';  
 }  

$list_thema  = $_POST['column_name_thema'];
$statement = $dbh->prepare("SELECT thema.thema_id, thema.themenbezeichnung, thema.thema_verfuegbarkeit FROM thema,modul WHERE modul.modul_id = thema.modul_id AND modul.modulbezeichnung=?
ORDER BY {$list_thema} {$order_thema} ");
$statement->bind_param('s', $modulbezeichnung);
$statement->execute();
$statement->bind_result($thema_id, $themenbezeichnung, $thema_verfuegbarkeit);
$statement->store_result();

 $output_thema .= ' 
                <semester><table class="table table-bordered">  
                        <tr>  
                            <th><span class="column_sort_thema" id="thema_id" data-order_thema="'.$order_thema.'">ID</span></th>  
                            <th><span class="column_sort_thema" id="themenbezeichnung" data-order_thema="'.$order_thema.'">Themenbezeichnung</span></th> 
                            <th><span class="column_sort_thema" id="thema_verfuegbarkeit" data-order_thema="'.$order_thema.'">Verfügbarkeit</span></th> 
                        </tr>      
';





while ($statement->fetch()) {
 $output_thema .="    
    <tr>
    <td>{$thema_id}</td>
    <td>{$themenbezeichnung}</td>
    <td>{$thema_verfuegbarkeit}</td>
    </tr> 
    ";
}

 $output_thema .='    </table>    
              </semester>';

echo $output_thema;

?>
