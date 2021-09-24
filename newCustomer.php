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

    <title>Clienti</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">
   
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
</style>

<script type="text/javascript">
//script
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

  <div class="" style="text-align: center;">
        <h2 class="corsivo" style="text-align: center; font-weight: BOLD;">AGGIUNGI NUOVO CLIENTE</h2>
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
		






<form name="Form" action="addCustomer.php" method="post">
    
	  <div class="row">
	    <div class="col-lg-6">      
		    <div class="form-group">
             <label>DENOMINAZIONE *</label>
             <input type="text" class="form-control" value="" placeholder="DENOMINAZIONE" name='denominazione' required> 
             <br />
             <label>VIA *</label>
             <input type="text" class="form-control" value="" placeholder="VIA" name='via' required>
             <br />
             <label>COMUNE *</label>
             <input type="text" class="form-control" value="" placeholder="COMUNE" name='comune' required>
             <br />
             <label>PROVINCIA *</label>
             <select name='provincia' class="form-control" required>
                    <OPTION VALUE=""></OPTION>
                	<OPTION VALUE="AG">AGRIGENTO</OPTION>
                	<OPTION VALUE="AL">ALESSANDRIA</OPTION>
                	<OPTION VALUE="AN">ANCONA</OPTION>
                	<OPTION VALUE="AO">AOSTA</OPTION>
                	<OPTION VALUE="AR">AREZZO</OPTION>
                	<OPTION VALUE="AP">ASCOLI PICENO</OPTION>
                	<OPTION VALUE="AT">ASTI</OPTION>
                	<OPTION VALUE="AV">AVELLINO</OPTION>
                	<OPTION VALUE="BA">BARI</OPTION>
                	<OPTION VALUE="BT">BARLETTA-ANDRIA-TRANI</OPTION>
                	<OPTION VALUE="BL">BELLUNO</OPTION>
                	<OPTION VALUE="BN">BENEVENTO</OPTION>
                	<OPTION VALUE="BG">BERGAMO</OPTION>
                	<OPTION VALUE="BI">BIELLA</OPTION>
                	<OPTION VALUE="BO">BOLOGNA</OPTION>
                	<OPTION VALUE="BZ">BOLZANO</OPTION>
                	<OPTION VALUE="BS">BRESCIA</OPTION>
                	<OPTION VALUE="BR">BRINDISI</OPTION>
                	<OPTION VALUE="CA">CAGLIARI</OPTION>
                	<OPTION VALUE="CL">CALTANISSETTA</OPTION>
                	<OPTION VALUE="CB">CAMPOBASSO</OPTION>
                	<OPTION VALUE="CI">CARBONIA-IGLESIAS</OPTION>
                	<OPTION VALUE="CE">CASERTA</OPTION>
                	<OPTION VALUE="CT">CATANIA</OPTION>
                	<OPTION VALUE="CZ">CATANZARO</OPTION>
                	<OPTION VALUE="CH">CHIETI</OPTION>
                	<OPTION VALUE="CO">COMO</OPTION>
                	<OPTION VALUE="CS">COSENZA</OPTION>
                	<OPTION VALUE="CR">CREMONA</OPTION>
                	<OPTION VALUE="KR">CROTONE</OPTION>
                	<OPTION VALUE="CN">CUNEO</OPTION>
                	<OPTION VALUE="EN">ENNA</OPTION>
                	<OPTION VALUE="FM">FERMO</OPTION>
                	<OPTION VALUE="FE">FERRARA</OPTION>
                	<OPTION VALUE="FI">FIRENZE</OPTION>
                	<OPTION VALUE="FG">FOGGIA</OPTION>
                	<OPTION VALUE="FC">FORL&IGRAVE;-CESENA</OPTION>
                	<OPTION VALUE="FR">FROSINONE</OPTION>
                	<OPTION VALUE="GE">GENOVA</OPTION>
                	<OPTION VALUE="GO">GORIZIA</OPTION>
                	<OPTION VALUE="GR">GROSSETO</OPTION>
                	<OPTION VALUE="IM">IMPERIA</OPTION>
                	<OPTION VALUE="IS">ISERNIA</OPTION>
                	<OPTION VALUE="SP">LA SPEZIA</OPTION>
                	<OPTION VALUE="AQ">L'AQUILA</OPTION>
                	<OPTION VALUE="LT">LATINA</OPTION>
                	<OPTION VALUE="LE">LECCE</OPTION>
                	<OPTION VALUE="LC">LECCO</OPTION>
                	<OPTION VALUE="LI">LIVORNO</OPTION>
                	<OPTION VALUE="LO">LODI</OPTION>
                	<OPTION VALUE="LU">LUCCA</OPTION>
                	<OPTION VALUE="MC">MACERATA</OPTION>
                	<OPTION VALUE="MN">MANTOVA</OPTION>
                	<OPTION VALUE="MS">MASSA-CARRARA</OPTION>
                	<OPTION VALUE="MT">MATERA</OPTION>
                	<OPTION VALUE="VS">MEDIO CAMPIDANO</OPTION>
                	<OPTION VALUE="ME">MESSINA</OPTION>
                	<OPTION VALUE="MI">MILANO</OPTION>
                	<OPTION VALUE="MO">MODENA</OPTION>
                	<OPTION VALUE="MB">MONZA E DELLA BRIANZA</OPTION>
                	<OPTION VALUE="NA">NAPOLI</OPTION>
                	<OPTION VALUE="NO">NOVARA</OPTION>
                	<OPTION VALUE="NU">NUORO</OPTION>
                	<OPTION VALUE="OG">OGLIASTRA</OPTION>
                	<OPTION VALUE="OT">OLBIA-TEMPIO</OPTION>
                	<OPTION VALUE="OR">ORISTANO</OPTION>
                	<OPTION VALUE="PD">PADOVA</OPTION>
                	<OPTION VALUE="PA">PALERMO</OPTION>
                	<OPTION VALUE="PR">PARMA</OPTION>
                	<OPTION VALUE="PV">PAVIA</OPTION>
                	<OPTION VALUE="PG">PERUGIA</OPTION>
                	<OPTION VALUE="PU">PESARO E URBINO</OPTION>
                	<OPTION VALUE="PE">PESCARA</OPTION>
                	<OPTION VALUE="PC">PIACENZA</OPTION>
                	<OPTION VALUE="PI">PISA</OPTION>
                	<OPTION VALUE="PT">PISTOIA</OPTION>
                	<OPTION VALUE="PN">PORDENONE</OPTION>
                	<OPTION VALUE="PZ">POTENZA</OPTION>
                	<OPTION VALUE="PO">PRATO</OPTION>
                	<OPTION VALUE="RG">RAGUSA</OPTION>
                	<OPTION VALUE="RA">RAVENNA</OPTION>
                	<OPTION VALUE="RC">REGGIO DI CALABRIA</OPTION>
                	<OPTION VALUE="RE">REGGIO NELL'EMILIA</OPTION>
                	<OPTION VALUE="RI">RIETI</OPTION>
                	<OPTION VALUE="RN">RIMINI</OPTION>
                	<OPTION VALUE="RM">ROMA</OPTION>
                	<OPTION VALUE="RO">ROVIGO</OPTION>
                	<OPTION VALUE="SA">SALERNO</OPTION>
                	<OPTION VALUE="SS">SASSARI</OPTION>
                	<OPTION VALUE="SV">SAVONA</OPTION>
                	<OPTION VALUE="SI">SIENA</OPTION>
                	<OPTION VALUE="SR">SIRACUSA</OPTION>
                	<OPTION VALUE="SO">SONDRIO</OPTION>
                	<OPTION VALUE="TA">TARANTO</OPTION>
                	<OPTION VALUE="TE">TERAMO</OPTION>
                	<OPTION VALUE="TR">TERNI</OPTION>
                	<OPTION VALUE="TO">TORINO</OPTION>
                	<OPTION VALUE="TP">TRAPANI</OPTION>
                	<OPTION VALUE="TN">TRENTO</OPTION>
                	<OPTION VALUE="TV">TREVISO</OPTION>
                	<OPTION VALUE="TS">TRIESTE</OPTION>
                	<OPTION VALUE="UD">UDINE</OPTION>
                	<OPTION VALUE="VA">VARESE</OPTION>
                	<OPTION VALUE="VE">VENEZIA</OPTION>
                	<OPTION VALUE="VB">VERBANO-CUSIO-OSSOLA</OPTION>
                	<OPTION VALUE="VC">VERCELLI</OPTION>
                	<OPTION VALUE="VR">VERONA</OPTION>
                	<OPTION VALUE="VV">VIBO VALENTIA</OPTION>
                	<OPTION VALUE="VI">VICENZA</OPTION>
                	<OPTION VALUE="VT">VITERBO</OPTION> 
             </select>
            </div>
      </div>

      <div class="col-lg-6">      
		<div class="form-group">
            <label>CAP</label>
            <input type="text" class="form-control" value="" placeholder="CAP" name='cap' >
            <br/>
            <label>CF/PIVA</label>
            <input type="text" class="form-control" value="" placeholder="CF_PIVA" name='cf_piva'>
            <br />
            <label>TEL * ( Separare più numeri con il simbolo / )</label>
            <input type="text" class="form-control" value="" placeholder="TELEFONO" name='tel' required>
            <br />
            <label>FAX</label>
            <input type="text" class="form-control" value="" placeholder="FAX" name='fax'>
            <br />
            <label>MAIL</label>
            <input type="text" class="form-control" value="" placeholder="MAIL" name='mail'>
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
             <input type="text" class="form-control" value="" placeholder="MARCA CALDAIA" name='marca_caldaia' >
             <br/>
             <label>TIPO</label>
             <input type="text" class="form-control" value="" placeholder="TIPO" name='tipo'>
             <br />
             <label>ANNO</label>
             <input type="text" class="form-control" value="" placeholder="ANNO" name='anno'>
             <br />
             <label>DATA INSTALLAZIONE</label>
             <input type="text" class="form-control" value="" placeholder="Data Installazione" name='DataInst'>
             <br />
             <label>GT</label>
             <input type="text" class="form-control" value="" placeholder="GT" name='gt'>
             <br />
             <label>Potenza Utile</label>
             <input type="text" class="form-control" value="" placeholder="potenza utile" name='p_utile'>
             <br />
             <label>COMBUSTIBILE</label>
             <input type="text" class="form-control" value="" placeholder="COMBUSTIBILE" name='combustibile'>
             <br />
             <label>ALIMENTAZIONE</label>
             <input type="text" class="form-control" value="" placeholder="ALIMENTAZIONE" name='alimentazione'>
             <br />
             <label>LOCALE</label>
             <input type="text" class="form-control" value="" placeholder="LOCALE" name='locale'>
            </div>
      </div>

      <div class="col-lg-6">      
		<div class="form-group">
            <label>SERIALE</label>
            <input type="text" class="form-control" value="" placeholder="SERIALE" name='seriale' >
            <br/>
            <label>CODICE CATASTO</label>
            <input type="text" class="form-control" value="" placeholder="CODICE CATASTO" name='codice_catasto'>
            <br />
            <label>GIORNI RINNVO MANUTENZIONE</label>
            <input type="text" class="form-control" value="365" placeholder="GIORNI RINNOVO ULTIMA MANUTENZIONE" name='giorni'>
            <br />
            <label>NOTE</label>
            <input type="text" class="form-control" value="" placeholder="NOTE" name='note'>
            <br />
             <label>POTENZA FOCOLARE</label>
             <input type="text" class="form-control" value="" placeholder="potenza focolare" name='potenzaFocolare'>
             <br />
             <label>MODELLO</label>
             <input type="text" class="form-control" value="" placeholder="MODELLO" name='modello'>
             <br />
             <label>CAMPO LIBERO</label>
             <textarea type="text" class="form-control" value="" placeholder="CAMPO LIBERO" name='campo_libero'></textarea>
        </div>
      </div>

    </div>
    <hr>
    
    <label> * Campo Obbligatorio</label>
    
    <hr>


	  <div class="row">
	    <div class="col-lg-2">
        <button type="submit" class="btn btn-success btn-lg">Salva Cliente</button>
      </div>
    </div>

    




	  </form>
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
	<script src="dist/moment/moment-with-locales.js"></script>
	
	
  </body>
</html>
