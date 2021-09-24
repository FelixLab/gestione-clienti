<?php
ob_start();
session_start();
require_once('bdd.php');
require_once 'dbconnect.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

//echo 'eccomi';

if(isset($_GET['cliente']) && isset($_GET['intervento'])){


	$idCliente=$_GET['cliente'];
	$idIntervento=$_GET['intervento'];

	if (is_numeric($idCliente) && is_numeric($idIntervento)){

		$sql = "delete from intervento WHERE id_intervento='$idIntervento';" ;

		$query = $bdd->prepare( $sql );
		if ($query == false) {
		print_r($bdd->errorInfo());
		die ('Erreur prepare');
		}
		$sth = $query->execute();
		if ($sth == false) {
		print_r($query->errorInfo());
		die ('Erreur execute');
		}
	}
	
	
	header("Location: /gestione-clienti/viewCustomer.php?id=".$idCliente."&action=INTERVENTO_DELETED");
    exit();

}
	
?>
