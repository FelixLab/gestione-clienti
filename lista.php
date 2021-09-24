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

    <title>Appuntamenti</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link href="css/jumbotron-narrow.css" rel="stylesheet"> -->
    
   
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
</style>


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
                <a class="navbar-brand" href="#">Gestione Postazioni</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Inserisci</a>
                    </li>
					          <li>
                        <a href="lista.php">Disponibilita</a>
                    </li>
                    <?PHP  if($userRow['isAdmin'] == 1){  ?>
                    <li>
                        <a href="dafare.php">Postazioni</a>
                    </li>
                    <?PHP  }  ?>
                    <li>
                    <a href="calendario.php">Calendario</a>
                    </li>
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
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">DISPONIBILITA' INSERITA</h2>
      </div>
      
  <!-- <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li ><a href="index.php">Inserisci</a></li>
          <li><a href="#">Nuovo</a></li> -->
          <!-- <li class="active"><a href="lista.php">Disponibilita</a></li>
		      <li><a href="opzioni.php">Opzioni</a></li>
          <li><a href="dafare.php">Postazioni</a></li>
        </ul>
        <h3 class="text-muted corsivo">Gestione Postazioni</h3>
      </div>  -->

      <!-- <div class="jumbotron">
        <h1 class="corsivo">Lista appuntamenti</h1>
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


      <?php 

      // CARICA I DATI

      class Appuntamento {
        public $idapp;
        public $data;
        public $giornosettimana;
        public $fkorario;
        public $orario;
        public $nome;
        public $note;
        public $confermato;
        public $postazione;
      }

      include 'config.php';

      $appuntamenti = array();

      // segna tutti gli idorario occupati nel giorno
      try {

          $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $id_utenteLoggato = $userRow['id']; 

        if ($userRow['isAdmin'] == '1') {
            //vedi tutto
            $ID_POS = $userRow['id_postazione'];
            $sql = "SELECT app.idapp, app.data, app.fkorario, app.nome, app.note, orario.ora, app.confermato, postazione.name as nomePostazione
                  FROM app
                  INNER JOIN orario ON app.fkorario = orario.idorario
                  inner join postazione ON postazione.id=app.id_postazione
                  WHERE app.id_postazione ='$ID_POS'
                  ORDER BY app.data DESC, app.fkorario ASC
                  ";
        }else{
            //vedi solo i miei
            $sql = "SELECT app.idapp, app.data, app.fkorario, app.nome, app.note, orario.ora, app.confermato, postazione.name as nomePostazione
            FROM app
            INNER JOIN orario ON app.fkorario = orario.idorario
            inner join postazione ON postazione.id=app.id_postazione
            WHERE id_user = '$id_utenteLoggato' 
            ORDER BY app.data DESC, app.fkorario ASC
            "; 
        }
          

          $result = $db->query($sql);
          foreach ($result as $row) {
              $row = get_object_vars($row);
              $appuntamenti[$row['idapp']] = new Appuntamento();
              $appuntamenti[$row['idapp']]->idapp = $row['idapp'];
              $data = DateTime::createFromFormat('Y-m-d', $row['data']);
              $appuntamenti[$row['idapp']]->data = $data->format('d-m-Y');
              $formatterLungo = new IntlDateFormatter('it_IT', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
              $formatterLungo->setPattern('EEEE');
              $appuntamenti[$row['idapp']]->giornosettimana = $formatterLungo->format($data);
              $appuntamenti[$row['idapp']]->fkorario = $row['fkorario'];
              $appuntamenti[$row['idapp']]->orario = $row['ora'];
              $appuntamenti[$row['idapp']]->nome = $row['nome'];
              $appuntamenti[$row['idapp']]->note = $row['note'];
              $appuntamenti[$row['idapp']]->confermato = $row['confermato'];
              $appuntamenti[$row['idapp']]->postazione = $row['nomePostazione'];
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
      foreach($appuntamenti as $app) {
        $giornoattuale = $app->data;
        if($giornoattuale != $giornoprecedente) {

          if(date("d-m-Y")==$giornoattuale) { 
            echo "<!-- GIORNO --><div class='row'><div class='col-lg-12'><h2 class='bg-primary'>$app->giornosettimana $giornoattuale - OGGI</h2></div></div>"; 
          } else {
            echo "<!-- GIORNO --><div class='row'><div class='col-lg-12'><h2>$app->giornosettimana $giornoattuale</h2></div></div>"; 
          }
          
        }
		    if($giornoattuale != $giornoprecedente) {echo "<!-- TABELLA --><div class='row'><div class='col-lg-12'><table class='table table-bordered'><thead><tr><th>Ora</th><th>Nome</th><th>Postazione</th><th>STATO</th></tr></thead><tbody>"; }
        
        if($giornoattuale != $giornoprecedente) {
        foreach($appuntamenti as $app) {
          if($app->data == $giornoattuale) {
              echo "<tr>";
              //echo "<td>"; echo $app->idapp; echo "</td>";
              echo "<td>"; echo $app->orario; echo "</td>";
              echo "<td>"; echo $app->nome; echo "</td>";
              //echo "<td>"; echo $app->note; echo "</td>";
              echo "<td>"; echo $app->postazione; echo "</td>";

              if ($userRow['isAdmin'] == '1') {
                
                if ($app->confermato == 0){
                    echo "<td style='width: 40px;margin-right: 3px; margin-bottom: 3px'><a class='btn btn-xs btn-primary' href='confermadisponibilita.php?id=".$app->idapp."' role='button'>OK</a></td>";
                }else{
                    echo "<td ><a class='btn btn-xs btn-success' href='#' role='button'>Confermato</a><a class='btn btn-xs btn-danger' href='appuntamentocancella.php?id=".$app->idapp."' role='button'>Elimina</a></td>";
                   
                }
                echo "</tr>";
              }else{
                if ($app->confermato == 0){
                    echo "<td style='width: 30px;margin-right: 3px; margin-bottom: 3px'><a class='btn btn-xs btn-primary' href='lista.php' role='button'>Da confermare</a></td>";
                }else{
                    echo "<td style='width: 30px;margin-right: 3px; margin-bottom: 3px'><a class='btn btn-xs btn-success' href='lista.php' role='button'>Confermato</a></td>";
                }
                echo "</tr>";
              }
          }              
        }          
        }
        if($giornoattuale != $giornoprecedente) {echo "</tbody></table></div></div><!-- FINE TABELLA -->";}
        $giornoprecedente = $giornoattuale;
      }
        
      ?>
	  
      <br>
	  <div class="footer">
        <!-- <p>2017 &copy; Archistico by Emilie Rollandin</p> -->
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
	
  </body>
</html>
