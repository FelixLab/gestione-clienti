<?php
ob_start();
session_start();
require_once('bdd.php');
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if(isset($_GET['id'])){


	$idCliente=$_GET['id'];

	if (is_numeric($idCliente)){
		$sql = "delete from cliente WHERE id_cliente='$idCliente'; delete from intervento WHERE id_cliente='$idCliente'; delete from foto WHERE idC='$idCliente';" ;

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
	
	
	header("Location: /gestione-clienti/customerList.php");
    exit();

}
	
?>
