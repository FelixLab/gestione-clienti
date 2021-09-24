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
$foto = "SELECT * FROM foto where 1=1";
$interventi = "SELECT * FROM intervento where 1=1";


$id="";


if (isset($_GET['id'])) {
  $id=$_GET['id'];
  $sql = $sql . " AND id_cliente = '".$_GET['id']."' ";
  $foto = $foto . " AND idC = '".$_GET['id']."' ";
  $interventi = $interventi . " AND id_cliente = '".$_GET['id']."' order by STR_TO_DATE(data,'%d/%m/%Y') desc";
  //echo $interventi; 
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
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.4.2.min.css" type="text/css"/>
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

input[type="radio"]{
    visibility:hidden;
}

.list-group-item {
    cursor:pointer;
}

</style>



<script type="text/javascript">

function viewPhoto (e){
    //alert(e);
    //window.location = e.value;
    //window.open(e.value, '_blank');


    var w = 500;
    var h = 350;
    var l = Math.floor((screen.width-w)/2);
    var t = Math.floor((screen.height-h)/2);
    window.open(decodeURI(decodeURIComponent(e)),"","width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);

}


function viewIntervento (e){

    window.open(e,"_blank");

}


function execute(e,val){

  if(val==1){
    if( !confirm("Sei sicuro di voler eliminare la FOTO selezionata ? l'operazione è irreversibile!") ) {
        e.preventDefault();
    }  
  }
  if(val==2){
    if( !confirm("Sei sicuro di voler eliminare il CLIENTE ? l'operazione è irreversibile!") ) {
        e.preventDefault();
    }  
  }
  if(val==3){
    if( !confirm("Sei sicuro di voler eliminare L'INTERVENTO selezionato ? l'operazione è irreversibile!") ) {
        e.preventDefault();
    }  
  }
  
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
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Utente inserito correttamente</div>";
    if($_GET['action']=="UPDATE")
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Utente aggiornato correttamente</div>";
    if($_GET['action']=="FILE")
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>File Aggiunto Correttamente</div>";
    if($_GET['action']=="FILE_DELETED")
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>File Eliminato Correttamente</div>";
    if($_GET['action']=="INTERVENTO_DELETED")
        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Intervento Eliminato Correttamente</div>";
}


?>

  <div class="" style="text-align: center;">
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">CLIENTE</h2>
        <hr>
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

class cliente {
  public $id_cliente;
  public $denominazione;
  public $via;
  public $comune;
  public $provincia;
  public $data;
  public $cap;
  public $cf_iva;
  public $tel;
  public $fax;
  public $mail;

  public $marca_caldaia;
  public $tipo;
  public $anno;
  public $DataInst;
  public $gt;
  public $seriale;
  public $codice_catasto;
  public $giorni;
  public $attiva;
  public $note;
  public $p_utile;
  public $potenza_focolare;
  public $combustibile;
  public $modello;
  public $alimentazione;
  public $sospeso;
  public $locale;
  public $campo_libero;
}

class Foto{
    public $idF;
    public $idC;
    public $Nome;
}

class Intervento{
    public $id_intervento;
    public $id_cliente;
    public $Intervento;
    public $data;
    public $TipoIntervento;
}

include 'config.php';

$clienti = array();

try {

    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

    $result = $db->query($sql);
    $i = 0 ;
    foreach ($result as $row) {
      
        $row = get_object_vars($row);
        $clienti[$row['id_cliente']] = new Cliente();
        $clienti[$row['id_cliente']]->id_cliente = $row['id_cliente'];
        //echo $row['id_cliente'];
        //$data = DateTime::createFromFormat('Y-m-d', $row['DataInst']);
        //$cliente[$row['DataInst']]->data = $data->format('d-m-Y');
        $clienti[$row['id_cliente']]->denominazione = $row['denominazione'];
        //echo $row['denominazione']; 
        $clienti[$row['id_cliente']]->comune = $row['comune'];
        $clienti[$row['id_cliente']]->via = $row['Via'];
        $clienti[$row['id_cliente']]->cap = $row['Cap'];
        $clienti[$row['id_cliente']]->cf_iva = $row['CF_PIVA'];
        $clienti[$row['id_cliente']]->tel = $row['Tel'];
        $clienti[$row['id_cliente']]->fax = $row['Fax'];
        $clienti[$row['id_cliente']]->mail = $row['Mail'];
        $clienti[$row['id_cliente']]->provincia = $row['provincia'];

        $clienti[$row['id_cliente']]->marca_caldaia = $row['MarcaCaldaia'];
        $clienti[$row['id_cliente']]->tipo = $row['Tipo'];
        $clienti[$row['id_cliente']]->anno = $row['Anno'];
        $clienti[$row['id_cliente']]->DataInst = $row['DataInst'];
        $clienti[$row['id_cliente']]->gt = $row['GT'];
        $clienti[$row['id_cliente']]->seriale = $row['Seriale'];
        $clienti[$row['id_cliente']]->codice_catasto = $row['Codice_Catasto'];
        $clienti[$row['id_cliente']]->giorni = $row['Giorni'];
        $clienti[$row['id_cliente']]->attiva = $row['Attiva'];
        $clienti[$row['id_cliente']]->note = $row['Note'];
        $clienti[$row['id_cliente']]->p_utile = $row['pUtile'];
        $clienti[$row['id_cliente']]->potenza_focolare= $row['potenzaFocolare'];
        $clienti[$row['id_cliente']]->combustibile = $row['Combustibile'];
        $clienti[$row['id_cliente']]->modello = $row['Modello'];
        $clienti[$row['id_cliente']]->alimentazione = $row['Alimentazione'];
        $clienti[$row['id_cliente']]->sospeso = $row['Sospeso'];
        $clienti[$row['id_cliente']]->locale = $row['Locale'];
        $clienti[$row['id_cliente']]->campo_libero = $row['CampoLibero'];

    }
    
    // chiude il database
    $db = NULL;

} catch (PDOException $e) {
   throw new PDOException("Error  : " . $e->getMessage());
}

?>


<form name="Form" action="addCustomer.php" method="post">
    
	  <div class="row">
	    <div class="col-lg-6">      
		    <div class="form-group">
             <label>ID CLIENTE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->id_cliente ?>" placeholder="ID_CLIENTE" name='id_cliente' readonly>
             <br/>
             <label>DENOMINAZIONE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->denominazione ?>" placeholder="DENOMINAZIONE" name='denominazione'>
             <br />
             <label>VIA</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->via ?>" placeholder="VIA" name='via'>
             <br />
             <label>COMUNE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->comune ?>" placeholder="COMUNE" name='comune'>
             <br />
             <label>PROVINCIA</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->provincia ?>" placeholder="PROVINCIA" name='provincia' maxlength="2">
             
            </div>
      </div>

      <div class="col-lg-6">      
		<div class="form-group">
            <label>CAP</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->cap ?>" placeholder="CAP" name='cap' maxlength="5">
            <br/>
            <label>CF/PIVA</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->cf_iva ?>" placeholder="CF_PIVA" name='cf_piva'>
            <br />
            <label>TEL ( Separare più numeri con il simbolo / )</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->tel ?>" placeholder="TELEFONO" name='tel'>
            <br />
            <label>FAX</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->fax ?>" placeholder="FAX" name='fax'>
            <br />
            <label>MAIL</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->mail ?>" placeholder="MAIL" name='mail'>
        </div>
      </div>

    </div>

    <hr>
    <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">CALDAIA E MANUTENZIONE</h2>
    <hr>

    <div class="row">
	    <div class="col-lg-6">      
		    <div class="form-group">
             <label>MARCA CALDAIA</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->marca_caldaia ?>" placeholder="MARCA CALDAIA" name='marca_caldaia' >
             <br/>
             <label>TIPO</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->tipo ?>" placeholder="TIPO" name='tipo'  maxlength="9">
             <br />
             <label>ANNO</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->anno ?>" placeholder="ANNO" name='anno'  maxlength="5">
             <br />
             <label>DATA INSTALLAZIONE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->DataInst ?>" placeholder="Data Installazione" name='DataInst'  maxlength="10">
             <br />
             <label>GT</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->gt ?>" placeholder="GT" name='gt'  maxlength="1"> 
             <br />
             <label>Potenza Utile</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->p_utile ?>" placeholder="potenza utile" name='p_utile'>
             <br />
             <label>COMBUSTIBILE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->combustibile ?>" placeholder="COMBUSTIBILE" name='combustibile'  maxlength="10">
             <br />
             <label>ALIMENTAZIONE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->alimentazione ?>" placeholder="ALIMENTAZIONE" name='alimentazione' maxlength="10">
             <br />
             <label>LOCALE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->locale ?>" placeholder="LOCALE" name='locale'>
            </div>
      </div>

      <div class="col-lg-6">      
		<div class="form-group">
            <label>SERIALE</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->seriale ?>" placeholder="SERIALE" name='seriale' >
            <br/>
            <label>CODICE CATASTO</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->codice_catasto ?>" placeholder="CODICE CATASTO" name='codice_catasto'>
            <br />
            <label>GIORNI RINNOVO MANUTENZIONE</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->giorni ?>" placeholder="GIORNI RINNOVO ULTIMA MANUTENZIONE" name='giorni'>
            <br />
            <label >ATTIVA</label>
            <?php  if($clienti[$id]->attiva=='TRUE') {?>
            <input type="checkbox" class="form-control" style="width:5%; margin:0px;" placeholder="ATTIVA"  name='attiva' checked>
            <?php  } else { ?>
            <input type="checkbox" class="form-control" style="width:5%; margin:0px;" placeholder="ATTIVA"  name='attiva' >
            <?php  }?>
            <br />
            <label>NOTE</label>
            <input type="text" class="form-control" value="<?php echo $clienti[$id]->note ?>" placeholder="NOTE" name='note'>
            <br />
             <label>POTENZA FOCOLARE</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->potenza_focolare ?>" placeholder="potenza focolare" name='potenzaFocolare'>
             <br />
             <label>MODELLO</label>
             <input type="text" class="form-control" value="<?php echo $clienti[$id]->modello ?>" placeholder="MODELLO" name='modello'>
             <br />
             <label >SOSPESO</label>
             <?php  if($clienti[$id]->sospeso=='TRUE') {?>
             <input type="checkbox" class="form-control" style="width:5%; margin:0px;" placeholder="SOSPESO"  name='sospeso' checked>
             <?php  } else { ?>
             <input type="checkbox" class="form-control" style="width:5%; margin:0px;" placeholder="SOSPESO"  name='sospeso' >
             <?php  }?>
             <br />
             <label>CAMPO LIBERO</label>
             <textarea type="text" class="form-control" placeholder="CAMPO LIBERO" name='campo_libero'><?php echo trim($clienti[$id]->campo_libero) ?></textarea>
        </div>
      </div>

    </div>
    
    <hr>
    <div class="row">
	    <div class="col-lg-3">
            <button type="submit" class="btn btn-success btn-lg">Salva Modifiche</button>
    </div>

    </div>
    
    <hr>
    </form>

    
    <div class="row">

    <div class="col-lg-6" >
    <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">INTERVENTI</h2>
    <!--<select name="intervento" id="intervento" class="form-control" >-->
    <ul class="list-group">
    <?php 

        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $intervents = array();
        $result = $db->query($interventi);
        
         foreach ($result as $row) {
             $row = get_object_vars($row);
             $intervents[$row['id_cliente']] = new Intervento();
            
             $intervents[$row['id_cliente']]->id_cliente = $row['id_cliente'];  
             $intervents[$row['id_cliente']]->id_intervento = $row['id_intervento'];            
             $intervents[$row['id_cliente']]->Intervento= $row['Intervento'];
             $intervents[$row['id_cliente']]->data= $row['data'];
             $intervents[$row['id_cliente']]->TipoIntervento= $row['TipoIntervento'];
             //onClick='viewIntervento(this)'
             $link = "/gestione-clienti/viewIntervento.php?id=". $intervents[$id]->id_intervento ."" ;
             echo "";
             
              echo "
            <div class='list-group-item'>
            
            <div style='float:left; display:block;width:75%;border:0;'>
            <li class='list-group-item' style='border:0;text-align:left;'  onClick="; echo "viewIntervento('". $link ."')".">";  echo "<b>" .$intervents[$id]->Intervento . "</b> (" . $intervents[$id]->TipoIntervento. "-" . $intervents[$id]->data. ") " ."
            </li>
            </div>".
            "
            <div style='float:left; display:block;width:25%;text-align:right;'>
            &nbsp;&nbsp;<a class='btn btn-primary btn-danger' href='deleteIntervento.php?cliente=".$intervents[$id]->id_cliente."&intervento=".$intervents[$id]->id_intervento."'  onclick='execute(event,3);'><i class='fa fa-trash  fa-lg'></i></a>
            </div>
            <div style='clear:both;'></div>
            </div>";
         }
                
        // chiude il database
        $db = NULL;
        
        
        echo "
        <div class='list-group-item'>
        <div class='file-field' style='text-align:right;'>
        <a href='index.php?id=".$id."' class='btn btn-primary btn-info' title='Pianifica intervento'>+ <i class='fa fa-wrench'></i></a>
        </div>
        </div>
        ";

    ?>
    <!--</select>-->
    </ul>
    <br/>
    
    </div>

    <div class="col-lg-6" >
    <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">FILES</h2>
    <!--<select name="foto" id="foto" class="form-control" multiple>-->
    <ul class="list-group">
    <?php 
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $photos = array();
        $result = $db->query($foto);
        
        foreach ($result as $row) {
            $row = get_object_vars($row);
            $photos[$row['idC']] = new Foto();
            
            $photos[$row['idC']]->idC = $row['idC'];            
            $photos[$row['idC']]->Nome = $row['Nome'];
            $photos[$row['idC']]->idF = $row['idF'];
            //onClick='viewPhoto(this)'
            $link = '/gestione-clienti/foto/'.$photos[$id]->Nome ;
            echo "
            <div class='list-group-item'>
            
            <div style='float:left; display:block;width:75%;border:0;'>
            <li  class='list-group-item' style='border:0;text-align:left;'  onClick="; echo "viewPhoto('". rawurlencode($link) ."')".">". $photos[$id]->Nome.
            "</li>
            </div>".
            "
            <div style='float:left; display:block;width:25%;text-align:right;'>
            &nbsp;&nbsp;<a class='btn btn-primary btn-danger' href='deleteFile.php?id_cliente=". $id ."&id_foto=".$photos[$id]->idF."'  onclick='execute(event,1);'><i class='fa fa-trash  fa-lg'></i></a>
            </div>
            <div style='clear:both;'></div>
            </div>";
        
        }
        
        echo "
            <div class='list-group-item'>
                <form action='addImage.php' method='post' enctype='multipart/form-data'>
                    <div class='file-field' style='float:left; display:block;width:75%;border:0;'>
                    <div class='btn btn-mdb-color btn-rounded float-left'>
                    <input type='file' name='fileToUpload' id='fileToUpload' required>
                    <input type='hidden' name='id_cliente' value='". $id ."'>"."
                    </div>
                    </div>".
                    "
                    <div style='float:left; display:block;width:25%;text-align:right;'>
                    <button type='submit' class='btn btn-primary btn-info' title='upload'>
                        <i class='fa fa-upload fa-lg'></i>
                    </button>
                    </div>
                    <div style='clear:both;'></div>
                </form>
            </div>";
        
        // chiude il database
        $db = NULL;
    ?>
    <!--</select>-->

    </ul>
    <br/>
    
    </div>

    </div>
    <br/>
    <br/>
    <?php echo "<a class='btn btn-primary btn-lg btn-block btn-danger' href='deleteCustomer.php?id=". $id ."'  onclick='execute(event,2);'> <i class='fa fa-trash'></i> ELIMINA CLIENTE</a>"; ?>
    
    <br/>
    <br/>







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
