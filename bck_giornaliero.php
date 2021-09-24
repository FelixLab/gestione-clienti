<?php
ob_start();
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
// select logged in users detail
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']);
//$res = $conn->query("SELECT * FROM cliente c inner join intervento i on c.id_cliente=i.id_cliente");
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <title>Giornaliero</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>-->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>

    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.4.2.min.css" type="text/css"/>


    
   
    <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet"> 

	<!-- Air-datepicker -->
	<link href="dist/air-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">

 <!-- FullCalendar -->
 <link href='calendar/css/fullcalendar.css' rel='stylesheet' />


<!-- Custom CSS -->
<style>
body {
    padding-top: 70px;
   
}
#calendar {
max-width: 800px;
}
.col-centered{
float: none;
margin: 0 auto;
}
table {
  border-collapse: collapse;
  border-radius: 4px;
  overflow: hidden;
}
</style>

<link rel="icon" href="favicon.jpg">



<script type="text/javascript">

function execute(e){
  if( !confirm("Sei sicuro di confermare l'esecuzione?") ) {
        e.preventDefault();
  }
}

</script>

  </head>

  <body>


<!-- Navigation -->
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
                <a class="navbar-brand" href="#">COMPANY</a>
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


  <div class="" style="text-align: center;">
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">Pianificazione Giornaliera <a href='index.php' class='btn btn-success'>+ Nuovo Intervento</a></h2>
      </div>
      
       
      <?php
            //session_start();
            if(isset($_SESSION['sqlerrori'])) {
                echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Ci sono degli errori</div>";
                echo "<div class='alert alert-danger alert-dismissible'>".$_SESSION['sqlerrori']."</div>";
                unset($_SESSION['sqlerrori']);
            }

            if(isset($_SESSION['sqlok'])) {
                echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Operazione riuscita</div>";
                unset($_SESSION['sqlok']);
            }

      ?>


      <?php 

      // CARICA I DATI

      class Intervento {
        public $id_cliente;
        public $id_intervento;
        public $data;
        public $intervento;
        public $tipo_intervento;
        public $giornosettimana;
        public $denominazione;
        public $via;
        public $provincia;
        public $telefono;
        public $comune;
        public $eseguito;
        public $priorita;
        public $map;
        public $time;
      }

      include 'config.php';

      $interventi = array();

      // segna tutti gli idorario occupati nel giorno
      try {

          $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $id_utenteLoggato = $userRow['id']; 

        if ($userRow['isAdmin'] == '1') {
                  $sql = "SELECT c.id_cliente, c.denominazione, i.id_intervento, c.Via, c.provincia, c.Tel, STR_TO_DATE(i.data,'%d/%m/%Y') as data, i.TipoIntervento , c.comune, i.eseguito , case when ISNULL(i.priorita) then 99 when i.priorita=0 then 99 else i.priorita end as priorita , i.map, i.time,i.Intervento FROM cliente c inner join intervento i on c.id_cliente=i.id_cliente
                  where i.data is not null
                  and STR_TO_DATE(i.data,'%d/%m/%Y') = CURDATE() and (eseguito=0 OR eseguito is NULL)
                  ORDER BY priorita,time ASC";
        }else{
            $sql = "SELECT c.id_cliente, c.denominazione, i.id_intervento, c.Via, c.provincia, c.Tel, STR_TO_DATE(i.data,'%d/%m/%Y') as data, i.TipoIntervento , c.comune, i.eseguito ,case when ISNULL(i.priorita) then 99 when i.priorita=0 then 99 else i.priorita end as priorita , i.map, i.time,i.Intervento FROM cliente c inner join intervento i on c.id_cliente=i.id_cliente
            where i.data is not null
            and STR_TO_DATE(i.data,'%d/%m/%Y') = CURDATE() and (eseguito=0 OR eseguito is NULL)
            ORDER BY priorita,time ASC";
        }
          

          $result = $db->query($sql);
          foreach ($result as $row) {
              $row = get_object_vars($row);
              $interventi[$row['id_intervento']] = new Intervento();
              $interventi[$row['id_intervento']]->id_intervento = $row['id_intervento'];
              $data = DateTime::createFromFormat('Y-m-d', $row['data']);
              
              $interventi[$row['id_intervento']]->data = $row['data'];
              $formatterLungo = new IntlDateFormatter('it_IT', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
              $formatterLungo->setPattern('EEEE');
              $interventi[$row['id_intervento']]->giornosettimana = $formatterLungo->format($data);
             
              $interventi[$row['id_intervento']]->denominazione = $row['denominazione'];
              
              $interventi[$row['id_intervento']]->via = $row['Via'];
              $interventi[$row['id_intervento']]->provincia = $row['provincia'];
              $interventi[$row['id_intervento']]->telefono = $row['Tel'];
              $interventi[$row['id_intervento']]->tipo_intervento = $row['TipoIntervento'];
              $interventi[$row['id_intervento']]->comune = $row['comune'];
              $interventi[$row['id_intervento']]->eseguito = $row['eseguito'];
              $interventi[$row['id_intervento']]->priorita = $row['priorita'];

              $interventi[$row['id_intervento']]->id_cliente = $row['id_cliente'];
              $interventi[$row['id_intervento']]->map = $row['map'];
              $interventi[$row['id_intervento']]->time = $row['time'];
              $interventi[$row['id_intervento']]->intervento = $row['Intervento'];
          }
          // chiude il database
          $db = NULL;

      } catch (PDOException $e) {
         throw new PDOException("Error  : " . $e->getMessage());
      }
      
      //echo "<pre>"; var_dump($appuntamenti); echo "</pre>"; die();

      ?>

      <?php

      if(count($interventi)==0){
        echo "<!-- GIORNO --><div class='row'><div class='col-lg-12'><h2 class='bg-primary' style='text-align:center;text-transform: Capitalize;background-color:#3F729B;' >Oggi -  Nessuna Pianificazione</h2></div></div>";
      }


      $giornoattuale = '';
      $giornoprecedente = '';
      foreach($interventi as $app) {
        $giornoattuale = $app->data;
        if($giornoattuale != $giornoprecedente) {
          //echo $giornoattuale;
          //echo date("d-m-Y"); 
          if(date("Y-m-d")==$giornoattuale) { 
            echo "<!-- GIORNO --><div class='row'><div class='col-lg-12'><h2 class='bg-primary' style='text-align:center;text-transform: Capitalize;font-size:x-large;background-color:#3F729B;' >Oggi -  $app->giornosettimana $giornoattuale</h2></div></div>"; 
          } else {
            echo "<!-- GIORNO --><div class='row'><div class='col-lg-12'><h2>$app->giornosettimana $giornoattuale</h2></div></div>"; 
          }
          
        }
		    if($giornoattuale != $giornoprecedente) {echo "<!-- TABELLA --><div class='row'><div class='col-lg-12'><table class='table table-striped'><thead style='font-size:xx-small;background-color:#3F729B;color:white;'><tr><th>Cliente</th><th>Descrizione</th><th>Priorità</th><th>Eseguito</th></tr></thead><tbody>"; }
        
        if($giornoattuale != $giornoprecedente) {
        foreach($interventi as $app) {
          
          if($app->data == $giornoattuale) {
              echo "<tr>";
             
              echo "<td>"; echo "<a href='/gestione-clienti/viewCustomer.php?id=".$app->id_cliente."'>".$app->denominazione."</a>"; 
              echo "<br/>";
              echo "Via "; echo $app->via; echo "<br/>"; echo $app->comune; echo " ("; echo $app->provincia . ")";
              if(!empty($app->map)){
                echo "<br/><a class='btn btn-xs btn-success' href='". $app->map ."' target='_blank' style='background-color:#2BBBAD; border-color:#2BBBAD;'>&nbsp;<i class='fa fa-map-marker'>&nbsp;</i></a><br/>";
              }
              echo "<br/>"; echo "<a href='tel:".$app->telefono."'class='btn btn-xs btn-info' role='button'><i class='fa fa-phone'></i>&nbsp;".str_replace("/","<br/>",$app->telefono)."</a>";
              echo "</td>";
              
              echo "<td>";  
              if($app->intervento!=""){ echo $app->intervento ; echo "<br/>";}
              
              echo "<a class='btn btn-xs btn-warning' role='button' style='background-color:#757575;border:0;'><i class='fa fa-wrench' padding-bottom:2px;></i>&nbsp;".$app->tipo_intervento."</a>";
              echo "&nbsp;";
              echo "<a class='btn btn-xs btn-info' href='viewIntervento.php?id=".$app->id_intervento."' role='button'><i class='fa fa-edit'></i></a>"; 
              echo "</td>";
              //echo "<td>"; echo $app->tipo_intervento; echo "</td>";
              

            
              switch($app->priorita){
                case "1": $priority = "<a class='btn btn-xs btn-danger'>ALTA</a>";
                if($app->time!=""){ $priority=$priority. "<br/><br/> " . "<a class='btn btn-xs btn-danger' role='button'><i class='fa fa-history'></i>&nbsp;".$app->time."</a>";}
                break;
                case "2": $priority = "<a class='btn btn btn-xs btn-warning'>MEDIA</a>";
                if($app->time!=""){ $priority=$priority. "<br/><br/> " . "<a class='btn btn-xs btn-warning' role='button'><i class='fa fa-history'></i>&nbsp;".$app->time."</a>";}
                break;
                case "3": $priority = "<a class='btn btn btn-xs btn-primary'>BASSA</a>" ;
                if($app->time!=""){ $priority=$priority. "<br/><br/> " . "<a class='btn btn-xs btn-primary' role='button'><i class='fa fa-history'></i>&nbsp;".$app->time."</a>";}
                break;
                default:  $priority = "<a class='btn btn btn-xs btn-success'><i class='fa fa-question'></i></a>" ;
                if($app->time!=""){ $priority=$priority. "<br/><br/> " . "<a class='btn btn-xs btn-success' role='button'><i class='fa fa-history'></i>&nbsp;".$app->time."</a>";}
                
                break;
              }



              if($app->eseguito==1){
                $executed = "<a class='btn btn-xs btn-success' href='eseguito.php?id_intervento=".$app->id_intervento."&execute=0'><i class='fa fa-thumbs-up'></i></a>";
              }else{
                $executed = "<a class='btn btn-xs btn-danger' href='eseguito.php?id_intervento=".$app->id_intervento."&execute=1' onclick='execute(event);'><i class='fa fa-thumbs-down'></i></a>";
              }

              
              echo "<td>"; 
                echo $priority;
              echo "</td>";
              
              echo "<td>"; 
                echo  $executed;  
              echo "</td>";
         
                
                echo "</tr>";
                echo "</tr>";
              
              
          }              
        }          
        }
        if($giornoattuale != $giornoprecedente) {echo "</tbody></table></div></div><!-- FINE TABELLA -->";}
        $giornoprecedente = $giornoattuale;
      }
        
      ?>
	  
      <br>
	  <div class="footer">
        
      </div>

    </div> <!-- /container -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   
    <script src="dist/bootstrap/js/bootstrap.min.js"></script>
	<script src="dist/air-datepicker/js/datepicker.min.js"></script>
	
    <script src="dist/air-datepicker/js/i18n/datepicker.it.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	
  </body>
</html>
