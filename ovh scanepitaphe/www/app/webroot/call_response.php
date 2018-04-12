<!--
-------------------------------------------------------------
 Topic		: Exemple PHP traitement de la réponse de paiement
 Version 	: P615

	Dans cet exemple, les données de la transaction	sont
	décryptées et affichées sur le navigateur de l'internaute.

-------------------------------------------------------------
-->


<!--	Affichage du header html -->

<?php
session_name('CAKEPHP');
session_start();

	print ("<HTML><HEAD><TITLE>SOGENACTIF - Paiement Securise sur Internet</TITLE></HEAD>");
	print ("<BODY bgcolor=#ffffff>");
	print ("<Font color=#000000>");
	print ("<center><H1>Test de l'API plug-in SOGENACTIF</H1></center><br><br>");

	// Récupération de la variable cryptée DATA
	$message="message=$_POST[DATA]";
	
	// Initialisation du chemin du fichier pathfile (à modifier)
    //   ex :
    //    -> Windows : $pathfile="pathfile=c:/repertoire/pathfile";
    //    -> Unix    : $pathfile="pathfile=/home/repertoire/pathfile";
   
   $pathfile="pathfile=/homez.792/scanepit/www/app/webroot/payment/pathfile";

	// Initialisation du chemin de l'executable response (à modifier)
	// ex :
	// -> Windows : $path_bin = "c:/repertoire/bin/response";
	// -> Unix    : $path_bin = "/home/repertoire/bin/response";
	//

	$path_bin = "/homez.792/scanepit/www/app/webroot/payment/response";

	// Appel du binaire response
  	$message = escapeshellcmd($message);
	$result=exec("$path_bin $pathfile $message");


	//	Sortie de la fonction : !code!error!v1!v2!v3!...!v29
	//		- code=0	: la fonction retourne les données de la transaction dans les variables v1, v2, ...
	//				: Ces variables sont décrites dans le GUIDE DU PROGRAMMEUR
	//		- code=-1 	: La fonction retourne un message d'erreur dans la variable error


	//	on separe les differents champs et on les met dans une variable tableau

	$tableau = explode ("!", $result);

	//	Récupération des données de la réponse

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
	$complementary_info = $tableau[20];
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


	//  analyse du code retour

  if (( $code == "" ) && ( $error == "" ) )
 	{
  	print ('<br/><span style="text-align:center;">erreur appel response</span><br/>');
  	print ('executable response non trouve $path_bin');
 	}

	//	Erreur, affiche le message d'erreur

	else if ( $code != 0 ){
		print ('<span style="text-align:center;"><h2>Erreur appel API de paiement.</h2></span>');
		print ('<br/><br/><br/>');
		print (' message erreur : $error <br/>');
	}

	// OK, affichage des champs de la réponse
	else {

	
		
		//OK
	//Ici, la transaction s'est bien déroulée, mais cela ne veut pas dire pour autant que
	//le paiement a été accepté !

	//Paiement accepté = '00'
	//Référez-vous au Dictionnaire des données pour les numéros de réponse
	switch($bank_response_code){

	case "00" :
		print('<div style="width:100%;text-align:center;"><h1>Merci</h1>');
		print('<p>Votre paiement a été accepté par notre établissement bancaire</p>');
		print('<p>Un message électronique vous a été envoyé <br/>');
		print('il contient le reçu de la transaction et le détail de votre commande</p>');
		print('<p>Merci de votre confiance</p>');

		print('<p><a href="http://scanepitaphe.fr">Retourner à la boutique</p></div>');
		break;

	case "05" :
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);

		print("<p>Votre paiement a été refusé par votre établissement bancaire</p>");
		print('<p><a href="http://scanepitaphe.fr">Retourner à la boutique</p></div>');
				
		break;

	case "33" :
		
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);

		print("<p>La date de validité de votre carte bancaire est dépassée</p>");
		print('<p><a href="http://scanepitaphe.fr">Retourner à la boutique</p></div>');

		break;
	
	default : 
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);

		print("<p>La transaction n'a pu aboutir suite à un problème technique</p>");
		print('<p><a href="http://scanepitaphe.fr">Retourner à la boutique</p></div>');

}

switch($cvv_response_code){

	case "4E" :
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
		print('<p>Numéro de contrôle incorrect</p>');

		break;
	case "4D" :
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
		print('<p>Numéro de contrôle correct</p>');

		break;
	case "50" :
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
		print('<p>Numéro de contrôle non traité</p>');

		break;
	case "53" :
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
		print('<p>Le numéro de contrôle est absent de la demande d’autorisation</p>');

		break;
	case "55" :
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
		print('<p>La banque de l’internaute n’est pas certifiée, le contrôle n’a pu être effectué.</p>');

	case "NO" :
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);
		print('<p>Pas de cryptogramme sur la carte.</p>');

		break;


	
	//default : print("<p>La transaction n'a pu aboutir suite à un problème technique</p>");

}



	//Ici nous affichons un message dans le cas où l'internaute aurait cliqué
	//sur le bouton ANNULATION
	if($response_code == "17"){
		$db = mysql_connect('mysql51-111.perso', 'scanepitbdd1', 'q77Zj66dHG4Q');  // 1 
		mysql_select_db('scanepitbdd1',$db);                    // 2 
		$req3 = mysql_query('DELETE FROM client_pages WHERE order_id='.$order_id);
		$req4 = mysql_query('DELETE FROM orders WHERE id='.$order_id);
		mysql_close($db);

		print('<div style="width:100%;text-align:center;"><h1>Transaction annulée par l\'utilisateur</h1></div>');
		print('<p><a href="http://scanepitaphe.fr">Retourner à la boutique</p></div>');


	}

	# OK, affichage du mode DEBUG si activé
	// print (" $error <br>");
		
	// print("<center>\n");
	// print("<H3>R&eacute;ponse manuelle du serveur SOGENACTIF</H3>\n");
	// print("</center>\n");
	// print("<b><h4>\n");
	// print("<br><hr>\n");
	// print("<br>merchant_id : $merchant_id\n");
	// print("<br>merchant_country : $merchant_country\n");
	// print("<br>amount : $amount\n");
	// print("<br>transaction_id : $transaction_id\n");
	// print("<br>transmission_date: $transmission_date\n");
	// print("<br>payment_means: $payment_means\n");
	// print("<br>payment_time : $payment_time\n");
	// print("<br>payment_date : $payment_date\n");
	// print("<br>response_code : $response_code\n");
	// print("<br>payment_certificate : $payment_certificate\n");
	// print("<br>authorisation_id : $authorisation_id\n");
	// print("<br>currency_code : $currency_code\n");
	// print("<br>card_number : $card_number\n");
	// print("<br>cvv_flag: $cvv_flag\n");
	// print("<br>cvv_response_code: $cvv_response_code\n");
	// print("<br>bank_response_code: $bank_response_code\n");
	// print("<br>complementary_code: $complementary_code\n");
	// print("<br>complementary_info: $complementary_info\n");
	// print("<br>return_context: $return_context\n");
	// print("<br>caddie : $caddie\n");
	// print("<br>receipt_complement: $receipt_complement\n");
	// print("<br>merchant_language: $merchant_language\n");
	// print("<br>language: $language\n");
	// print("<br>customer_id: $customer_id\n");
	// print("<br>order_id: $order_id\n");
	// print("<br>customer_email: $customer_email\n");
	// print("<br>customer_ip_address: $customer_ip_address\n");
	// print("<br>capture_day: $capture_day\n");
	// print("<br>capture_mode: $capture_mode\n");
	// print("<br>data: $data\n");
	// print("<br>order_validity: $order_validity\n");
	// print("<br>transaction_condition: $transaction_condition\n");
	// print("<br>statement_reference: $statement_reference\n");
	// print("<br>card_validity: $card_validity\n");
	// print("<br>card_validity: $score_value\n");
	// print("<br>card_validity: $score_color\n");
	// print("<br>card_validity: $score_info\n");
	// print("<br>card_validity: $score_threshold\n");
	// print("<br>card_validity: $score_profile\n");
	// print("<br><br><hr></b></h4>");
}
print ("</body></html>");
session_destroy();


?>