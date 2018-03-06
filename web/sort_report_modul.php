<?php

require("db.php");
$order_thema = $_POST["order_thema"];
$output_thema = '';
$modulbezeichnung = $_POST["modulbezeichnung"];
$verfahren = $_POST["verfahren"];

if ($order_thema == 'desc') {
    $order_thema = 'asc';
} else {
    $order_thema = 'desc';
}
$anzahl_bewerber ="0";
$bew_sum ="0";
$list_thema = $_POST['column_name_thema'];

$statement = $dbh->prepare("SELECT thema.thema_id, thema.themenbezeichnung, thema.thema_verfuegbarkeit FROM thema,modul WHERE modul.modul_id = thema.modul_id AND modul.modulbezeichnung=?
ORDER BY {$list_thema} {$order_thema} ");
$statement->bind_param('s', $modulbezeichnung);
$statement->execute();
$statement->bind_result($thema_id, $themenbezeichnung, $thema_verfuegbarkeit);
$statement->store_result();

$output_thema .= ' 
                <semester><table class="table table-bordered">  
                        <tr>  
                            <th><span class="column_sort_thema" id="thema_id" data-order_thema="' . $order_thema . '">ID</span></th>  
                            <th><span class="column_sort_thema" id="themenbezeichnung" data-order_thema="' . $order_thema . '">Themenbezeichnung</span></th> 
                            <th><span class="column_sort_thema" id="thema_verfuegbarkeit" data-order_thema="' . $order_thema . '">Verfügbarkeit</span></th> 
                            <th><i data-toggle="tooltip" data-placement="top" title="Anzahl der Bewerber auf das Thema" class="fas fa-question-circle"></i></th>
                        </tr>      
';

while ($statement->fetch()) {

    if ($verfahren == "Windhundverfharen") {
        if ($thema_verfuegbarkeit == "Vergeben") {
            $anzahl_bewerber = "1";
        } else {
            $anzahl_bewerber = "0";
            $bew_sum += $anzahl_bewerber;
        }
    } else if ($verfahren == "Bewerbungsverfahren") {
        $statement_bew = $dbh->prepare("SELECT count(bewerbung_id) as anzahl_bewerber
        FROM thema, bewerbung 
        WHERE bewerbung.thema_id = thema.thema_id AND thema.thema_id = ?");
        $statement_bew ->bind_param('i', $thema_id);
        $statement_bew ->execute();
        $statement_bew ->bind_result($anzahl_bewerberdb);
        $statement_bew ->store_result();
        while ($statement_bew ->fetch()) {
            $anzahl_bewerber = $anzahl_bewerberdb;
            $bew_sum += $anzahl_bewerber;
        }
    } else if ($verfahren == "Belegwunschverfahren") {   
        $statement_bew  = $dbh->prepare("SELECT count(belegwunsch_id) as anzahl_bewerber
        FROM belegwunsch 
        WHERE wunsch_1 = ? OR wunsch_2 = ? OR wunsch_3 = ?");
        $statement_bew ->bind_param('iii', $thema_id, $thema_id, $thema_id);
        $statement_bew ->execute();
        $statement_bew ->bind_result($anzahl_bewerberdb);
        $statement_bew ->store_result();
        while ($statement_bew ->fetch()) {
            $anzahl_bewerber = $anzahl_bewerberdb;
            $bew_sum += $anzahl_bewerber;
        }
    }

    $output_thema .= "    
    <tr>
    <td>{$thema_id}</td>
    <td>{$themenbezeichnung}</td>
    <td>{$thema_verfuegbarkeit}</td>  
    <td>{$anzahl_bewerber}</td>
    </tr> 
    ";
}

$output_thema .= " 
    <tr> 
    <td colspan='3' style='text-align: right;'></td>
    <td colspan='1'>{$bew_sum}</td>
    </tr> 
    </table>    
    </semester>";

echo $output_thema;
?>
