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


if (isset($_GET['id']) && !empty($_GET['id'])){
  //echo 'filtro';
  //echo "SELECT id_cliente, denominazione FROM Cliente WHERE id_cliente=" . $_GET['id']; 
  $res2 = $conn->query("SELECT * FROM cliente WHERE id_cliente=" . $_GET['id']);
  $clienteRow = mysqli_fetch_array($res2);
  $sql = "SELECT * FROM cliente where id_cliente=" . trim($clienteRow['id_cliente']);
  //echo $clienteRow['denominazione'];
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

    <title>Intervento</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">

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


/* lista di ricerca cliente */
.dropbtn {
  background-color: white; /*#4CAF50;*/
  color: white;
  padding: 16px;
  font-size: 16px;
  /*border: none;*/
  cursor: pointer !important;
}

.dropbtn:hover, .dropbtn:focus {
  /*background-color: #3e8e41;*/
}

#myInput {
  box-sizing: border-box;
  /*background-image: url('searchicon.png');*/
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
  min-width:430px;
}

#myInput:focus {outline: 3px solid #ddd;}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 430px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}


</style>

<link rel="icon" href="favicon.jpg">



</head>

  <body>

    <!-- <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="index.php">Inserisci</a></li>
          <li><a href="#">Nuovo</a></li> -->
          <!-- <li><a href="lista.php">Disponibilita</a></li>
		      <li><a href="opzioni.php">Opzioni</a></li>
          <li><a href="dafare.php">Postazioni</a></li>
        </ul>
        <h3 class="text-muted corsivo">Gestione Postazioni</h3>
      </div> --> 

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


      <!--<div class="jumbotron">
        <h1 class="corsivo">Nuovo appuntamento</h1>
      </div>-->
      <br/>
      <br/>
      
      <div class="container">

      <div class="" style="text-align: center; font-weight: BOLD;">
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;" >INSERISCI INTERVENTO</h2>
      </div>
      <br/>




  <?php
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

      $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

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

  ?>

		<form name="Form" action="addIntervento.php" method="POST">
		     
	  <div class="row">
	  
		<div class="col-lg-3">
          <div class="datepicker-here" data-language='it' id="dataappuntamento"></div>
        </div>
	  
        <div class="col-lg-9">
		<div class="form-group">
             <!-- <label>Data selezionata</label> -->
             <input type="text" class="form-control  input-lg" placeholder="Data" name='dataselezionatatesto' id="dataselezionatatesto"  readonly  required>
    </div>
          
        <div class="form-group">
          <div class="dropdown">
            <input type="text" class="form-control " id="txtCliente" onclick="myFunction()" placeholder="Ricerca Cliente.." class="dropbtn"  value="" style="cursor:pointer !important;background-color:wheat;" readonly  required>
            <!-- <button onclick="myFunction()" class="dropbtn">Cliente</button> -->
            <div id="myDropdown" class="dropdown-content">
              <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
              <?php
                foreach($clienti as $cli) {
                  echo "<a href='#' id='".$cli->id_cliente."' value='" .str_replace("'"," ",$cli->denominazione)."|".$cli->id_cliente."|".$cli->via."|".$cli->comune."' onclick='fillValue(this)'>"; echo $cli->denominazione." Via ".$cli->via." ".$cli->comune."</a>";
                }    
              ?>
            </div>
          </div>
          <input type="text" class="form-control " style="width:10% !important;display:unset;" placeholder="ID" name='id_cliente' id="txtIdCliente"  readonly required>
          <input type="text" class="form-control " style="width:30% !important;display:unset;"  placeholder="VIA" name='via' id="txtViaCliente" readonly="true" required>
          <input type="text" class="form-control " style="width:30% !important;display:unset;"  placeholder="COMUNE" name='comune' id="txtComuneCliente" required readonly>
        </div>

          <div class="form-group">
             <!-- <label>Descrizione</label> -->
             <textarea class="form-control" placeholder="Descrizione..." name='Intervento'></textarea>
          </div>

          <div class="form-group">
            <!-- <label>Tipo Intervento</label> -->
            <select name="TipoIntervento" id="TipoIntervento" class="form-control" placeholder="Tipo Intervento" required>
              <option value="">Tipo Intervento...</option>
              <option value="Prog">Manutenzione Programmata Annuale/Prima Installazione</option>
              <option value="Extra">Intervento Extra Manutenzione/Generico</option>
            </select>
          </div>

          <div class="form-group">
             <!-- <label>Importo Totale</label> -->
             <input type="text" class="form-control" placeholder="Importo Totale" name='ImportoTotale' id="ImportoTotale" >
          </div>

          <div class="form-group">
             <!-- <label>Importo Pagato</label> -->
             <input type="text" class="form-control " placeholder="Importo Pagato" name='ImportoPagato' id="ImportoPagato" >
          </div>
        
          <div class="form-group">
             <label>Data Pagamento</label>
             <input type="date" class="form-control " placeholder="Data Pagamento" name='DataPagamento' id="DataPagamento" >
          </div>
          
          <div class="form-group">
             <label>Link Google Map</label>
             <input type="text" class="form-control " placeholder="Google Map" name='map' id="map" >
          </div>

          
          


        </div>
      </div>
	
	 
	 <hr>
	  <div class="row">
		        <div class="col-lg-12">
          <button type="submit" id="btn_invia" class="btn btn-block btn-primary btn-lg" onclick="checkField(event);">INSERISCI INTERVENTO >>> </button>
        </div>
      </div>
	  	  
	  </form>
      <br>
	  <div class="footer">
        <!-- <p>2017 &copy; Archistico by Emilie Rollandin</p> -->
      </div>

    <!-- </div> /container -->


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
	
	<script>
    
    function checkField(e){
          
          if(!document.getElementById('dataselezionatatesto').value || !document.getElementById('txtCliente').value){
              alert('Valorizza i campi obbligatori: "Data" e/o "Cliente"');
              e.preventDefault();
          }
    }


	$('#dataappuntamento').datepicker({
		onSelect: function onSelect(fd, date) {
			moment.locale('it');
            
			//$('#dataselezionatatesto').html(moment(date).format('L'));
            //alert(moment(date).format('L'));
			$('#dataselezionatatesto').val(moment(date).format('L'));
            
		}
	})


  /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}


function fillValue(v){

    
  var result = v.getAttribute("value").split("|");

  document.getElementById("txtCliente").value = result[0];
  document.getElementById("txtIdCliente").value = result[1];
  document.getElementById("txtViaCliente").value = "Via "+result[2];
  document.getElementById("txtComuneCliente").value = result[3];

  myFunction();
}


  
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');
if (id!==''){
    var link = document.getElementById(id);
    link.click();
    myFunction();
  }




	</script>
  </body>
</html>
