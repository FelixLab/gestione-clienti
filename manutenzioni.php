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

    <title>Manutenzioni</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">
    
    <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet"> 

	<!-- Air-datepicker -->
	<link href="dist/air-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.4.2.min.css" type="text/css"/>
    
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

.nav-pills {
    display: flex;
    justify-content: center;
}

</style>

<link rel="icon" href="favicon.jpg">

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
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">Scadenze Manutenzioni Programmate
        <br/>
      
      <br/>
        
        <ul class="nav nav-pills ">
          <li class="active" >
            <a href="#" style='background-color:#2BBBAD;'>Tutti</a>
          </li>
          <li><a href='/gestione-clienti/sospesi.php' style='color:#2BBBAD;'>Sospesi</a></li>
        </ul>
        
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
        public $dataIntervento;
        public $attivo;
        public $sospeso;
        public $campoLibero;
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
                  $sql = "SELECT c.id_cliente, c.denominazione, i.id_intervento, c.Via, c.provincia, c.Tel,STR_TO_DATE(i.data,'%d/%m/%Y') as dataIntervento, DATE_ADD(STR_TO_DATE(i.data,'%d/%m/%Y'), INTERVAL c.Giorni DAY) as data, i.TipoIntervento , c.comune , i.Intervento, c.Giorni, c.Sospeso,c.CampoLibero
                  FROM cliente c inner join intervento i on c.id_cliente=i.id_cliente
                  WHERE                 
                  STR_TO_DATE(data,'%d/%m/%Y') in (select max(STR_TO_DATE(data,'%d/%m/%Y')) from intervento where id_cliente=c.id_cliente and TipoIntervento='Prog')
                  and TipoIntervento='Prog'
                  and c.Giorni>0
                  HAVING 
                  data <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                 
                  ORDER BY data DESC";
        }else{
            $sql = "SELECT c.id_cliente, c.denominazione, i.id_intervento, c.Via, c.provincia, c.Tel,STR_TO_DATE(i.data,'%d/%m/%Y') as dataIntervento, DATE_ADD(STR_TO_DATE(i.data,'%d/%m/%Y'), INTERVAL c.Giorni DAY) as data, i.TipoIntervento , c.comune , i.Intervento, c.Giorni, c.Sospeso, c.CampoLibero
                  FROM cliente c inner join intervento i on c.id_cliente=i.id_cliente
                  WHERE                 
                  STR_TO_DATE(data,'%d/%m/%Y') in (select max(STR_TO_DATE(data,'%d/%m/%Y')) from intervento where id_cliente=c.id_cliente and TipoIntervento='Prog')
                  and TipoIntervento='Prog'
                  and c.Giorni>0
                  HAVING 
                  data <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                  
                  ORDER BY data DESC";
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
              
              $data = DateTime::createFromFormat('Y-m-d', $row['dataIntervento']);
              $interventi[$row['id_intervento']]->dataIntervento = $row['dataIntervento'];

              $interventi[$row['id_intervento']]->denominazione = $row['denominazione'];
              $interventi[$row['id_intervento']]->via = $row['Via'];
              $interventi[$row['id_intervento']]->provincia = $row['provincia'];
              $interventi[$row['id_intervento']]->telefono = $row['Tel'];
              $interventi[$row['id_intervento']]->tipo_intervento = $row['TipoIntervento'];
              $interventi[$row['id_intervento']]->comune = $row['comune'];
              $interventi[$row['id_intervento']]->intervento = $row['Intervento'];
              $interventi[$row['id_intervento']]->id_cliente = $row['id_cliente'];
              $interventi[$row['id_intervento']]->sospeso = $row['Sospeso'];
              $interventi[$row['id_intervento']]->campoLibero = $row['CampoLibero'];
          }
          // chiude il database
          $db = NULL;

      } catch (PDOException $e) {
         throw new PDOException("Error  : " . $e->getMessage());
      }
      
      //echo "<pre>"; var_dump($appuntamenti); echo "</pre>"; die();

      ?>

      <?php

      $giornoattuale = '';
      $giornoprecedente = '';
      foreach($interventi as $app) {
        $giornoattuale = $app->data;
        if($giornoattuale != $giornoprecedente) {

          if(date("Y-m-d")==$giornoattuale) { 
            echo "<!-- GIORNO --><div class='row'><div class='col-lg-12'><h2 class='bg-primary' style='text-align:center;text-transform: Capitalize;font-size:x-large;background-color:#2BBBAD;'>$app->giornosettimana $giornoattuale - OGGI</h2></div></div>"; 
          } else {
            echo "<!-- GIORNO --><div class='row'><div class='col-lg-12'><h2>$app->giornosettimana $giornoattuale</h2></div></div>"; 
          }
          
        }
		    if($giornoattuale != $giornoprecedente) {echo "<!-- TABELLA --><div class='table-responsive text-nowrap'><table class='table table-sm'><thead style='font-size:xx-small;background-color:#2BBBAD;color:white;'><tr><th>Denominazione</th><th>Indirizzo</th><th>Descrizione</th><th>Ultima Manutenzione</th><th>AZIONE</th></tr></thead><tbody>"; }
        
        if($giornoattuale != $giornoprecedente) {
        foreach($interventi as $app) {
          if($app->data == $giornoattuale) {
              echo "<tr>";
              //echo "<td>"; echo $app->idapp; echo "</td>";
              echo "<td>"; echo "<a href='/gestione-clienti/viewCustomer.php?id=".$app->id_cliente."'>".$app->denominazione."</a>"; 
              echo "</td>";
              
              echo "<td>"; echo "Via "; echo $app->via; echo " <br/> "; echo $app->comune; echo " ("; echo $app->provincia; echo ") <br/> "; echo "<i class='fa fa-phone'></i>&nbsp;".str_replace("/","<br/>",$app->telefono);  
              echo "</td>";
              
              echo "<td>"; echo $app->intervento; 
              
              if($app->campoLibero!=""){echo "<br/><br/>Note:<br/>".$app->campoLibero;}
              if($app->sospeso=="TRUE"){echo "<br/>";
                  echo 
                  "<a class='btn btn-xs btn-danger'role='button'>IN SOSPESO</a>"; 
                  
              }
              echo "</td>";
              
              //echo "<td>"; echo $app->tipo_intervento; echo "</td>";
              echo "<td>"; echo $app->dataIntervento; echo "</td>";
              
              echo "<td>"; 
              echo "<a class='btn btn-xs btn-warning' href='index.php?id=".$app->id_cliente."' role='button'>+<i class='fa fa-wrench'></i></a>"; 
              echo "</td>";

              echo "</tr>";
              echo "</tr>";
              
              
          }              
        }          
        }
        if($giornoattuale != $giornoprecedente) {echo "</tbody></table></div><!-- FINE TABELLA -->";}
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
	
  </body>
</html>
