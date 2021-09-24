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
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);


$sql = "SELECT * FROM cliente where 1=1";



$denominazione="";
$via="";
$comune="";
$telefono = "";
$marca = "";
$modello = "";

if (isset($_GET['denominazione'])) {
  $denominazione=$_GET['denominazione'];
  $sql = $sql . " AND denominazione like '%".str_replace("'","''",$_GET['denominazione'])."%' ";
}
if (isset($_GET['via'])) {
  $via=$_GET['via'];
  $sql = $sql . " AND (Via like '%".str_replace("'","''",$_GET['via'])."%') ";
}
if (isset($_GET['comune'])) {
  $comune=$_GET['comune'];
  $sql = $sql . " AND (Comune like '%".$_GET['comune']."%') ";
}
if (isset($_GET['telefono'])) {
  $telefono=$_GET['telefono'];
  $sql = $sql . " AND (Tel like '%".$_GET['telefono']."%') ";
}
if (isset($_GET['marca'])) {
  $marca=$_GET['marca'];
  $sql = $sql . " AND (MarcaCaldaia like '%".$_GET['marca']."%') ";
}
if (isset($_GET['modello'])) {
  $modello=$_GET['modello'];
  $sql = $sql . " AND (Modello like '%".$_GET['modello']."%') ";
}


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

    <title>Clienti</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link href="css/jumbotron-narrow.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.4.2.min.css" type="text/css"/>
   
    <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet"> 

	<!-- Air-datepicker -->
	<link href="dist/air-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- <link href="css/appuntamenti.css" rel="stylesheet"> -->


    <!-- FullCalendar -->
	<link href='calendar/css/fullcalendar.css' rel='stylesheet' />


<!-- Custom CSS -->
<style>
body {
    padding-top: 70px;
    /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
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
                <a class="navbar-brand" href="customerList.php">COMPANY</a>
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
                    aria-expanded="false" >
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
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">CLIENTI <a href='newCustomer.php' class='btn btn-success'>+ Nuovo Cliente</a></h2>
      </div>

  <!-- 
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li ><a href="index.php">Inserisci</a></li>
           <li><a href="#">Nuovo</a></li> -->
          <!-- <li><a href="lista.php">Disponibilita</a></li>
		      <li><a href="opzioni.php">Opzioni</a></li>
          <li class="active"><a href="dafare.php">Postazioni</a></li>
        </ul>
        <h3 class="text-muted corsivo">Gestione Postazioni</h3>
      </div> -->

      <!-- <div class="jumbotron">
        <h1 class="corsivo">Da fare</h1>
      </div> -->

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
		
		<form name="Form" action="customerList.php" method="get">
      
	  <div class="row">
	    <div class="col-lg-12">      
		    <div class="form-group">
             <!--<label>Denominazione cliente</label>-->
             <input type="text" class="form-control" value="<?php echo $denominazione ?>" placeholder="DENOMINAZIONE" name='denominazione' >
             <br/>
             <input type="text" class="form-control" value="<?php echo $via ?>" placeholder="VIA" name='via'>
             <br />
             <input type="text" class="form-control" value="<?php echo $comune ?>" placeholder="COMUNE" name='comune'>
             <br />
             <input type="text" class="form-control" value="<?php echo $telefono ?>" placeholder="TELEFONO" name='telefono'>
             <br />
             <input type="text" class="form-control" value="<?php echo $marca ?>" placeholder="MARCA" name='marca'>
             <br />
             <input type="text" class="form-control" value="<?php echo $modello ?>" placeholder="MODELLO" name='modello'>
        </div>
      </div>
    </div>
	  <div class="row">
	    <div class="col-lg-12">
        <button type="submit" class="btn btn-block btn-primary btn-lg">FILTRA</button>
      </div>
    </div>
	  	  
	  </form>
    <br>


          <?php 

      // CARICA I DATI

      class cliente {
        public $id_cliente;
        public $denominazione;
        public $via;
        public $comune;
        public $data;
      }

      include 'config.php';

      $clienti = array();

      try {
            
        //echo $dbhost;
        
          $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

          // $sql = "SELECT *
          //         FROM compiti
          //         ORDER BY compiti.data DESC
          //         ";

          



          $result = $db->query($sql);
          foreach ($result as $row) {
              $row = get_object_vars($row);
              $clienti[$row['id_cliente']] = new Cliente();
              $clienti[$row['id_cliente']]->id_cliente = $row['id_cliente'];
              //$data = DateTime::createFromFormat('Y-m-d', $row['DataInst']);
              //$cliente[$row['DataInst']]->data = $data->format('d-m-Y');
              $clienti[$row['id_cliente']]->denominazione = $row['denominazione'];
              $clienti[$row['id_cliente']]->comune = $row['comune'];
              $clienti[$row['id_cliente']]->via = $row['Via'];
          }
          // chiude il database
          $db = NULL;

      } catch (PDOException $e) {
         throw new PDOException("Error  : " . $e->getMessage());
      }
      
      //echo "<pre>"; var_dump($compiti); echo "</pre>"; die();
        
		    echo "<!-- TABELLA --><div class='row'><div class='col-lg-12'><h2>Lista Clienti </h2><table class='table table-striped'><thead style='background-color:#428bca;color:white;'><tr><th>ID</th><th>Denominazione</th><th>Azione</th></tr></thead><tbody>"; 
        
        foreach($clienti as $cli) {
          
              echo "<tr>";
              echo "<td style='width:5%;'>"; echo $cli->id_cliente; echo "</td>";
              echo "<td><b>"; echo $cli->denominazione; echo"</b> ("; echo  "Via ".str_replace("�","a",$cli->via); echo  " - ".$cli->comune; echo") "; echo "</td>";
              echo "<td style='width: 25%;margin-right: 3px; margin-bottom: 3px'><a class='btn btn-xs btn-info' href='viewCustomer.php?id=".$cli->id_cliente."' role='button' title='Visualizza'><i class='fa fa-eye'></i></a> &nbsp; <a class='btn btn-xs btn-warning' href='index.php?id=".$cli->id_cliente."' role='button' title='Pianifica intervento'>+<i class='fa fa-wrench'></i></a></td>";
              echo "</tr>";
                        
        }          
        
        echo "</tbody></table></div></div><!-- FINE TABELLA -->";
        
      
        
      ?>





	  <div class="footer">
        
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- jQuery (necessario per i plugin Javascript di Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Includi tutti i plugin compilati (sotto), o includi solo i file individuali necessari -->
    <script src="dist/bootstrap/js/bootstrap.min.js"></script>
	<script src="dist/air-datepicker/js/datepicker.min.js"></script>
	<!-- Include Italian language -->
    <script src="dist/air-datepicker/js/i18n/datepicker.it.js"></script>
	<script src="dist/moment/moment-with-locales.js"></script>
	
	
  </body>
</html>
