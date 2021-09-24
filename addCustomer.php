<?php

// Connexion à la base de données
require_once('bdd.php');
//echo $_POST['title'];

//INSERIMENTO
if (isset($_POST['denominazione']) && isset($_POST['via']) && isset($_POST['comune']) && isset($_POST['provincia']) && isset($_POST['tel']) && !isset($_POST['id_cliente'])){
	
	$denominazione = str_replace("'","''",$_POST['denominazione']);
	$via = str_replace("'","''",$_POST['via']);
	$comune = str_replace("'","''",$_POST['comune']);
	$provincia = $_POST['provincia'];
	$cap = $_POST['cap'];
	$cf_piva = $_POST['cf_piva'];
	$telefono = $_POST['tel'];
	$fax = $_POST['fax'];
	$mail = $_POST['mail'];
	$marca_caldaia =  $_POST['marca_caldaia'];
	$tipo = $_POST['tipo'];
	$anno = $_POST['anno'];
	$DataInst = $_POST['DataInst'];
	$gt = $_POST['gt'];
	$p_utile = $_POST['p_utile'];
	$combustibile = $_POST['combustibile'];
	$alimentazione = $_POST['alimentazione'];
	$locale = $_POST['locale'];
	$seriale = $_POST['seriale'];
	$codice_catasto = $_POST['codice_catasto'];
	$giorni = $_POST['giorni'];
	$note = $_POST['note'];
	$potenzaFocolare = $_POST['potenzaFocolare'];
	$modello = $_POST['modello'];
	$campo_libero =str_replace("'","''",$_POST['campo_libero']);
	
	

	if (empty($anno)){
		$anno=0;
	}
	if (empty($gt) ){
		$gt=0;
	}
	if (empty($potenzaFocolare) ){
		$potenzaFocolare=0;
	}
	


	$sql = "INSERT INTO cliente(denominazione, Via, comune, provincia, Cap, CF_PIVA, Tel, Fax, Mail, MarcaCaldaia, Tipo, Anno, DataInst, GT, Seriale, Codice_Catasto, Giorni, Attiva, Note, pUtile, potenzaFocolare, Combustibile, Modello, Alimentazione, Sospeso, Locale, CampoLibero) 
	values ('$denominazione', '$via', '$comune', '$provincia', '$cap', '$cf_piva', '$telefono', '$fax', '$mail', '$marca_caldaia', '$tipo', '$anno', '$DataInst', '$gt', '$seriale', '$codice_catasto', '$giorni', 'TRUE', '$note', '$p_utile', '$potenzaFocolare', '$combustibile', '$modello', '$alimentazione', 'FALSE', '$locale', '$campo_libero')";
		
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
	
	
	
    $sql = "Select max(id_cliente) as id_cliente from cliente"; // SQL with parameters
	$result = $bdd->query($sql);
	$id_cliente=0;
	foreach ($result as $row) {
		$id_cliente = $row['id_cliente'];	
	}
	header("Location: /gestione-clienti/viewCustomer.php?id=" . $id_cliente . "&action=INSERT" );
    exit();
	
}
//UPDATE
else{

	//echo 'entro update';
	if(isset($_POST['id_cliente'])){

	$idCliente = $_POST['id_cliente'];
	$denominazione = str_replace("'","''",$_POST['denominazione']);
	$via = str_replace("'","''",$_POST['via']);
	$comune = str_replace("'","''",$_POST['comune']);
	$provincia = $_POST['provincia'];
	$cap = $_POST['cap'];
	$cf_piva = $_POST['cf_piva'];
	$telefono = $_POST['tel'];
	$fax = $_POST['fax'];
	$mail = $_POST['mail'];
	$marca_caldaia =  $_POST['marca_caldaia'];
	$tipo = $_POST['tipo'];
	$anno = $_POST['anno'];
	$DataInst = $_POST['DataInst'];
	$gt = $_POST['gt'];
	$p_utile = $_POST['p_utile'];
	$combustibile = $_POST['combustibile'];
	$alimentazione = $_POST['alimentazione'];
	$locale = $_POST['locale'];
	$seriale = $_POST['seriale'];
	$codice_catasto = $_POST['codice_catasto'];
	$giorni = $_POST['giorni'];
	$note = str_replace("'","''",$_POST['note']);
	$potenzaFocolare = $_POST['potenzaFocolare'];
	$modello = $_POST['modello'];
	$campo_libero =str_replace("'","''",$_POST['campo_libero']);

	if(isset($_POST['attiva']))
		$attiva = 'TRUE';
	else
		$attiva = '';
	if(isset($_POST['sospeso']))
		$sospeso = 'TRUE';
	else
		$sospeso = 'FALSE';

	if (empty($anno)){
		$anno=0;
	}
	if (empty($gt) ){
		$gt=0;
	}
	if (empty($potenzaFocolare) ){
		$potenzaFocolare=0;
	}
	if(empty($cap)){
		$cap=0;
	}
	if (empty($giorni)){
		$giorni=0;
	}
	



	$sql = "UPDATE cliente 
	SET denominazione = '$denominazione', via='$via', Comune= '$comune', provincia='$provincia', cap='$cap', CF_PIVA='$cf_piva', tel='$telefono', fax='$fax', mail='$mail',
	MarcaCaldaia='$marca_caldaia', Tipo='$tipo', Anno='$anno', DataInst='$DataInst', GT='$gt', Seriale='$seriale', Codice_Catasto='$codice_catasto', Giorni='$giorni', Attiva='$attiva', 
	Note='$note', pUtile='$p_utile', PotenzaFocolare='$potenzaFocolare', combustibile='$combustibile', Modello='$modello', Alimentazione='$alimentazione', Sospeso='$sospeso', 
	Locale='$locale', CampoLibero='$campo_libero' 
	WHERE id_cliente='$idCliente' " ;
	
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
	
	
	//header("Location:/gestione-clienti/viewCustomer.php?id=" . $idCliente . "&action=UPDATE" );
    //exit();
    echo "<script>window.location.replace('/gestione-clienti/viewCustomer.php?id=" . $idCliente . "&action=UPDATE');</script>";
	}

}




	
?>
