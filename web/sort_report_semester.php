<script> $(function () { $('[data-toggle="tooltip"]').tooltip()}) </script>
<?php  
 //sort.php  
require("db.php");
 $order = $_POST["order"]; 
 $output = '';  
 $semester = $_POST["semester"];  
 
 if($order == 'desc')  
 {  
      $order = 'asc';  
 }  
 else  
 {  
      $order = 'desc';  
 }  

 $list = $_POST['column_name']; 
        $statement = $dbh->prepare(
        "SELECT modul_id, modulbezeichnung, verfahren, frist_start, frist_ende, nachrueckverfahren
        FROM modul 
        WHERE semester =?
        ORDER BY {$list} {$order} ");
        $statement->bind_param('s', $semester);
        $statement->execute();
        $statement->bind_result($modul_id, $modulbezeichnung,$verfahren, $frist_start, $frist_ende, $nachrueckverfahren);
        $statement->store_result();
    
 $output .= '  
 <semester><table class="table table-bordered">  
      <tr>  
           <th><span class="column_sort" id="modul_id" data-order="'.$order.'">ID</span></th>  
           <th><span class="column_sort" id="modulbezeichnung" data-order="'.$order.'">Modulbezeichnung</span></th>
           <th><span class="column_sort" id="frist_start" data-order="'.$order.'">Starttermin</span></th>  
           <th><span class="column_sort" id="frist_ende" data-order="'.$order.'">Endtermin</span></th>    
           <th><span class="column_sort" id="verfahren" data-order="'.$order.'">Verfahren</span></th>     
           <th><span class="column_sort" id="nachrueckverfahren" data-order="'.$order.'">Nachrückverfahren</span></th> 
           <th><i data-toggle="tooltip" data-placement="top" title="Verfügbaren/Vergebenen Themen" class="fas fa-question-circle"></i></th>
      </tr>  
 ';      
$verfuegbarkeit = "Verfügbar";                                                  
while($statement->fetch()){    
            $start_anzeige = date("d-m-Y", strtotime($frist_start));
            $ende_anzeige = date("d-m-Y", strtotime($frist_ende));
                    
            $statement_thema = $dbh->prepare("SELECT themenbezeichnung, beschreibung, thema_id, thema_verfuegbarkeit FROM thema WHERE modul_id = ?");
            $statement_thema->bind_param('i', $modul_id);
            $statement_thema->execute();
            $statement_thema->bind_result($themenbezeichnung, $beschreibung, $thema_id, $thema_verfuegbarkeit);
            $statement_thema->store_result();
            
            while ($statement_thema->fetch()) {

                $statement_themenanzahl = $dbh->prepare("SELECT count(thema_id) as anzahl FROM thema WHERE modul_id = ?");
                $statement_themenanzahl->bind_param('i', $modul_id);
                $statement_themenanzahl->execute();
                $statement_themenanzahl->bind_result($anzahl);
                $statement_themenanzahl->store_result();
                while ($statement_themenanzahl->fetch()) {
      
                    $statement_verfuegbar = $dbh->prepare("SELECT count(thema_id) as anzahl_thema_verfuegbar FROM thema WHERE modul_id = ? AND thema_verfuegbarkeit= ? ");
                    $statement_verfuegbar->bind_param('is', $modul_id, $verfuegbarkeit);
                    $statement_verfuegbar->execute();
                    $statement_verfuegbar->bind_result($anzahl_thema_verfuegbar);
                    $statement_verfuegbar->store_result();
                    while ($statement_verfuegbar->fetch()) {        
                }
               }
            }
       
      $output .= "  
      <tr>  
           <td>{$modul_id}</td>  
           <td>{$modulbezeichnung}</td> 
           <td>{$start_anzeige}</td> 
           <td>{$ende_anzeige}</td> 
           <td>{$verfahren}</td>  
           <td>{$nachrueckverfahren}</td>
           <td>{$anzahl}/{$anzahl_thema_verfuegbar}</td>
      </tr>  
      ";  
 }  

 $output .= '</table></semester>';  
 echo $output;  

?>  
