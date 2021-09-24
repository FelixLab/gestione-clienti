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

if(isset($_GET['id_cliente']) && isset($_GET['id_foto'])){


	$idCliente=$_GET['id_cliente'];
	$idFoto=$_GET['id_foto'];

	if (is_numeric($idCliente) && is_numeric($idFoto)){

		//recupero nome file
		$res = $conn->query("SELECT * FROM foto WHERE idF=" . $idFoto);
		$fotoRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

		$fileName = $fotoRow['Nome'];


		
		//delete file
		$file_pointer = "foto/".$fileName;  
		if (!unlink($file_pointer)) {  
			echo ("$file_pointer , si è verificato un errore nella cancellazione del file");
			exit();
		}  
		else {  
			//echo ("$file_pointer has been deleted");  
		}  

		$sql = "delete from foto WHERE idC='$idCliente' and idF='$idFoto';" ;

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
	
	
	header("Location: /gestione-clienti/viewCustomer.php?id=".$idCliente."&action=FILE_DELETED");
    exit();

}
	
?>
