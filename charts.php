<?php
ob_start();
session_start();
require_once 'dbconnect.php';

$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

?>

<?php
include_once 'dbconnect.php';
?>


<?php 

// CARICA I DATI

class Grafico {
  public $totale;
  public $pagato;
}

include 'config.php';



// segna tutti gli idorario occupati nel giorno
try {

    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');


    //echo "ciao";

    $id_utenteLoggato = $userRow['id']; 
     
    $sql = "SELECT sum(ImportoTotale) as totale, sum(ImportoPagato) as pagato FROM intervento; ";
    $sql_active="SELECT count(*) as ATTIVI FROM cliente WHERE Giorni>0 and ATTIVA='TRUE'";
    $sql_client="SELECT count(*) as CLIENTI FROM cliente";
    $sql_sospesi="SELECT count(*) as SOSPESI FROM cliente WHERE Giorni>0 and Sospeso='TRUE'";

    $result = $db->query($sql);
    $result_active = $db->query($sql_active);
    $result_clienti = $db->query($sql_client);
    $result_sospesi = $db->query($sql_sospesi);
    
    $contratti_attivi;
    $contratti_sospesi;
    $totale_clienti;
    
    
    $grafic = array();
    $grafic[0] = new Grafico();

    foreach ($result as $row) {
        $row = get_object_vars($row);   
        $grafic[0]->importo = $row['totale'];
        $grafic[0]->pagato = $row['pagato'];
    }
    
    foreach ($result_active as $row2) {
        $row2 = get_object_vars($row2);   
        $contratti_attivi=$row2['ATTIVI'];
    }
    
    foreach ($result_clienti as $row3) {
        $row3 = get_object_vars($row3);   
        $totale_clienti=$row3['CLIENTI'];
    }
    
    foreach ($result_sospesi as $row4) {
        $row4 = get_object_vars($row4);   
        $contratti_sospesi=$row4['SOSPESI'];
    }
    
    // chiude il database
    $db = NULL;

} catch (PDOException $e) {
   throw new PDOException("Error  : " . $e->getMessage());
}

//echo "ciao" . $grafic[0]->importo;
//    echo "ciao" . $grafic[0]->pagato; 
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistiche</title>
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        //GRAFICO A BARRE
        google.charts.load('current', { 'packages': ['corechart'] });
        //google.charts.setOnLoadCallback(drawChart);

        //STATICA
        /*function drawChart() {

            <%=getCharts1() %>

            var options = {
                //width: 1000,
                //height: 600,
                //vAxis: { format: 'decimal' },
                //vAxis: { title: 'Telai' },
                //hAxis: { title: 'Sorgenti' },
                //isStacked: false,
                title: 'AZIONI',
                colors: ['#4285F4', '#DB4437']
                //chartArea: { width: '50%', height: '100%' }
            };


            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            //var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

            chart.draw(data, options);

        }*/

        //GRAFICO A TORTA
        google.charts.setOnLoadCallback(drawChart2);
        function drawChart2() {

            //var data_pie = google.visualization.arrayToDataTable([['Importo Totale Interventi', 'Importo Pagato'],['Importo Totale Interventi', 100], ['Importo Pagato', 10]]);
            <?php
            echo "var data_pie = google.visualization.arrayToDataTable([";
            echo "['Totale Riscosso', 'Totale Da Riscuotere'],";
            echo "['Totale Riscosso', " . $grafic[0]->importo . "], ['Totale Da Riscuotere', " . ($grafic[0]->importo - $grafic[0]->pagato) .  "]]);";
            ?>    

            var options2 = {
                title: 'Differenza tra totale pagato e da riscuotere'
            };
    
            var chart2 = new google.visualization.PieChart(document.getElementById('piechart'));
            chart2.draw(data_pie, options2);

        }


       
    </script>
    
    <link rel="icon" href="favicon.jpg">
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">COMPANY</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <li>
                    <a href="customerList.php">Clienti</a>
                    </li>
                    <li>
                        <a href="listaInterventi.php">Interventi</a>
                    </li>
                    <li>
                        <a href="manutenzioni.php">Manutenzioni</a>
                    </li>
                    <li>
                        <a href="giornaliero.php">Giornaliero</a>
                    </li>
                    <li>
                        <a href="charts.php">Statistiche</a>
                    </li>
                    <!--
                    <li>
                        <a href="index.php">Inserisci Intervento</a>
                    </li>
                    -->
                    <?PHP  if($userRow['isAdmin'] == 1){  ?>
                    <!--<li>
                        <a href="dafare.php">Postazioni</a>
                    </li>-->
                    <?PHP  }  ?>
                    <!--<li>
                    <a href="calendario.php">Calendario</a>
                    </li>-->
                    <?PHP  if($userRow['isAdmin'] == 1){  ?>
                    <li>
                    <a href="register.php">Gestione</a>
                    </li>
                    <?PHP  }  ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span
                            class="glyphicon glyphicon-user"></span>&nbsp;Logged
                        in: <?php echo $userRow['email']; ?>
                        &nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>


            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<br/>
<br/>
<br/>



<div class="container">

<div class="panel panel-default" id="panelID">
        <div class="panel-body text-center">
            <div id="chart_div" class="charts"></div>
            
            <div id="piechart" style="width: 100%; height: 100%;"></div>
        </div>
      </div>



<button type="button" class="btn btn-primary btn-info" style='margin:2px;'>
  Totale clienti registrati <span class="badge badge-light"><?php echo $totale_clienti; ?></span>
</button>

<button type="button" class="btn btn-primary" style='margin:2px;'>
  Contratti Manutenzione Attivi <span class="badge badge-light"><?php echo $contratti_attivi; ?></span>
</button>

<button type="button" class="btn btn-primary btn-warning" style='margin:2px;'>
  Contratti Manutenzione In Sospeso <span class="badge badge-light"><?php echo $contratti_sospesi; ?></span>
</button>

      
     
     
     
       <div class="footer">
        <!-- <p>2017 &copy; Archistico by Emilie Rollandin</p> -->
    </div>

</div>








<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/tos.js"></script>

</body>
</html>
