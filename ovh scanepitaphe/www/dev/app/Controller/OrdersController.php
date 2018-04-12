<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class OrdersController extends AppController {

	public $helper = array('Html','Form','Session','QrCode');
	public $components = array('Session');
	public $scaffold = 'admin';

	public function beforeFilter(){
		//parent::beforeFilter();
		$this->Auth->allow();
	}
	
	//action pour lister les Commandes
	public function admin_index() {
        $this->_isAuthorized('admin');
		$this->layout = 'admin';
		$orderlist = $this->Order->find('all', array('order'=>array('Order.created'=> 'desc')));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
		$this->set(compact('orderlist','user'));

	}

    public function admin_view($id = null){
        $this->_isAuthorized('admin');
        $this->layout = 'admin';
        if (!$id) {
            throw new NotFoundException(__('Commande invalide'));
        }
        $order = $this->Order->findById($id);
        if (!$order) {
            throw new NotFoundException(__('Commande invalide'));
        }

        App::uses('Folder', 'Utility');
        $dir = new Folder(IMAGES . 'orders'. DS .'order_'.$id);
        $files = $dir->findRecursive('.*\.jpg', true);
        foreach ($files as $key => $value) {

                App::uses('File', 'Utility');
                $fil = new File($value);
                $link['Image']=$value;
                $filname['Filname'] = $fil->name();
                $prodalone = explode("&",$fil->name());

                $this->loadModel('Defunt');
                $personne=$this->Defunt->find('first',array(
                    'conditions'=>array('Defunt.id'=>$prodalone[1])
                    ));
                $this->loadModel('Product');
                $prd['Product']= $prodalone[0];
                
                 $array[$key]=array_merge($filname,$link,$personne,$prd);
                 
        }

        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $client_id=$order['Order']['user_id'];
        $client=$this->User->findById($client_id);
        
        if (!empty($this->request->data)) {
            $this->request->data['Order']['id'] = $id;
                if($this->Order->validates()){
                    if($this->Order->save($this->request->data)){
                        $this->Order->saveField('statut','livré');
                        if(!empty($client['User']['email'])){
                            App::uses('CakeEmail', 'Network/Email');
                            $CakeEmail = new CakeEmail('default');
                            $CakeEmail->to($client['User']['email']);
                            $CakeEmail->from(array('contact@scanepitaphe.fr' => 'Scanepitaphe (no reply)'));
                            $CakeEmail->subject('Votre colis est en cours de livraison');
                            $CakeEmail->viewVars(array('colissimo'=>$this->request->data['Order']['colissimo']) );
                            $CakeEmail->emailFormat('text');
                            $CakeEmail->template('livraison');
                            $CakeEmail->send();
                            $this->Session->setFlash("Numéro Colissimo enregistré. Email envoyé au client","default", array('class' => 'alert-box success radius'));
                            }else{
                        $this->Session->setFlash("Numéro Colissimo enregistré. Pas d\'email envoyé au client","default", array('class' => 'alert-box success radius'));
                                
                            }
                    }
                }
        }else{
            $this->Order->id = $id;
            $this->request->data = $this->Order->read();
        }


        $this->set(compact('order','user','array'));
    }

 public function admin_pview($id = null){
    $this->_isAuthorized('admin');
        $this->layout = 'padmin';
        if (!$id) {
            throw new NotFoundException(__('Commande invalide'));
        }
        $order = $this->Order->findById($id);
        if (!$order) {
            throw new NotFoundException(__('Commande invalide'));
        }
        App::uses('Folder', 'Utility');
        $dir = new Folder(IMAGES . 'orders'. DS .'order_'.$id);
        $files = $dir->findRecursive('.*\.jpg', true);
        foreach ($files as $key => $value) {
                App::uses('File', 'Utility');
                $fil = new File($value);
                $link['Image']=$value;
                $filname['Filname'] = $fil->name();
                $prodalone = explode("&",$fil->name());
                $this->loadModel('Defunt');
                $personne=$this->Defunt->find('first',array(
                    'conditions'=>array('Defunt.id'=>$prodalone[1])
                    ));
                $this->loadModel('Product');
                // $prd=$this->Product->find('first',array(
                //     'conditions'=>array('Product.id'=>$prodalone[0])
                //     ));
                $prd['Product']= $prodalone[0];
                
                 $array[$key]=array_merge($filname,$link,$personne,$prd);
                 
        }

        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('order','user','array'));
    }

    public function myorder() {
         $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Defunt');
        $personnes=$this->Defunt->find('all',array(
            'conditions'=>array('Defunt.user_id'=>$this->Auth->user('id')
                )));


        $orderlist = $this->Order->find('all', array(
            'order'=>array('Order.created'=> 'desc'),
            'conditions'=>array('Order.user_id'=>$this->Auth->user('id'))
            ));
        $this->loadModel('User');

        $this->set(compact('orderlist','user','personnes'));

    }

    public function view($id = null){
    
 
        if (!$id) {
            throw new NotFoundException(__('Commande invalide'));
        }
        $order = $this->Order->findById($id);
        if (!$order) {
            throw new NotFoundException(__('Commande invalide'));
        }
        App::uses('Folder', 'Utility');
        $dir = new Folder(IMAGES . 'orders'. DS .'order_'.$id);
        $files = $dir->findRecursive('.*\.jpg', true);
        foreach ($files as $key => $value) {

                App::uses('File', 'Utility');
                $fil = new File($value);
                $link['Image']=$value;
                $filname['Filname'] = $fil->name();
                $prodalone = explode("&",$fil->name());

                $this->loadModel('Defunt');
                $personne=$this->Defunt->find('first',array(
                    'conditions'=>array('Defunt.id'=>$prodalone[1])
                    ));
                $this->loadModel('Product');
                $prd['Product']= $prodalone[0];
                
                 $array[$key]=array_merge($filname,$link,$personne,$prd);
                 
        }

        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('order','user','array'));
    }

 public function pview($id = null){
  
        $this->layout = 'padmin';
        if (!$id) {
            throw new NotFoundException(__('Commande invalide'));
        }
        $order = $this->Order->findById($id);
        if (!$order) {
            throw new NotFoundException(__('Commande invalide'));
        }
        App::uses('Folder', 'Utility');
        $dir = new Folder(IMAGES . 'orders'. DS .'order_'.$id);
        $files = $dir->findRecursive('.*\.jpg', true);
        foreach ($files as $key => $value) {
                App::uses('File', 'Utility');
                $fil = new File($value);
                $link['Image']=$value;
                $filname['Filname'] = $fil->name();
                $prodalone = explode("&",$fil->name());
                $this->loadModel('Defunt');
                $personne=$this->Defunt->find('first',array(
                    'conditions'=>array('Defunt.id'=>$prodalone[1])
                    ));
                $this->loadModel('Product');
                // $prd=$this->Product->find('first',array(
                //     'conditions'=>array('Product.id'=>$prodalone[0])
                //     ));
                $prd['Product']= $prodalone[0];
                
                 $array[$key]=array_merge($filname,$link,$personne,$prd);
                 
        }

        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('order','user','array'));
    }

    //pas mis à jour

	//action pour supprimer une commande
	public function admin_delete ($id = null) {
        $this->_isAuthorized('admin');
		if (!$id){
			throw new NotFoundException(__('Commande invalide'));
		}
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Order->delete($id)) {
			$this->Session->setFlash(__('La commande avec l id : %s a été supprimé.', h($id)));
		return $this->redirect(array('controller' => 'orders', 'action' => 'index','admin'=>true));
		}
	}

	public function admin_sendFilepng($file) {
        $this->_isAuthorized('admin');
	$filen = '/webroot/img/clientspages/clientpage_'.$file.DS.'background_'.$file.'.png';
    $this->response->file( $filen, array('download'=>true, 'name'=>'background_'.$file.'.png') );
    return $this->response;
	}



	public function admin_sendFile($file,$name) {
        $this->_isAuthorized('admin');
	$filen = '/webroot/img/defunts/defunt_'.$file.'/qrcode_'.$file.'.png';
	$this->response->file( $filen, array('download'=>true, 'name'=>'qrcode_'.$name.'.png') );
     return $this->response;
	}

	public function sendFilejpg($order,$key,$file,$name) {
        $this->_isAuthorized('admin' || 'fournisseur');
	$filen = 'webroot/img/orders/order_'.$order.DS.$key.DS.$file.'.jpg';
    $this->response->file( $filen, array('download'=>true, 'name'=>$file.'_'.$name.'.jpg') );
     return $this->response;
	}

	public function admin_sendFilejpeg($file) {
        $this->_isAuthorized('admin' || 'fournisseur');
	$filen = '/webroot/img/clientspages/clientpage_'.$file.DS.'background_'.$file.'.jpeg';
    $this->response->file( $filen, array('download'=>true, 'name'=>'background_'.$file.'.jpeg') );
     return $this->response;
	}

     public function admin_sendFilejpegsupp($file,$fileb) {
        $this->_isAuthorized('admin');
    $filen = '/webroot/img/clientspages/clientpage_'.$file.DS.'plaque_supp'.DS.$fileb;
    $this->response->file( $filen, array('download'=>true, 'name'=>'background_supp'.$file.'.jpeg') );
     return $this->response;
    }



	public function admin_sendFilepdf($file) {
        $this->_isAuthorized('admin');
	$filen = '/webroot/img/orders/order_'.$file.DS.'ref'.$file.'.pdf';
    $this->response->file( $filen, array('download'=>true, 'name'=>'ref_'.$file.'.pdf') );
     return $this->response;
	}

	//action pour générer pdf
	function viewPdf($ref = null){ 
        if (!$ref) 
        { 
            $this->Session->setFlash('Désolé, numero de commande invalide.'); 
            $this->redirect(array('action'=>'index'), null, true); 
        } 
       
        // $id = intval($id); 

        $property = $this->Order->findByCleref($ref);// here the data is pulled from the database and set for the view 
         
        if (empty($property)) 
        { 
            $this->Session->setFlash('Désolé, erreur de propriété.'); 
            $this->redirect(array('action'=>'index'), null, true); 
        } 


        $this->layout = 'pdf'; //this will use the pdf.ctp layout 
        $this->set(compact('property'));
        
    } 

    public function admin_approuver($id = null){
        $this->_isAuthorized('admin');
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $order = $this->Order->findById($id);
        if (!$order) {
            throw new NotFoundException(__('Invalid post'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Order->id = $id;

                $approbation = $this->Order->field('active');
                $this->set(compact('approbation'));

                if ($approbation == 0) {
                    if ($this->Order->save($this->request->data) ) {
                        $this->Order->save(array('active' => 1));
                        $this->Session->setFlash(__('Commande payée'));
                        return $this->redirect(array('action' => 'index'));
                    }
                } 

                if ($approbation == 1){
                    if ($this->Order->save($this->request->data) ) {
                        $this->Order->save(array('active' => 0));
                        $this->Session->setFlash(__('Commande impayée'));
                        return $this->redirect(array('action' => 'index'));
                    }
                }
            



            $this->Session->setFlash(__('Impossible de mettre à jour la commande'));
        }

        if (!$this->request->data) {
            $this->request->data = $order;
        }
    }/*end action aprouver*/

    public function fournisseurindex() {
        if ($this->Auth->user('role') != 'fournisseur') {
                 $this->Session->setFlash("Vous n'avez pas les droits","default", array('class' => 'alert-box warning round'));
                 $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin'=>false));
            }
        $this->layout = 'fournisseur';
        $orderlist = $this->Order->find('all', array(
            'order'=>array('Order.created'=> 'desc'),
            'conditions'=>array('Order.physique'=>1)
            ));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('orderlist','user'));

    }

    public function fournisseurview($id = null){
                if ($this->Auth->user('role') != 'fournisseur') {
                 $this->Session->setFlash("Vous n'avez pas les droits","default", array('class' => 'alert-box warning round'));
                 $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home','admin'=>false));
            }
        $this->layout = 'fournisseur';
        if (!$id) {
            throw new NotFoundException(__('Commande invalide'));
        }
        $order = $this->Order->findById($id);
        if (!$order) {
            throw new NotFoundException(__('Commande invalide'));
        }
        App::uses('Folder', 'Utility');
        $dir = new Folder(IMAGES . 'orders'. DS .'order_'.$id);
        $files = $dir->findRecursive('.*\.jpg', true);
        foreach ($files as $key => $value) {

                App::uses('File', 'Utility');
                $fil = new File($value);
                $link['Image']=$value;
                $filname['Filname'] = $fil->name();
                $prodalone = explode("&",$fil->name());

                $this->loadModel('Defunt');
                $personne=$this->Defunt->find('first',array(
                    'conditions'=>array('Defunt.id'=>$prodalone[1])
                    ));
                $this->loadModel('Product');
                $prd['Product']= $prodalone[0];
                
                 $array[$key]=array_merge($filname,$link,$personne,$prd);
                 
        }

        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        if (!empty($this->request->data)) {
            $this->request->data['Order']['id'] = $id;
                if($this->Order->validates()){
                    if($this->Order->save($this->request->data)){
                        $this->Order->saveField('statut','livré');

                    $this->Session->setFlash("Numéro Colissimo enregistré","default", array('class' => 'alert-box success radius'));

                    }
                }
        }else{
            $this->Order->id = $id;
            $this->request->data = $this->Order->read();
        }
        $this->set(compact('order','user','array'));
    }

 public function fournisseurpview($id = null){
            if ($this->Auth->user('role') != 'fournisseur') {
                 $this->Session->setFlash("Vous n'avez pas les droits","default", array('class' => 'alert-box warning round'));
                 $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home','admin'=>false));
            }
        $this->layout = 'pfournisseur';
        if (!$id) {
            throw new NotFoundException(__('Commande invalide'));
        }
        $order = $this->Order->findById($id);
        if (!$order) {
            throw new NotFoundException(__('Commande invalide'));
        }
        App::uses('Folder', 'Utility');
        $dir = new Folder(IMAGES . 'orders'. DS .'order_'.$id);
        $files = $dir->findRecursive('.*\.jpg', true);
        foreach ($files as $key => $value) {
                App::uses('File', 'Utility');
                $fil = new File($value);
                $link['Image']=$value;
                $filname['Filname'] = $fil->name();
                $prodalone = explode("&",$fil->name());
                $this->loadModel('Defunt');
                $personne=$this->Defunt->find('first',array(
                    'conditions'=>array('Defunt.id'=>$prodalone[1])
                    ));
                $this->loadModel('Product');
                // $prd=$this->Product->find('first',array(
                //     'conditions'=>array('Product.id'=>$prodalone[0])
                //     ));
                $prd['Product']= $prodalone[0];
                
                 $array[$key]=array_merge($filname,$link,$personne,$prd);
                 
        }

        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('order','user','array'));
    }

}