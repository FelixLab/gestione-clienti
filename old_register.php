<?php
ob_start();
session_start();
require_once 'dbconnect.php';

// if (!isset($_SESSION['user'])) {
//     header("Location: login.php");
//     exit;
// }
// select logged in users detail
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

?>

<?php

// if (isset($_SESSION['user']) != "") {
//     header("Location: index.php");
// }
include_once 'dbconnect.php';





if (isset($_POST['signup'])) {

    $uname = trim($_POST['uname']); // get posted data and remove whitespace
    $email = trim($_POST['email']);
    $upass = trim($_POST['pass']);
    $denominazione = trim($_POST['denominazione']);
    $isAdmin = trim($_POST['isAdmin']);
    
    
    

    // hash password with SHA256;
    $password = hash('sha256', $upass);
    //$password = $upass;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 


    // check email exist or not
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $count = $result->num_rows;

    if ($count == 0) { // if email is not found add user

        

        $stmts = $conn->prepare("INSERT INTO users(username,email,password,denominazione,isAdmin) VALUES(?, ?, ?, ?, ?)");
        $stmts->bind_param("sssss", $uname, $email, $password, $denominazione, $isAdmin);
        $res = $stmts->execute();//get result
        $stmts->close();

        $user_id = mysqli_insert_id($conn);
        if ($user_id > 0) {

            
            // $_SESSION['user'] = $user_id; // set session and redirect to loginUser page
            // if (isset($_SESSION['user'])) {
            //     print_r($_SESSION);
            //     header("Location: index.php");
            //     exit;
            // }

            //printf('Utente %s creato correttamente', $denominazione);
            //$errtype = "notice";
            //$errMSG = "Utente creato correttamente";
            $_SESSION['sqlok'] = "UTENTE INSERITO CORRETTAMENTE";
            
           
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again";
        }

    } else {
        $errTyp = "warning";
        $errMSG = "Email is already used";
    }

}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
    
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.4.2.min.css" type="text/css"/>
    
    <title>Gestione</title>
    
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


<?php

if(isset($_SESSION['sqlok'])) {
    echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Utente inserito correttamente</div>";
    unset($_SESSION['sqlok']);
}

?>

<form method="post" >

    <div id="login-form" class="row">
    <!--autocomplete="off"-->
        

            <div class="col-md-12">

                <div class="form-group">
                    <h2 class="">Inserisci utente</h2>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                <?php
                if (isset($errMSG)) {

                    ?>
                    <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="uname" class="form-control" placeholder="Enter Username" required/>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="denominazione" class="form-control" placeholder="Nome e Cognome" required/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" name="pass" class="form-control" placeholder="Enter Password"
                               required/>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-user"></span></span>
                        <select class="form-control" id="isAdmin" name="isAdmin">
                            <option value='0'>Utente Normale</option>
                            <option value='1'>Utente Administrator</option>
                        </select>
                    </div>
                </div>



                <!-- <div class="checkbox">
                    <label><input type="checkbox" id="TOS" value="This"><a href="#">I agree with
                            terms of service</a></label>
                </div> -->

                <div class="form-group">
                    <button type="submit" class="btn    btn-block btn-primary" name="signup" id="reg">Registra</button>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                <!-- <div class="form-group">
                    <a href="login.php" type="button" class="btn btn-block btn-success" name="btn-login">Login</a>
                </div> -->

            </div>

        
    </div>
    </form>
    
    
    <!-- pulsante per scaricare il backup del DB (dump dati) -->
    <br/>
    <hr/>
    <div style="text-align:center; margin: 0 auto;">   
        Scarica il <b>BACKUP DATI</b>
        <br/>
        <br/>
        <a href='dump_db.php' class='btn btn-success'>DOWNLOAD <i class='fa fa-arrow-down'></i></a>
    </div>
    
    
    <!-- pulsante per scaricare il backup del DB (dump dati) -->
    <br/>
    <hr/>
    <div style="text-align:center; margin: 0 auto;">   
        Scarica il <b>BACKUP FILES</b>
        <br/>
        <br/>
        <a href='backup_file.php' class='btn btn-warning'>DOWNLOAD <i class='fa fa-arrow-down'></i></a>
    </div>
    <br/>
    <br/>
    
    <div style="text-align:center; margin: 0 auto;">
        <b>NB: esegui le operazioni di BACKUP almeno con cadenza periodica settimanale.</b>
        <br/>
    </div>
    
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/tos.js"></script>

</body>
</html>
