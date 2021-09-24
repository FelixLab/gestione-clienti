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



$interventi = "SELECT * FROM intervento i inner join cliente c on i.id_cliente=c.id_cliente where 1=1";
$id="";


if (isset($_GET['id'])) {
    $id=trim($_GET['id']);
    $interventi = $interventi . " AND id_intervento = '".$id."' order by data desc";
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



<script type="text/javascript">

function viewPhoto (e){
    //alert(e.value);
    //window.location = e.value;
    //window.open(e.value, '_blank');


    var w = 500;
    var h = 350;
    var l = Math.floor((screen.width-w)/2);
    var t = Math.floor((screen.height-h)/2);
    window.open(e.value,"","width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);

}


function viewIntervento (e){

    window.open(e.value,"_blank");

}

</script>

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


 <?php

//verifica se insert, update oppure solo view
if ( isset($_GET['action']) && !empty($_GET['action']) ){
    if($_GET['action']=="INSERT")
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Intervento inserito correttamente</div>";
    if($_GET['action']=="UPDATE")
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Intervento aggiornato correttamente</div>";
}


?>

  


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
class Intervento{
    public $id_intervento;
    public $id_cliente;
    public $Intervento;
    public $data;
    public $TipoIntervento;
    public $data_pagamento;
    public $ImportoTotale;
    public $ImportoPagato;
    public $denominazione;
    public $via;
    public $tel;
    public $comune;
    public $eseguito;
    public $priorita;
    public $map;
    public $time;
}

include 'config.php';

$clienti = array();

try {

    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $intervents = array();
        $result = $db->query($interventi);
        
         foreach ($result as $row) {
             $row = get_object_vars($row);
             $intervents[$row['id_intervento']] = new Intervento();
            
             $intervents[$row['id_intervento']]->id_cliente = $row['id_cliente'];  
             $intervents[$row['id_intervento']]->id_intervento = $row['id_intervento'];            
             $intervents[$row['id_intervento']]->Intervento= $row['Intervento'];
             $intervents[$row['id_intervento']]->data= $row['data'];
             $intervents[$row['id_intervento']]->TipoIntervento= $row['TipoIntervento'];
             $intervents[$row['id_intervento']]->data_pagamento= $row['data_pagamento'];
             $intervents[$row['id_intervento']]->ImportoPagato= $row['ImportoPagato'];
             $intervents[$row['id_intervento']]->ImportoTotale= $row['ImportoTotale'];
             $intervents[$row['id_intervento']]->denominazione= $row['denominazione'];
             $intervents[$row['id_intervento']]->via= $row['Via'];
             $intervents[$row['id_intervento']]->tel= $row['Tel'];
             $intervents[$row['id_intervento']]->comune= $row['comune'];
             $intervents[$row['id_intervento']]->eseguito= $row['eseguito'];
             $intervents[$row['id_intervento']]->priorita= $row['priorita'];
             $intervents[$row['id_intervento']]->map= $row['map'];
             $intervents[$row['id_intervento']]->time= $row['time'];
            
             //echo "<option value='/gestione-clienti/index.php?=". $intervents[$id]->id_intervento ." ' onClick='viewIntervento(this)' >". "<b>" .$intervents[$id]->Intervento . "</b> (" . $intervents[$id]->TipoIntervento. "-" . $intervents[$id]->data. ") " ."</option>";
         }
                
        // chiude il database
        $db = NULL;

} catch (PDOException $e) {
   throw new PDOException("Error  : " . $e->getMessage());
}

?>
<div class="" style="text-align: center;">
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">CLIENTE</h2>
        <hr>
</div>
<div class="row">
	    <div class="col-lg-6">      
		    <div class="form-group">
             <label>CLIENTE</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->denominazione ?>" placeholder="DENOMINAZIONE" name='denominazione' readonly>
             <br/>
             <label>VIA</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->via ?>" placeholder="VIA" name='via' readonly>             
            </div>
      </div>
      <div class="col-lg-6">      
		    <div class="form-group">
             <label>TELEFONO</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->tel ?>" placeholder="TELEFONO" name='tel' readonly>
             <br/>
             <label>COMUNE</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->comune ?>" placeholder="COMUNE" name='comune' readonly>        
            </div>
      </div>
</div> 



<div class="" style="text-align: center;">
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">INTERVENTO</h2>
        <hr>
</div>

<form name="Form" action="addIntervento.php" method="post">
    
	<div class="row">
	    <div class="col-lg-6">      
		    <div class="form-group">
             <label>ID INTERVENTO</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->id_intervento ?>" placeholder="ID_INTERVENTO" name='id_intervento' readonly>
             <br/>
             <label>DESCRIZIONE INTERVENTO</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->Intervento ?>" placeholder="INTERVENTO" name='Intervento'>
             <br />
             <label>TIPO INTERVENTO</label>
             <!--<input type="text" class="form-control" value="<?php echo $intervents[$id]->TipoIntervento ?>" placeholder="TIPO INTERVENTO" name='TipoIntervento'>-->
             <select name="TipoIntervento" id="TipoIntervento" class="form-control" >
                <option value="Prog" <?php   if($intervents[$id]->TipoIntervento=="Prog") echo "selected";  ?> >Prog</option>
                <option value="Extra" <?php   if($intervents[$id]->TipoIntervento=="Extra") echo "selected";  ?> >Extra</option>
             </select>
             <br />
             <label>DATA INTERVENTO</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->data ?>" placeholder="DATA" name='data'>
             <br />
             <label>PRIORITA'</label>
             <br />
             <select name="priorita" id="priorita" class="form-control" >
                <option value="0"  selected></option>
                <option value="1" <?php   if($intervents[$id]->priorita=="1") echo "selected";  ?> >ALTA</option>
                <option value="2" <?php   if($intervents[$id]->priorita=="2") echo "selected";  ?> >MEDIA</option>
                <option value="3" <?php   if($intervents[$id]->priorita=="3") echo "selected";  ?> >BASSA</option>
             </select>
             <br />
             <label>Ora</label>
             <input type="time" class="form-control" value="<?php echo $intervents[$id]->time ?>" placeholder="Ora" name='time'>
            </div>
            
      </div>
      <div class="col-lg-6">      
		    <div class="form-group">
             <label>IMPORTO TOTALE</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->ImportoTotale ?>" placeholder="IMPORTO TOTALE" name='ImportoTotale'>
             <br/>
             <label>IMPORTO PAGATO</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->ImportoPagato ?>" placeholder="IMPORTO PAGATO" name='ImportoPagato'>
             <br />
             <label>DATA PAGAMENTO</label>
             <input type="date" class="form-control" value="<?php echo $intervents[$id]->data_pagamento ?>" placeholder="DATA PAGAMENTO" name='data_pagamento'>
             <br />
             <label >ESEGUITO</label>
             <?php  if($intervents[$id]->eseguito==1) {?>
             <input type="checkbox" class="form-control" style="width:5%; margin:0px;" placeholder="ESEGUITO"  name='eseguito' checked>
             <?php  } else { ?>
             <input type="checkbox" class="form-control" style="width:5%; margin:0px;" placeholder="ESEGUITO"  name='eseguito' >
             <?php  }?>
             <br />
             <label>Google Map</label>
             <input type="text" class="form-control" value="<?php echo $intervents[$id]->map ?>" placeholder="Google Map" name='map'>
            </div>
      </div>
    </div>

    <hr>


	  <div class="row">
	    <div class="col-lg-2">
        <button type="submit" class="btn btn-success btn-lg">Salva Modifiche</button>
      </div>
</form> 

   

    
    

   
    

      



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
	<script src="dist/moment/moment-with-locales.js"></script>
	
	
  </body>
</html>
