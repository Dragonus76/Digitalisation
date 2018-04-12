<?php
session_name('CAKEPHP');
session_start();
 // echo '<pre>';
 // print_r($_SESSION);
 // echo '</pre>';die();

// echo($_SESSION['current_user']['MyOrder'][0]['ttc']);
// echo($_SESSION['current_user']['MyOrder'][0]['cleref']);
?>
<!--
-------------------------------------------------------------
 Topic	 : Exemple PHP traitement de la requête de paiement
 Version : P615

 		Dans cet exemple, on affiche un formulaire HTML
		de connection à l'internaute.

-------------------------------------------------------------
-->

<!--	Affichage du header html	-->
 <?php


// on construit le tableau du caddie en récupérant les variables de la session
$TheCaddie = array();

// les infos du client
$TheCaddie[] =  $_SESSION['current_user']['User']['id'];
$TheCaddie[] =  $_SESSION['current_user']['User']['name'];
$TheCaddie[] =  $_SESSION['current_user']['User']['firstname'];
$TheCaddie[] =  $_SESSION['current_user']['User']['street'];
$TheCaddie[] =  $_SESSION['current_user']['User']['city'];
$TheCaddie[] =  $_SESSION['current_user']['User']['zip_code'];
$TheCaddie[] =  $_SESSION['current_user']['User']['phone'];
$TheCaddie[] =  $_SESSION['current_user']['User']['email'];

//le contenu du caddie
$TheCaddie[] =  $_SESSION['OrderID'];
$TheCaddie[] =  $_SESSION['OrderREF'];
$TheCaddie[] =  $_SESSION['OrderTTC'];



//pour envoyer le caddie à e-transaction sans probleme
//on serialize le tableau pour en faire 1 string et on le base64_encode()
//car certains caractères sont interdits dans la valeur du parm caddie

$xCaddie = base64_encode(serialize($TheCaddie));

 

	print ("<HTML><HEAD><TITLE>SOGENACTIF - Paiement Securise sur Internet</TITLE></HEAD>");
	print ("<BODY bgcolor=#ffffff>");
	print ("<Font color=#000000>");
	print ("<center><H1>SOGENACTIF - Paiement Securise sur Internet</center><br><br>");


	//		Affectation des paramètres obligatoires

	$ttc=$_SESSION['OrderTTC']*100; //Le prix doit être passé en centime pour la transaction bancaire
	$parm="merchant_id=079860829500019";
	$parm="$parm merchant_country=fr";
	//$parm="$parm amount=100";
	$parm="$parm amount=$ttc";
	$parm="$parm currency_code=978";

	// Initialisation du chemin du fichier pathfile (à modifier)
	    //   ex :
	    //    -> Windows : $parm="$parm pathfile=c:/repertoire/pathfile";
	    //    -> Unix    : $parm="$parm pathfile=/home/repertoire/pathfile";
	    
	$parm="$parm pathfile=/home/scanepit/www/app/webroot/payment";
	

	//		Si aucun transaction_id n'est affecté, request en génère
	//		un automatiquement à partir de heure/minutes/secondes
	//		Référez vous au Guide du Programmeur pour
	//		les réserves émises sur cette fonctionnalité
	//
	//		$parm="$parm transaction_id=123456";



	//		Affectation dynamique des autres paramètres
	// 		Les valeurs proposées ne sont que des exemples
	// 		Les champs et leur utilisation sont expliqués dans le Dictionnaire des données
	//
	// 		$parm="$parm normal_return_url=http://www.maboutique.fr/cgi-bin/call_response.php";
	//		$parm="$parm cancel_return_url=http://www.maboutique.fr/cgi-bin/call_response.php";
	//		$parm="$parm automatic_response_url=http://www.maboutique.fr/cgi-bin/call_autoresponse.php";
	//		$parm="$parm language=fr";
	//		$parm="$parm payment_means=CB,2,VISA,2,MASTERCARD,2";
	//		$parm="$parm header_flag=no";
	//		$parm="$parm capture_day=";
	//		$parm="$parm capture_mode=";
	//		$parm="$parm bgcolor=";
	//		$parm="$parm block_align=";
	//		$parm="$parm block_order=";
	//		$parm="$parm textcolor=";
			// $produit=$_SESSION['current_user']['MyOrder'][0]['listproduct'];
			// $parm="$parm receipt_complement=". $produit;
		 $parm="$parm caddie=".$xCaddie;
	//		$parm="$parm customer_id=";

			$parm="$parm customer_email=".$_SESSION['current_user']['User']['email'];
	//		$parm="$parm customer_ip_address=";
	//		$parm="$parm data=";
	//		$parm="$parm return_context=";
	//		$parm="$parm target=";
			$parm="$parm order_id=".$_SESSION['OrderID'];


	//		Les valeurs suivantes ne sont utilisables qu'en pré-production
	//		Elles nécessitent l'installation de vos fichiers sur le serveur de paiement
	//
	// 		$parm="$parm normal_return_logo=";
	// 		$parm="$parm cancel_return_logo=";
	// 		$parm="$parm submit_logo=";
	// 		$parm="$parm logo_id=";
	// 		$parm="$parm logo_id2=";
	// 		$parm="$parm advert=";
	// 		$parm="$parm background_id=";
	// 		$parm="$parm templatefile=";


	//		insertion de la commande en base de données (optionnel)
	//		A développer en fonction de votre système d'information

	// Initialisation du chemin de l'executable request (à modifier)
	// ex :
	// -> Windows : $path_bin = "c:/repertoire/bin/request";
	// -> Unix    : $path_bin = "/home/repertoire/bin/request";
	//

	$path_bin = "/home/scanepit/www/app/webroot/payment/request";


	//	Appel du binaire request
	// La fonction escapeshellcmd() est incompatible avec certaines options avancées
  	// comme le paiement en plusieurs fois qui nécessite  des caractères spéciaux 
  	// dans le paramètre data de la requête de paiement.
  	// Dans ce cas particulier, il est préférable d.exécuter la fonction escapeshellcmd()
  	// sur chacun des paramètres que l.on veut passer à l.exécutable sauf sur le paramètre data.
	$parm = escapeshellcmd($parm);	
	$result=exec("$path_bin $parm");

	//	sortie de la fonction : $result=!code!error!buffer!
	//	    - code=0	: la fonction génère une page html contenue dans la variable buffer
	//	    - code=-1 	: La fonction retourne un message d'erreur dans la variable error

	//On separe les differents champs et on les met dans une variable tableau

	$tableau = explode ("!", "$result");

	//	récupération des paramètres

	$code = $tableau[1];
	$error = $tableau[2];
	$message = $tableau[3];

	//  analyse du code retour

  if (( $code == "" ) && ( $error == "" ) )
 	{
  	print ("<BR><CENTER>erreur appel request</CENTER><BR>");
  	print ("executable request non trouve $path_bin");
 	}

	//	Erreur, affiche le message d'erreur

	else if ($code != 0){
		print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
		print ("<br><br><br>");
		print (" message erreur : $error <br>");
	}

	//	OK, affiche le formulaire HTML
	else {
		print ("<br><br>");
		
		# OK, affichage du mode DEBUG si activé
		print (" $error <br>");
		
		print ("  $message <br>");
	}

print ("</BODY></HTML>");

?>
