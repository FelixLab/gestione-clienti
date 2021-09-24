<?php

// Connexion à la base de données
require_once('bdd.php');
//echo $_POST['title'];

//INSERIMENTO
if (isset($_POST['id_cliente'])){
	
	$id_cliente=trim($_POST['id_cliente']);
	$dataIntervento = $_POST['dataselezionatatesto'];
	$intervento = str_replace("'","''",$_POST['Intervento']);
	$tipo = $_POST['TipoIntervento'];
	$importoTotale = $_POST['ImportoTotale'];
	$importoPagato = $_POST['ImportoPagato'];
	$dataPagamento = $_POST['DataPagamento'];
	$map = $_POST['map'];
	

	if (empty($_POST['ImportoTotale'])){
		$importoTotale=0;
	}
	if (empty($_POST['ImportoPagato']) ){
		$importoPagato=0;
	}
	if (empty($_POST['DataPagamento']) ){
		$dataPagamento='NULL';
	}


	$sql = "INSERT INTO intervento(id_cliente, intervento , data, TipoIntervento, ImportoTotale, ImportoPagato, data_pagamento, map) 
	values ('$id_cliente', '$intervento','$dataIntervento', '$tipo', '$importoTotale', '$importoPagato', '$dataPagamento', '$map')";
		
	//echo $sql;
	
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
	
	
	
    $sql = " Select max(id_intervento) as id_intervento, id_cliente from intervento where id_cliente= '$id_cliente' "; 
	$result = $bdd->query($sql);
	$id_cliente=0;
	foreach ($result as $row) {
		$id_cliente = $row['id_cliente'];	
	}
	header("Location: /gestione-clienti/viewCustomer.php?id=" . $id_cliente );
    exit();
	
}
//UPDATE
else{

	//echo 'entro update';
	if(isset($_POST['id_intervento'])){

	$dataIntervento = $_POST['data'];
	$intervento = str_replace("'","''",$_POST['Intervento']);
	$tipo = $_POST['TipoIntervento'];
	$importoTotale = $_POST['ImportoTotale'];
	$importoPagato = $_POST['ImportoPagato'];
	$dataPagamento = $_POST['data_pagamento'];
	$TipoIntervento = $_POST['TipoIntervento'];
	
	if(isset($_POST['eseguito']))
	    $eseguito = $_POST['eseguito'];
	else
	    $eseguito='off';

	    
	$priorita = $_POST['priorita'];
	$map = $_POST['map'];

	//echo $_POST['eseguito'];
    
    
	if($eseguito=='on'){
		$eseguito=1;
	}else{
		$eseguito=0;
	}

	//echo $eseguito;
	
	$time = $_POST['time'];
    //echo $time;

	$sql = "UPDATE intervento 
	SET data='$dataIntervento', ImportoTotale='$importoTotale', ImportoPagato='$importoPagato', data_pagamento='$dataPagamento', eseguito='$eseguito', priorita='$priorita', map='$map', time='$time', TipoIntervento='$TipoIntervento',Intervento='$intervento'
	WHERE id_intervento=".$_POST['id_intervento'] ;
	
	//echo $sql;
	
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
	
	//header("Location: /gestione-clienti/viewIntervento.php?id=" . trim($_POST['id_intervento']) . "&action=UPDATE" );
    //exit();
    echo "<script>window.location.replace('/gestione-clienti/viewIntervento.php?id=" . trim($_POST['id_intervento']) . "&action=UPDATE');</script>";
    
	}

}




	
?>
