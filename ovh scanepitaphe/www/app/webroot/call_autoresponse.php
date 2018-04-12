<!--
-------------------------------------------------------------
 Topic	 : Exemple PHP traitement de l'autor?ponse de paiement
 Version : P615

 		Dans cet exemple, les donn?es de la transaction	sont
		d?crypt?es et sauvegard?es dans un fichier log.

-------------------------------------------------------------
-->

<?php


session_name('CAKEPHP');
session_start();


	// R?cup?ration de la variable crypt?e DATA
	$message="message=$_POST[DATA]";

	// Initialisation du chemin du fichier pathfile (? modifier)
	    //   ex :
	    //    -> Windows : $pathfile="pathfile=c:/repertoire/pathfile"
	    //    -> Unix    : $pathfile="pathfile=/home/repertoire/pathfile"
	    
	$pathfile="pathfile=/homez.792/scanepit/www/app/webroot/payment/pathfile";

	//Initialisation du chemin de l'executable response (? modifier)
	//ex :
	//-> Windows : $path_bin = "c:/repertoire/bin/response"
	//-> Unix    : $path_bin = "/home/repertoire/bin/response"
	//

	$path_bin = "/homez.792/scanepit/www/app/webroot/payment/response";

	// Appel du binaire response
  	$message = escapeshellcmd($message);
  	$result=exec("$path_bin $pathfile $message");

	//	Sortie de la fonction : !code!error!v1!v2!v3!...!v29
	//		- code=0	: la fonction retourne les donn?es de la transaction dans les variables v1, v2, ...
	//				: Ces variables sont d?crites dans le GUIDE DU PROGRAMMEUR
	//		- code=-1 	: La fonction retourne un message d'erreur dans la variable error


	//	on separe les differents champs et on les met dans une variable tableau

	$tableau = explode ("!", $result);

	$code = $tableau[1];
	$error = $tableau[2];
	$merchant_id = $tableau[3];
	$merchant_country = $tableau[4];
	$amount = $tableau[5];
	$transaction_id = $tableau[6];
	$payment_means = $tableau[7];
	$transmission_date= $tableau[8];
	$payment_time = $tableau[9];
	$payment_date = $tableau[10];
	$response_code = $tableau[11];
	$payment_certificate = $tableau[12];
	$authorisation_id = $tableau[13];
	$currency_code = $tableau[14];
	$card_number = $tableau[15];
	$cvv_flag = $tableau[16];
	$cvv_response_code = $tableau[17];
	$bank_response_code = $tableau[18];
	$complementary_code = $tableau[19];
	$complementary_info= $tableau[20];
	$return_context = $tableau[21];
	$caddie = $tableau[22];
	$receipt_complement = $tableau[23];
	$merchant_language = $tableau[24];
	$language = $tableau[25];
	$customer_id = $tableau[26];
	$order_id = $tableau[27];
	$customer_email = $tableau[28];
	$customer_ip_address = $tableau[29];
	$capture_day = $tableau[30];
	$capture_mode = $tableau[31];
	$data = $tableau[32];
	$order_validity = $tableau[33];
	$transaction_condition = $tableau[34];
	$statement_reference = $tableau[35];
	$card_validity = $tableau[36];
	$score_value = $tableau[37];
	$score_color = $tableau[38];
	$score_info = $tableau[39];
	$score_threshold = $tableau[40];
	$score_profile = $tableau[41];


	// Initialisation du chemin du fichier de log (? modifier)
    //   ex :
    //    -> Windows : $logfile="c:\\repertoire\\log\\logfile.txt";
    //    -> Unix    : $logfile="/home/repertoire/log/logfile.txt";
    //

	$logfile="/homez.792/scanepit/www/app/webroot/payment/log.txt";

	// Ouverture du fichier de log en append

	$fp=fopen($logfile, "a");

	//  analyse du code retour

  if (( $code == "" ) && ( $error == "" ) )
 	{
  	fwrite($fp, "erreur appel response\n");
  	print ("executable response non trouve $path_bin\n");
  	//Mise ? jour de la base de donn?es (si vous en utilisez)
	//Ici nous supprimons la client page car le paiement est d?fectueux
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
 	}

	//	Erreur, sauvegarde le message d'erreur

	else if ( $code != 0 ){	
        fwrite($fp, " API call error.\n");
        fwrite($fp, "Error message :  $error\n");
        //Mise ? jour de la base de donn?es (si vous en utilisez)
	//Ici nous supprimons la client page car le paiement est d?fectueux
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
 	}
	else {

	//OK
	//Ici, la transaction s'est bien d?roul?e, mais cela ne veut pas dire pour autant que
	//le paiement a ?t? accept? !

	//Paiement accept? = '00'
	//R?f?rez-vous au Dictionnaire des donn?es pour les num?ros de r?ponse
	if($bank_response_code == "00"){


		//Caddie
		//Ici nous retrouvons tout notre caddie que nous remmettons dans un tableau
		$arrayCaddie = unserialize(base64_decode($caddie));

		//Date (ymd) / Heure (His) de paiement en fran?ais
		$DatePay = substr($payment_date, 6, 2) . "/" . substr($payment_date, 4, 2) . "/"
		. substr($payment_date, 0, 4) ;

		$HeurePay = substr($payment_time, 0, 2) . "h " . substr($payment_time, 2, 2) . ":"
		. substr($payment_time, 4, 2) ;

		//Le re?u de la transaction que nous allons envoyer pour confirmation
		$Sujet = "Confirmation de votre paiement en ligne [ScanEpitaphe.fr]";

		$Msg.= "### CECI EST UN MESSAGE AUTOMATIQUE . MERCI DE NE PAS Y R?PONDRE ###\n\n";
		$Msg.= "Bonjour,\n";
		$Msg.= "Veuillez trouver ci-dessous le re?u de votre paiement en ligne sur ScanEpitaphe.fr \n\n";
		$Msg.= "Prenez soin d'imprimer ce message et de le joindre ? votre facture.\n";
		$Msg.= "Ces documents vous seront indispensables en cas de r?clamation.\n\n";

		$Msg.= "D?TAIL DE VOTRE COMMANDE \n";
		$Msg.= "------------------------------------------------------------\n\n";
		$Msg.= "NUM?RO DE COMMANDE             = " . $arrayCaddie[9] . " \n";

		$Msg.= "DATE DE LA TRANSACTION         = $DatePay ? $HeurePay \n";
		$Msg.= "ADRESSE WEB DU COMMERCANT      = ScanEpitaphe.fr \n";
		$Msg.= "IDENTIFIANT COMMERCANT         = $merchant_id \n";
		$Msg.= "REFERENCE DE LA TRANSACTION    = $transaction_id \n";
		$Msg.= "MONTANT DE LA TRANSACTION      = " . substr($amount,0,-2) . "," . substr($amount ,-2)
		. " euros \n";
		$Msg.= "4 PREMIER CHIFFRE DE CARTE     = $card_number  \n";
		$Msg.= "AUTORISATION                   = $authorisation_id \n";
		$Msg.= "CERTIFICAT DE LA TRANSACTION   = $payment_certificate \n\n";

		$Msg.= "NOM                            = " . $arrayCaddie[1] . " \n";
		$Msg.= "PR?NOM                         = " . $arrayCaddie[2] . " \n";
		$Msg.= "ADRESSE                        = " . $arrayCaddie[3] . " \n";
		$Msg.= "VILLE                          = " . $arrayCaddie[4] . " \n";
		$Msg.= "CODE POSTAL                    = " . $arrayCaddie[5] . " \n";
		$Msg.= "T?L?PHONE                      = " . $arrayCaddie[6] . " \n\n";

		$Msg.= "Reference commande                       = $order_id \n";
		$Msg.= "------------------------------------------------------------\n\n";

		$Msg.= "http://scanepitaphe.fr\n\n";

		$Msg.= "Merci de votre confiance \n";


		//Envoi du message au client
		mail($customer_email , $Sujet, $Msg, 'From: contact@scanepitaphe.fr ');

		//On en profite pour s'envoyer ?galement le re?u
		mail('contact@scanepitaphe.fr ' , $Sujet, $Msg, 'From: contact@scanepitaphe.fr ');

		//Mise ? jour de la base de donn?es (si vous en utilisez)
		//Ici nous pouvons mettre ? jour la base de donn?es
		//puisque la transaction a r?ussie et le paiement a ?t? accept?
		//Vous connaissez la m?thode .. UPDATE... etc. etc.
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req = mysql_query('UPDATE orders SET active=1 WHERE id='.$order_id);
		$req2 = mysql_query("UPDATE orders SET transactid=$transaction_id WHERE id=$order_id");          // 3 
		mysql_close($db);
	}elseif($bank_response_code == "05"){
		//Mise ? jour de la base de donn?es (si vous en utilisez)
	//Ici nous supprimons la client page car le paiement est d?fectueux
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);

	}elseif($bank_response_code == "33"){
		//Mise ? jour de la base de donn?es (si vous en utilisez)
	//Ici nous supprimons la client page car le paiement est d?fectueux
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);

	}



	//--------------------------------------------------------------------------------


	//La transaction a r?ussi.
	//Quelque soit le r?sultat (paiement accept? ou refus?) , nous enregistrerons toutes les donn?es
	//Ceci nous fait une s?curit? de plus en cas de panne ou de litige avec le client
	//ou si aucun email n'a ?t? re?u ( ou message envoy? dans le dossier SPAM du logiciel de messagerie)
	//Si votre boutique d?bite pas mal, ce que je vous souhaite, vous penserez ? vider
	//r?guli?rement votre fichier de logs pour ne pas encombrer votre espace disque.
	fwrite( $fp, "#======================== Le : " . date("d/m/Y H:i:s") . " ====================#\n");
	fwrite( $fp, "merchant_id : $merchant_id\n");
	fwrite( $fp, "merchant_country : $merchant_country\n");
	fwrite( $fp, "amount : $amount\n");
	fwrite( $fp, "transaction_id : $transaction_id\n");
	fwrite( $fp, "transmission_date: $transmission_date\n");
	fwrite( $fp, "payment_means: $payment_means\n");
	fwrite( $fp, "payment_time : $payment_time\n");
	fwrite( $fp, "payment_date : $payment_date\n");
	fwrite( $fp, "response_code : $response_code\n");
	fwrite( $fp, "payment_certificate : $payment_certificate\n");
	fwrite( $fp, "authorisation_id : $authorisation_id\n");
	fwrite( $fp, "currency_code : $currency_code\n");
	fwrite( $fp, "card_number : $card_number\n");
	fwrite( $fp, "cvv_flag: $cvv_flag\n");
	fwrite( $fp, "cvv_response_code: $cvv_response_code\n");
	fwrite( $fp, "bank_response_code: $bank_response_code\n");
	fwrite( $fp, "complementary_code: $complementary_code\n");
	fwrite( $fp, "complementary_info: $complementary_info\n");
	fwrite( $fp, "return_context: $return_context\n");
	
	//ici on d?piote le caddie
	fwrite( $fp, "caddie : \n");
	fwrite( $fp, "----------- \n");

	for($i = 0 ; $i < count($arrayCaddie); $i++){
		fwrite( $fp, $arrayCaddie[$i] . "\n");
	}
	fwrite( $fp, "-------------------------------- \n");

	fwrite( $fp, "receipt_complement: $receipt_complement\n");
	fwrite( $fp, "merchant_language: $merchant_language\n");
	fwrite( $fp, "language: $language\n");
	fwrite( $fp, "customer_id: $customer_id\n");
	fwrite( $fp, "order_id: $order_id\n");
	fwrite( $fp, "customer_email: $customer_email\n");
	fwrite( $fp, "customer_ip_address: $customer_ip_address\n");
	fwrite( $fp, "capture_day: $capture_day\n");
	fwrite( $fp, "capture_mode: $capture_mode\n");
	fwrite( $fp, "data: $data\n");
	fwrite( $fp, "---------------------------------------------------------\n\n");

}

fclose($fp);
session_destroy();



?>
