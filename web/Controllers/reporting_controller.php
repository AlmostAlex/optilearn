<script> $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })</script>
<?php
require("db.php");
require("Models/modul_model.php");
require("Models/windhund_model.php");
require("Models/bewerbung_model.php");
require("Models/reporting_model.php");

class reporting_controller {

    public $modul;

    public function __construct() {
        $this->modul = new modul_model();
        $this->thema = new thema_model();
        $this->reporting = new reporting_model();
    }

    public function ReportBasis($semester, $modul_aktuell) {
        echo"<report>";
        echo "<div class='title'>Alle Informationen im Überblick</div>";

        $statement = $this->modul->getModulAnzahlBySemester($semester);
        $statement->bind_result($modul_anzahl);
        $statement->store_result();

        $verfuegbar = "Verfügbar";
        $statement_verfuegbar = $this->modul->getModulAnzahlVerfuegbarBySemester($semester, $verfuegbar);
        $statement_verfuegbar->bind_result($modul_verfuegbar_anzahl);
        $statement_verfuegbar->store_result();

        while ($statement->fetch()) {
            while ($statement_verfuegbar->fetch()) {
                echo"<div style='float:left; width: 45%; margin-left: 3%;' class='well'>";
                echo"<b>Semester <b>{$semester}</b> Informationen:</b>";
                echo"<table><tr><td style='width: 180px;'>Module Insgesamt:</td><td>{$modul_anzahl}</td></tr>";
                echo"<tr><td><i class='fas fa-angle-right'></i> Verfügbare Module:</td> <td>{$modul_verfuegbar_anzahl}</td></tr>";
                $vergeben = $modul_anzahl - $modul_verfuegbar_anzahl;
                echo"<tr><td><i class='fas fa-angle-right'></i> Vergebene Module:</td> <td>{$vergeben}</td></tr>";
                echo"</table></div>";
            }
        }
        echo"<div style='margin-left: 50%; margin-right: 3%;'class='well'>";
        echo"<b>Informationen:</b><br>";
        // echo"<i class='fas fa-arrows-alt-v'></i> Es kann nach aufsteigend/absteigend sortiert werden.<br>";
        echo"<i class='far fa-file'></i> Es können alle angezeigten Module exportiert werden. (.csv)<br><br>";
        echo"</div>";
        echo"<br><div class='title'>Alle Module aus dem Semester: {$semester}</div>";
        ?> 

        <div class="table-responsive" id="module">  
            <semester><table class="table table-bordered">                   
                    <tr>  
                        <th><span class="column_sort" id="modul_id" data-order="desc" return false>ID</span></th>  
                        <th><span class="column_sort" id="modulbezeichnung" data-order="desc" return false>Modulbezeichnung</span></th> 
                        <th><span class="column_sort" id="frist_start" data-order="desc" return false>Starttermin</span></th> 
                        <th><span class="column_sort" id="frist_ende" data-order="desc" return false>Endtermin</span></th>
                        <th><span class="column_sort" id="verfahren" data-order="desc" return false>Verfahren</span></th> 
                        <th><span class="column_sort" id="nachrueckverfahren" data-order="desc" return false>Nachrückverfahren</span></th>
                        <th><i  data-toggle="tooltip" data-placement="top" title="Verfügbaren/Vergebenen Themen" class="fas fa-question-circle"></i></th>
                    </tr> 

                    <?php
                    $statement_group = $this->modul->getModulGroupDatum($semester);
                    $statement_group->bind_result($anzahl_module, $datum_group);
                    $statement_group->store_result();
                    while ($statement_group->fetch()) {
                        //$date_upload[] = $datum_group;
                        //$module_anz[] = $anzahl_module;
                        echo $datum_group;
                        echo $anzahl_module;
                    }
                    
                    $anz = "0";
                    $anz_th = "0";
                    $verfuegbarkeit = "Verfügbar";

                    $statement = $this->modul->getModulBySemester($semester);
                    $statement->bind_result($modul_id, $modulbezeichnung, $verfahren, $frist_start, $frist_ende, $nachrueckverfahren, $timestamp);
                    $statement->store_result();
                    while ($statement->fetch()) {

                        $start_anzeige = date("d-m-Y", strtotime($frist_start));
                        $ende_anzeige = date("d-m-Y", strtotime($frist_ende));

                        $statement_thema = $this->thema->getModulThema($modul_id);
                        $statement_thema->bind_result($themenbezeichnung, $beschreibung, $thema_id, $thema_verfuegbarkeit);
                        $statement_thema->store_result();
                        while ($statement_thema->fetch()) {

                            $statement_themenanzahl = $this->thema->getModulThemaAnzahlById($modul_id);
                            $statement_themenanzahl->bind_result($anzahl);
                            $statement_themenanzahl->store_result();
                            while ($statement_themenanzahl->fetch()) {

                                $statement_themaVerfuegbar = $this->thema->getModulThemaAnzahlVerfuegbar($modul_id, $verfuegbarkeit);
                                $statement_themaVerfuegbar->bind_result($anzahl_thema_verfuegbar);
                                $statement_themaVerfuegbar->store_result();
                                while ($statement_themaVerfuegbar->fetch()) {
                                    
                                }
                            }
                        }
                        $modul_array[] = $modul_id;
                        $thema_insg[] = $anzahl;
                        $th_verfuegbar[] = $anzahl_thema_verfuegbar;
                        ?>
                        <tr>  
                            <td> <?php echo "{$modul_id}" ?></td>  
                            <td> <?php echo "{$modulbezeichnung}" ?></td> 
                            <td> <?php echo "{$start_anzeige}" ?></td> 
                            <td> <?php echo "{$ende_anzeige}" ?></td> 
                            <td> <?php echo "{$verfahren}" ?></td> 
                            <td> <?php echo "{$nachrueckverfahren}" ?></td>
                            <td><?php echo "{$anzahl}/{$anzahl_thema_verfuegbar}" ?></td>
                            <?php
                            $anz += $anzahl;
                            $anz_th += $anzahl_thema_verfuegbar;
                            
                            ?>

            <?php }
        ?>
                    </tr> 
                    <tr>
                        <td colspan='6'></td>
                        <td><?php echo "{$anz}/{$anz_th}" ?></td>
                    </tr> 
                    <?php
                    $data_upload_anz = json_encode($date_upload);
                    $data_module_anz = json_encode($module_anz);
                    
                    $modul_array = json_encode($modul_array);       
                    $anz_insgesamt_array = json_encode($thema_insg);
                    $anzahl_thema_verfuegbar_array =json_encode($th_verfuegbar);
                    
                    // $anz_verfuegbar =
                    ?> 
                </table>
            </semester>   
        </div>  

        <export> 
            <form action="excel_report_bySemester.php?action=export&semester=<?php echo $semester ?>" method="post">
                <button type="submit" name="export_excel" class="btn btn-primary"  value="Module exportieren"><i class="fas fa-align-justify"></i> Module exportieren</button>
            </form>
        </export>
        <graphik>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_report_semester"><i class="fas fa-chart-area"></i> Übersicht</button>
        </grapghik>
        </report> 

        <reportModal>
            <div class="modal hide fade in" id="modal_report_semester" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div style='min-width: 700px;' class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div style='border: 0px;' class="modal-body">
                            <h4>Anzahl der erstellten Module im Zeitfenster</h4>
                            <center><canvas id="myChart" width="500" height="200"></canvas></center><br>
                             <h4>Insgesamt und Vergebene Themen</h4>   
                            <center><canvas id="bar_anzahl_semester" width="500" height="200"></canvas></center>

                        </div>
                        <div style='border: 0px;' class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </reportModal>

        <script>
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo $data_upload_anz ?>,
                    datasets: [{
                            label: 'Module',
                            data: <?php echo $data_module_anz ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    responsive: false
                }
            });

            var ctx = document.getElementById("bar_anzahl_semester").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $modul_array ?>,
                    datasets: [
                        {
                            label: "Insgesamt",
                            backgroundColor: "#3e95cd",
                            data: <?php echo $anz_insgesamt_array ?>
                        }, {
                            label: "Verfügbar",
                            backgroundColor: "#8e5ea2",
                            data: <?php echo $anzahl_thema_verfuegbar_array ?>
                        }
                    ]
                },
                options: {
                    responsive: false
                }
            });
        </script>
        <?php
        echo"<br><br><report><div class='title'>Informationen zum Modul: {$modul_aktuell}</div></report>";
        ?>
        <report>
            <div class="table-responsive" id="thema">  
                <semester><table class="table table-bordered">  
                        <tr>  
                            <th><span class="column_sort_thema" id="thema_id" data-order_thema="desc" return false>ID</span></th>  
                            <th><span class="column_sort_thema" id="themenbezeichnung" data-order_thema="desc" return false>Themenbezeichnung</span></th> 
                            <th><span class="column_sort_thema" id="thema_verfuegbarkeit" data-order_thema="desc" return false>Verfügbarkeit</span></th> 
                            <th><i data-toggle="tooltip" data-placement="top" title="Anzahl der Bewerber auf das Thema" class="fas fa-question-circle"></i></th>
                        </tr> 
                        <?php
                        $statement = $this->thema->getThemenBez($modul_aktuell);
                        $statement->bind_result($thema_id, $themenbezeichnung, $thema_verfuegbarkeit);
                        $statement->store_result();
                        while ($statement->fetch()) {
                            echo"<tr>";
                            echo"<td>{$thema_id}</td>";
                            echo"<td>{$themenbezeichnung}</td>";
                            echo"<td>{$thema_verfuegbarkeit}</td>";
                            echo"<td>yo</td>";
                            echo"</tr>";
                        }
                        ?>

                    </table>    
                </semester>
            </div>
        </report>
        <br>
        <br><br>
        <br><br>

        <script>
            $(document).ready(function () {
                $(document).on('click', '.column_sort', function () {
                    var column_name = $(this).attr("id");
                    var order = $(this).data("order");
                    var semester = '<?php echo $semester ?>';
                    var arrow = '';
                    if (order == 'desc')
                    {
                        arrow = ' <i class="fas fa-angle-down"></i>';
                    } else
                    {
                        arrow = ' <i class="fas fa-angle-up"></i>';
                    }
                    $.ajax({
                        url: "sort_report_semester.php",
                        method: "POST",
                        data: {column_name: column_name, order: order, semester: semester},
                        success: function (data)
                        {
                            $('#module').html(data);
                            $('#' + column_name + '').append(arrow);
                        }
                    })
                });
            });
            $(document).ready(function () {
                $(document).on('click', '.column_sort_thema', function () {
                    var column_name_thema = $(this).attr("id");
                    var order_thema = $(this).data("order_thema");
                    var modulbezeichnung = '<?php echo $modul_aktuell ?>';
                    var arrow_thema = 'hihi';
                    if (order_thema == 'desc')
                    {
                        arrow_thema = ' <i class="fas fa-angle-down"></i>';
                    } else
                    {
                        arrow_thema = ' <i class="fas fa-angle-up"></i>';
                    }
                    $.ajax({
                        url: "sort_report_modul.php",
                        method: "POST",
                        data: {column_name_thema: column_name_thema, order_thema: order_thema, modulbezeichnung: modulbezeichnung},
                        success: function (data)
                        {
                            $('#thema').html(data);
                            $('#' + column_name_thema + '').append(arrow_thema);
                        }
                    })
                });
            });

        </script> 

        <?php
    }

}
?>

