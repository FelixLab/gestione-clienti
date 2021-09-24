<?php

// Connexion à la base de données
require_once('bdd.php');
//echo $_POST['title'];


	//UPDATE
	//echo 'entro update';
	if(isset($_GET['id_intervento']) && isset($_GET['execute']) && isset($_GET['day'])){

		$eseguito=$_GET['execute'];
		if($eseguito==1){
			$eseguito=1;
		}else{
			$eseguito=0;
		}
		
		$sql = "UPDATE intervento 
		SET eseguito='$eseguito'
		WHERE id_intervento=".$_GET['id_intervento'] ;
		
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
		
		if($_GET['day']==0)
			header("Location: /gestione-clienti/giornaliero.php");
		if($_GET['day']==1)
			header("Location: /gestione-clienti/domani.php");
		if($_GET['day']==2)
			header("Location: /gestione-clienti/dopodomani.php");
			
			
		exit();

	}



	
?>
