<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class CheckoutsController extends AppController {
	public $helper = array('Html','Form','Session');
	public $components = array('Session');
	public $scaffold = 'admin';

	 public function beforeFilter(){
	    parent::beforeFilter();

	    $this->Auth->allow();
    }

    public function custom($id = null){
        $this->Checkout->locale = Configure::read('Config.language');
    	$this->layout = 'custom';
    	if (!$id) {
			throw new NotFoundException(__('Produit invalide'));
		}
		$this->loadModel('Product');
		$product = $this->Product->findById($id);
		if (!$product) {
			throw new NotFoundException(__('Produit invalide'));
		}
      
        if($this->Session->check('Custom')){
            $this->Session->delete('Custom');
        }

        $arraytmp = array_merge($this->Product->read(null, $id),$this->request->data['Checkout']);
        $this->Session->write('Custom',$arraytmp);

    	
    	if(!empty($this->request->data)){
    	$vars = $this->request->data;
    	$this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $extension=strtolower(pathinfo($this->request->data['Checkout']['picture_file']['name'],PATHINFO_EXTENSION));
		if(
					!empty($this->request->data['Checkout']['picture_file']['tmp_name']) &&
					in_array($extension,array('jpg'))
				){

					App::uses('Folder', 'Utility');
                    App::uses('File', 'Utility');
                    $dir = new Folder();
                    $dir->create(IMAGES.'medias/defunts/defunt_'.$this->request->data['Checkout']['defunt_id'].'/tmp', 0777);
                    $imagupsize = getimagesize($this->request->data['Checkout']['picture_file']['tmp_name']);
					
					move_uploaded_file($this->request->data['Checkout']['picture_file']['tmp_name'], IMAGES.'medias/defunts/defunt_'.$this->request->data['Checkout']['defunt_id'].'/tmp/upload.'.$extension);
					

				    if(!empty($this->request->data['Checkout']['content'])){
					$textToConvert = $this->request->data['Checkout']['content'];
                    }else{
                       $textToConvert=' '; 
                    }
					$font   = 45;
					putenv('GDFONTPATH=' . realpath('.'));
                    $font_file = "Arial";
					$width  = ImageFontWidth($font) * strlen($textToConvert) *4;
					$height = ImageFontHeight($font) * 40;
					$im = @imagecreate ($width,$height);
                    imagesavealpha($im, true);
                    imagealphablending($im, false);
                    $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
                    imagefill($im, 0, 0, $white);
                    $lime = imagecolorallocate($im, 204, 255, 51);
					$text_color = imagecolorallocate ($im, 255, 255,255);//and of course black text
            
					imagefttext($im, $font,0,0,$font,$text_color,$font_file,$textToConvert);


					//imagestring ($im, $font, 0, 0,  $textToConvert, $text_color);
					imagepng($im,IMAGES.'medias/defunts/defunt_'.$this->request->data['Checkout']['defunt_id'].'/tmp/texte.png');
					
					$this->set(compact('imagupsize','user'));
				
		}else{
			$this->Session->setFlash(__('Vous n\'avez pas choisi de photo ou la photo n\'est pas au format .jpg'),"default", array('class' => 'alert-box warning rounds'));
        return $this->redirect(array('controller'=>'checkouts','action'=>'cart'));
		}
    	$this->set(compact('vars','user'));

    }else{
        $this->Session->setFlash(__('Erreur dans le panier'),"default", array('class' => 'alert-box warning rounds'));
        return $this->redirect(array('controller'=>'products','action'=>'scanshop'));
    }
    }

    	public function add_to_cart($id = null){
            $this->Checkout->locale = Configure::read('Config.language');
		if (!$id) {
			throw new NotFoundException(__('Produit invalide'));
		}
		$this->loadModel('Product');
        $this->Product->locale = Configure::read('Config.language');
		$product = $this->Product->findById($id);
		if (!$product) {
			throw new NotFoundException(__('Produit invalide'));
		}

        $productsInCart = $this->Session->read('Cart');
        $alreadyIn = false;
        if (!$alreadyIn) {
            $amount = count($productsInCart);
            $this->Session->write('Cart.' . $amount, $this->Product->read(null, $id));
            $this->Session->write('Counter', $amount + 1);
            $this->Session->setFlash(__('Produit ajouté au panier'),"default", array('class' => 'alert-box success radius'));
	    	
        } else {
            $this->Session->setFlash(__('Produit est déjà dans le panier'));
        }
        return $this->redirect(array('controller' => 'checkouts', 'action' => 'cart'));
	}

	public function cart() {
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $cart = array();

        if ($this->Session->check('Cart')) {
            $cart = $this->Session->read('Cart');

        }

        $this->set(compact('cart','user'));
    }

    public function delete_cart($id = null) {
        if (is_null($id)) {
            throw new NotFoundException(__('Requête invalide'));
        }
        if ($this->Session->delete('Cart.' . $id)) {
            $cart = $this->Session->read('Cart');
            sort($cart);
            $this->Session->write('Cart', $cart);
            $this->Session->write('Counter', count($cart));
            $this->Session->setFlash(__('Le produit a été enlevé du panier'),"default", array('class' => 'alert-box success radius'));
	    	
        }
        return $this->redirect(array('controller' => 'checkouts', 'action' => 'cart'));
    }

    public function empty_cart() {
        $this->Session->delete('Cart');
        $this->Session->delete('Counter');
        $this->Session->setFlash(__('Votre panier a été vidé.'),"default", array('class' => 'alert-box success radius'));   	
        $this->redirect(array('controller' => 'products', 'action' => 'scanshop'));
    }



    public function getByCountry() {
        $id = $this->request->data['Order']['dcountry'];
 		$france = array('France','Monaco','Andorre');

        $zone1 = array('Allemagne','Autriche','Belgique','Bulgarie','Chypre','Croatie','Danemark','Espagne','Estonie','Finlande','Grèce','Hongrie','Irlande','Italie','Lettonie','Lituanie','Luxembourg','Malte','Pays-Bas','Pologne','Portugal','République tchèque','Roumanie','Royaume-Uni','Slovaquie','Slovénie','Suède','Suisse');
 		$usa = array('Etats-Unis');
 		if(in_array($id, $france)){
 			$zone = 'France';
 		}elseif(in_array($id, $zone1)){
 			$zone = 'Europe zone 1';
 		}elseif(in_array($id, $usa)){
 			$zone = 'Etats Unis';
 		}else{
 			$zone = 'Europe zone 2 et 3';
 		}
 		$this->loadModel('Delivery');
 		$deliveries = $this->Delivery->find('all',array(
 			'conditions' => array('Delivery.zone'=>$zone)));

 		
 
        $this->set('deliveries',$deliveries);
        $this->layout = 'ajax';
    }

    public function checkout1(){
        $this->loadModel('Product');
         $this->Product->locale = Configure::read('Config.language');
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Defunt');
        $personnes=$this->Defunt->find('all',array(
            'conditions'=>array('Defunt.user_id'=>$this->Auth->user('id')
                )));
        
        $pays = array(  '0' => '',
                        'France' => 'France',
                        'Monaco' => 'Monaco',
                        'Andorre' => 'Andorre',
                        'Allemagne' => 'Allemagne',
                        'Autriche' => 'Autriche',
                        'Belgique' => 'Belgique',
                        'Bulgarie' => 'Bulgarie',
                        'Chypre' => 'Chypre',
                        'Croatie' => 'Croatie',
                        'Danemark' => 'Danemark',
                        'Espagne' => 'Espagne',
                        'Estonie' => 'Estonie',
                        'Finlande' => 'Finlande',
                        'Grèce' => 'Grèce',
                        'Hongrie' => 'Hongrie',
                        'Irlande' => 'Irlande',
                        'Italie' => 'Italie',
                        'Lettonie' => 'Lettonie',
                        'Lituanie' => 'Lituanie',
                        'Luxembourg' => 'Luxembourg',
                        'Malte' => 'Malte',
                        'Pays-Bas' => 'Pays-Bas',
                        'Pologne' => 'Pologne',
                        'Portugal' => 'Portugal',
                        'République tchèque' => 'République tchèque',
                        'Roumanie' => 'Roumanie',
                        'Royaume-Uni' => 'Royaume-Uni',
                        'Slovaquie' => 'Slovaquie',
                        'Slovénie' => 'Slovénie',
                        'Suède' => 'Suède',
                        'Suisse' => 'Suisse',

                        'Etats-Unis' => 'Etats-Unis'
                        );
        $cart = $this->Session->read('Cart');
        $this->set(compact('user','personnes','pays','cart'));
        if(!empty($this->request->data)){
            if ($this->request->is('post')) {
                if (
                    empty($this->request->data['Order']['uname']) 
                    ||
                    empty($this->request->data['Order']['ufirstname'])
                    ||
                    empty($this->request->data['Order']['ustreet'])
                    ||
                    empty($this->request->data['Order']['uzipcode'])
                    ||
                    empty($this->request->data['Order']['ucity']) 
                    ||
                    empty($this->request->data['Order']['ucountry'])                      
                    ){
        $this->Session->setFlash(__('Vous n\'avez pas renseigné toutes vos coordonnées.'),"default", array('class' => 'alert-box warning round'));       
                return $this->redirect(array('controller'=>'checkouts','action' => 'checkout1'));

                }
                $this->Session->write('Order', $this->request->data);
                return $this->redirect(array('controller'=>'checkouts','action' => 'checkout2'));
            }
        }
    }

    public function checkout2(){
       	$this->loadModel('Product');
         $this->Product->locale = Configure::read('Config.language');
    	$this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Defunt');
        $personnes=$this->Defunt->find('all',array(
        	'conditions'=>array('Defunt.user_id'=>$this->Auth->user('id')
        		)));
        $cart = $this->Session->read('Cart');
        $order = $this->Session->read('Order');

        $this->set(compact('user','personnes'));
    	if(!empty($this->request->data)){
    		if ($this->request->is('post')) {
                if($this->request->data['Order']['accord']==1){
                    $this->Session->write('OrderS',$this->request->data['Order']);
                }else{//cas où les cgv et cgu n'ont pas été coché
				$this->Session->setFlash(__('Erreur. Vérifier si vous avez accepté les CGV et CGU.'),"default", array('class' => 'alert-box success radius'));
 				return $this->redirect(array('controller'=>'checkouts', 'action' => 'checkout2'));
		          }	    		

                    App::uses('Paypal', 'Paypal.Lib');
                    $this->Paypal = new Paypal(array(
                        'sandboxMode' => false,
                        'nvpUsername' => 'contact_api1.scanepitaphe.fr',
                        'nvpPassword' => 'QVJP4ZV5U9247H3G',
                        'nvpSignature' => 'Agr0uVnXVSOb-0jaz7QMMJ1Vv-2tAezz53Dm82oDGmuQh5hVsx4Dpiyz'
                    ));
                    // $this->Paypal = new Paypal(array(
                    //     'sandboxMode' => true,
                    //     'nvpUsername' => 'sell_api1.scanepitaphe.fr',
                    //     'nvpPassword' => 'NWUX2R253H4H9AGY',
                    //     'nvpSignature' => 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AjRtM764udPmveCWVD24GYZpaVV.'
                    // ));
                    
                    foreach ($cart as $key => $value) {
                       $item[$key]['name']=$value['Product']['name'];
                       $item[$key]['description']=$value['Product']['content'];
                       $item[$key]['tax']=$value['Product']['tva']*$value['Product']['price'];
                       $item[$key]['subtotal']=$value['Product']['price'];
                    }
                    
                    if(!empty($this->request->data['Order']['livraison'])){
                    $shipval = $this->request->data['Order']['livraison'];
                    }else{$shipval = 0;}

                    $ship=array('name'=>'Frais de livraison','description'=>'Frais de livraison','tax'=>0, 'subtotal'=>$shipval);
                    array_push($item, $ship);
                     
                    $orderp = array(
                            'description' => 'Votre commande Scanépitaphe',
                            'currency' => 'EUR',
                            'return' => 'http://scanepitaphe.fr/checkouts/review',
                            'cancel' => 'http://scanepitaphe.fr/checkouts/cancel',
                            'items' => $item,
                    );
                     
                    try {                        
                        $this->redirect($this->Paypal->setExpressCheckout($orderp));
                    } catch (Exception $e) {
                        // $e->getMessage();
                    } 

	    	}else{//fin if POST
	    		$this->Session->setFlash(__('Impossible d\'ajouter une commande'));//erreur si ce n'est pas de type post
	    	}
	    }
		$listproducts = '';

		$listprices = '';

    	$this->set(compact('cart','listproducts','listprices','order'));
    }


    public function review(){
        $orderp=array();
        $this->loadModel('Product');
         $this->Product->locale = Configure::read('Config.language');
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Defunt');
        $personnes=$this->Defunt->find('all',array(
            'conditions'=>array('Defunt.user_id'=>$this->Auth->user('id')
                )));

        $this->set(compact('user','personnes'));

        $token=$_GET['token'];
        $PayerID=$_GET['PayerID'];
        $cart = $this->Session->read('Cart');
        $ordersession = $this->Session->read('OrderS');
        $order = $this->Session->read('Order');
  
        App::uses('Paypal', 'Paypal.Lib');
       $this->Paypal = new Paypal(array(
                            'sandboxMode' => false,
                            'nvpUsername' => 'contact_api1.scanepitaphe.fr',
                            'nvpPassword' => 'QVJP4ZV5U9247H3G',
                            'nvpSignature' => 'Agr0uVnXVSOb-0jaz7QMMJ1Vv-2tAezz53Dm82oDGmuQh5hVsx4Dpiyz'
                        ));
       // $this->Paypal = new Paypal(array(
       //                  'sandboxMode' => true,
       //                  'nvpUsername' => 'sell_api1.scanepitaphe.fr',
       //                  'nvpPassword' => 'NWUX2R253H4H9AGY',
       //                  'nvpSignature' => 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AjRtM764udPmveCWVD24GYZpaVV.'
       //              ));

        try {
            $this->Paypal->getExpressCheckoutDetails($token);
        } catch (Exception $e) {
            // $e->getMessage();
        }         
        
        if(!empty($cart)){
            foreach ($cart as $key => $value) {
               $item[$key]['name']=$value['Product']['name'];
               $item[$key]['description']=$value['Product']['content'];
               $item[$key]['tax']=$value['Product']['tva']*$value['Product']['price'];
               $item[$key]['subtotal']=$value['Product']['price'];
            }
        }else{
            $this->Session->setFlash(__('Erreur de session. Vous n\'avez pas été débité.'),"default", array('class' => 'alert-box warning rounds'));
            return $this->redirect(array('contorller'=>'products','action'=>'scanshop'));
        }

        if(!empty($ordersession)){
            if(!empty($ordersession['livraison'])){
                $shipval = $ordersession['livraison'];
            }else{$shipval = 0;}
        }else{
            $this->Session->setFlash(__('Erreur de session. Vous n\'avez pas été débité.'),"default", array('class' => 'alert-box warning rounds'));
            return $this->redirect(array('contorller'=>'products','action'=>'scanshop'));
        }
        
        $ship=array('name'=>'Frais de livraison','description'=>'Frais de livraison','tax'=>0, 'subtotal'=>$shipval);
        array_push($item, $ship);
         
        $orderp = array(
            'description' => 'Votre commande Scanépitaphe',
            'currency' => 'EUR',
            'return' => 'http://scanepitaphe.fr/checkouts/review',
            'cancel' => 'http://scanepitaphe.fr/checkouts/cancel',
            'items' => $item,            
        );
                   
        try {
            $this->Paypal->doExpressCheckoutPayment($orderp, $token, $PayerID); 
        } catch (PaypalRedirectException $e) {
            $this->redirect($e->getMessage());
        } catch (Exception $e) {
            // $e->getMessage();
        }

        if($this->Paypal->doExpressCheckoutPayment($orderp, $token, $PayerID)['ACK']=='SuccessWithWarning' || $this->Paypal->doExpressCheckoutPayment($orderp, $token, $PayerID)['ACK']=='Success'){
            // Envoi du mail de confirmation
            App::uses('CakeEmail', 'Network/Email');
            $CakeEmail = new CakeEmail('default');
            $CakeEmail->to($user['User']['email']);
            $CakeEmail->from(array('contact@scanepitaphe.fr' => 'Scanepitaphe (no reply)'));
            $CakeEmail->subject(__('Confirmation de votre achat Scanepitaphe (à conserver)'));
            $CakeEmail->viewVars(
                $user['User'] +
                array(
                    // 'token' => $token,
                    'id' => $user['User']['id'],

                )
            );
            $CakeEmail->emailFormat('text');
            $CakeEmail->template('confirmation');
            $CakeEmail->send();
             // fin envoi du mail 

             // Envoi du mail de confirmation pour Scanstel
            App::uses('CakeEmail', 'Network/Email');
            $CakeEmail = new CakeEmail('default');
            $CakeEmail->to('contact@scanepitaphe.fr');
            $CakeEmail->from(array('contact@scanepitaphe.fr' => 'Site Scanepitaphe'));
            $CakeEmail->subject('Nouvelle commande');
            
            $CakeEmail->emailFormat('text');
            $CakeEmail->template('new');
            $CakeEmail->send();
             // fin envoi du mail activation

            
            //Définition du code pour la référence de la commande           
            $zop = $user['User']['id'].date("dmY").date("Hi");
            //Définition de la référence de la commande
            $ref = 'ref'.$zop;
            //envoi des informations dans la table order
            $this->loadModel('Order');
            if(!empty($order['Order']['dcountry'])){
                $this->Order->create(array(
                'user_id'=> $user['User']['id'],
                'date'=> date("dmY").date("Hi"),
                'dname' => $order['Order']['dname'],
                'dfirstname' => $order['Order']['dfirstname'],
                'dstreet' => $order['Order']['dstreet'],
                'dzipcode' => $order['Order']['dzipcode'],
                'dcity' => $order['Order']['dcity'],
                'dcountry' => $order['Order']['dcountry'],
                'dphone' => $order['Order']['dphone'],
                'listproduct' => $ordersession['listproduct'],
                'listprice' => $ordersession['listprice'],
                'reference' => $ref,
                'cleref'=>$zop,
                'uname' => $order['Order']['uname'],
                'ufirstname' => $order['Order']['ufirstname'],
                'ustreet' => $order['Order']['ustreet'],
                'uzipcode' => $order['Order']['uzipcode'],
                'ucity' => $order['Order']['ucity'],
                'ucountry' => $order['Order']['ucountry'],
                'uphone' => $order['Order']['uphone'],
                'tva' => $ordersession['tva'],
                'ttc' => $ordersession['ttc'],
                'ht' => $ordersession['ht'],
                'accord' => $ordersession['accord'],
                'livraison' => $ordersession['livraison'],
                'statut' => 'Payé',
                'physique'=>1,
                'transactid' => $this->Paypal->doExpressCheckoutPayment($orderp, $token, $PayerID)['PAYMENTINFO_0_TRANSACTIONID']

                ));
                }else{
                $this->Order->create(array(
                    'user_id'=> $user['User']['id'],
                    'date'=> date("dmY").date("Hi"),
                    'listproduct' => $ordersession['listproduct'],
                    'listprice' => $ordersession['listprice'],
                    'reference' => $ref,
                    'cleref'=>$zop,
                    'uname' => $order['Order']['uname'],
                    'ufirstname' => $order['Order']['ufirstname'],
                    'ustreet' => $order['Order']['ustreet'],
                    'uzipcode' => $order['Order']['uzipcode'],
                    'ucity' => $order['Order']['ucity'],
                    'ucountry' => $order['Order']['ucountry'],
                    'uphone' => $order['Order']['uphone'],
                    'tva' => $ordersession['tva'],
                    'ttc' => $ordersession['ttc'],
                    'ht' => $ordersession['ht'],
                    'accord' => $ordersession['accord'],
                    'statut' => 'Payé',
                    'transactid' => $this->Paypal->doExpressCheckoutPayment($orderp, $token, $PayerID)['PAYMENTINFO_0_TRANSACTIONID']
                ));  
                }                
                $this->Order->save();
              
                $order_id = $this->Order->id;

                foreach ($cart as $key => $value) {
                    if($value['Product']['nupload'] == 'true'){  
                               
                    App::uses('Folder', 'Utility');
                    App::uses('File', 'Utility');   

                    $file = new File(IMAGES.'medias/defunts/defunt_'.$value['defunt_id'].'/tmp/toprint&'.$value['defunt_id'].'.jpg');

                        if ($file->exists()) {
                            $dirt = new Folder();
                            $dirt->create(IMAGES . 'orders'. DS .'order_'.$order_id.DS.$key, 0777);
                            $tmpfile = explode('&', $file->name);
                            $defid=explode('.', $tmpfile['1']);
                            
                            $file->copy(IMAGES . 'orders'. DS .'order_'.$order_id.DS.$key . DS . $value['Product']['name'].'&'.$defid[0].'.jpg');
                            $file->delete();
                            $del = new Folder(IMAGES.'medias/defunts/defunt_'.$value['defunt_id'].'/tmp');
                            $del->delete();
                        }


                    }
                }

    
            foreach ($cart as $key => $value) {
                if(!empty($value['Product']['picture'])){
                    $this->loadModel('Limit');
                    $limit = $this->Limit->find('first',array(
                        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
                        ));
                    $img = $limit['Limit']['picture'];
                    $this->Limit->id = $limit['Limit']['id'];
                    $this->Limit->saveField('picture',$img+$value['Product']['picture']);
                }
                if(!empty($value['Product']['sound'])){
                    $this->loadModel('Limit');
                    $limit = $this->Limit->find('first',array(
                        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
                        ));
                    $son = $limit['Limit']['sound'];
                    $this->Limit->id = $limit['Limit']['id'];
                    $this->Limit->saveField('sound',$son+$value['Product']['sound']);
                }
                if(!empty($value['Product']['text'])){
                    $this->loadModel('Limit');
                    $limit = $this->Limit->find('first',array(
                        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
                        ));
                    $txt = $limit['Limit']['text'];
                    $this->Limit->id = $limit['Limit']['id'];
                    $this->Limit->saveField('text',$txt+$value['Product']['text']);
                }
                if(!empty($value['Product']['pdf'])){
                    $this->loadModel('Limit');
                    $limit = $this->Limit->find('first',array(
                        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
                        ));
                    $pdf = $limit['Limit']['pdf'];
                    $this->Limit->id = $limit['Limit']['id'];
                    $this->Limit->saveField('pdf',$pdf+$value['Product']['pdf']);
                }

                $this->Session->delete('Cart');
                $this->Session->delete('Order');
                $this->Session->delete('OrderS');

            }

        }   
    }


    public function cancel(){
        $this->Session->delete('Cart');
        $this->Session->delete('Order');
        $this->Session->delete('OrderS');
        $orderp=array();
        $this->loadModel('Product');
         $this->Product->locale = Configure::read('Config.language');
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Defunt');
        $personnes=$this->Defunt->find('all',array(
            'conditions'=>array('Defunt.user_id'=>$this->Auth->user('id')
                )));
            $this->Session->setFlash(__('Erreur dans le processus de paiement. Vous n\'avez pas été débité.'),"default", array('class' => 'alert-box warning rounds'));

        $this->set(compact('user','personnes'));
    }

    public function merge(){
        $productsInCart = $this->Session->read('Cart');
        $custom = $this->Session->read('Custom');

        if(empty($custom)){
            $this->Session->setFlash(__('Erreur dans la création de l\'image'),"default", array('class' => 'alert-box warning rounds'));
            return $this->redirect(array('controller'=>'products','action'=>'scanshop'));
        }

        $amount = count($productsInCart);
        $this->Session->write('Cart.' . $amount,$custom );
        $this->Session->write('Counter', $amount + 1);       
        $this->Session->delete('Custom');


        $res = json_decode(stripslashes($_POST['jsondata']), true);

        if(empty($res)){
            $this->Session->setFlash(__('Erreur dans la création de l\'image'),"default", array('class' => 'alert-box warning rounds'));
            return $this->redirect(array('controller'=>'products','action'=>'scanshop'));
        }
    /* get data */
    $count_images = count($res['images']);
    /* the background image is the first one */

    $background     = $res['images'][0]['src'];
    $photo1         = imagecreatefromjpeg($background);
    $foto1W         = imagesx($photo1);
    $foto1H         = imagesy($photo1);
    $photoFrameW    = $res['images'][0]['width'];
    $photoFrameH    = $res['images'][0]['height'];
    $photoFrame     = imagecreatetruecolor($photoFrameW,$photoFrameH);
    imagecopyresampled($photoFrame, $photo1, 0, 0, 0, 0, $photoFrameW, $photoFrameH, $foto1W, $foto1H);

    /* the other images */
    for($i = 1; $i < $count_images; ++$i){
        $insert         = $res['images'][$i]['src'];
        $photoFrame2Rotation = (180-$res['images'][$i]['rotation']) + 180;
 
        $photo2         = imagecreatefrompng($insert);
        
        $foto2W         = imagesx($photo2);
        $foto2H         = imagesy($photo2);
        $photoFrame2W   = $res['images'][$i]['width']*3.690625;
        $photoFrame2H   = $res['images'][$i]['height']*3.6917;

        $photoFrame2TOP = $res['images'][$i]['top']*3.6917;
        $photoFrame2LEFT= $res['images'][$i]['left']*3.690625;

        $photoFrame2    = imagecreatetruecolor($photoFrame2W,$photoFrame2H);
        $trans_colour   = imagecolorallocatealpha($photoFrame2, 0, 0, 0, 127);
        imagefill($photoFrame2, 0, 0, $trans_colour);

        imagecopyresampled($photoFrame2, $photo2, 0, 0, 0, 0, $photoFrame2W, $photoFrame2H, $foto2W, $foto2H);
        
        $photoFrame2    = imagerotate($photoFrame2,$photoFrame2Rotation, -1,0);
        /*after rotating calculate the difference of new height/width with the one before*/
        $extraTop       =(imagesy($photoFrame2)-$photoFrame2H)/2;
        $extraLeft      =(imagesx($photoFrame2)-$photoFrame2W)/2;

        imagecopy($photoFrame, $photoFrame2,$photoFrame2LEFT-$extraLeft, $photoFrame2TOP-$extraTop, 0, 0, imagesx($photoFrame2), imagesy($photoFrame2));    
    }
     imagejpeg($photoFrame, IMAGES.'medias/defunts/defunt_'.$custom['defunt_id'].'/tmp/toprint&'.$custom['defunt_id'].'.jpg');
     return $this->redirect('http://scanepitaphe.fr/checkouts/cart');

    }



}