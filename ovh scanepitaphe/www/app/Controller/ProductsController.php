<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class ProductsController extends AppController {
	public $helper = array('Html','Form','Session');
	public $components = array('Session');
	public $scaffold = 'admin';

	 public function beforeFilter(){
	    parent::beforeFilter();

	    $this->Auth->allow('cart','index','view','add_to_cart','delete_cart','empty_cart');
    }

    public function admin_add() {
		$this->Product->locale = Configure::read('Config.languages');

    	$this->_isAuthorized('admin');
    	$this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->Product->create();

			if ($this->Product->save($this->request->data, true, array('type','text','picture','sound','pdf','price','tva','nuplaod'))) {
				$extension=strtolower(pathinfo($this->request->data['Product']['thumbnail_file']['name'],PATHINFO_EXTENSION));
				if(
					!empty($this->request->data['Product']['thumbnail_file']['tmp_name']) &&
					in_array($extension,array('jpg','jpeg','png'))
				){

					move_uploaded_file($this->request->data['Product']['thumbnail_file']['tmp_name'], IMAGES.'products'.DS.$this->Product->id.'.'.$extension
					);
					$this->Product->saveField('thumbnail',$this->Product->id.'.'.$extension);
				}
			$this->Session->setFlash(__('Votre produit a bien été ajouté'),"default", array('class' => 'alert-box success radius'));
            return $this->redirect(array('controller'=>'products', 'action' => 'liste'));
			}
		$this->Session->setFlash(__('Impossible d\'ajouter le produit'),"default", array('class' => 'alert-box warning round'));
                        
		}
	}
	
	public function admin_liste() {
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		$this->Product->locale = Configure::read('Config.language');
		$products=$this->Product->find('all');

		if ($this->request->is('requested')) {
			return $products;
		} else {
			$this->set(compact('products'));
		}
	}

	public function admin_edit ($id = null) {
		$this->Product->locale = Configure::read('Config.languages');
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		if (!$id){
			throw new NotFoundException(__('Produit invalide'));
		}
		

		$product = $this->Product->findById($id);
		if (!$product){
			throw new NotFoundException(__('Produit invalide'));
		}
		if (!empty($this->request->data)) {
			$this->Product->$id = $id;
			if ($this->Product->save($this->request->data, true, array('type','text','picture','sound','pdf','price','tva','nuplaod'))) {
				$extension=strtolower(pathinfo($this->request->data['Product']['thumbnail_file']['name'],PATHINFO_EXTENSION));
					if(!empty($this->request->data['Product']['thumbnail_file']['tmp_name'])){
						if(in_array($extension,array('jpg','jpeg','png'))){
							move_uploaded_file($this->request->data['Product']['thumbnail_file']['tmp_name'], IMAGES.'products'.DS.$this->request->data['Product']['id'].'.'.$extension
		                	);
							$this->Product->saveField('thumbnail',$this->request->data['Product']['id'].'.'.$extension);
				            }else{
				            $this->Session->setFlash(__('Le format du fichier image n\'est pas adapté'),"default", array('class' => 'alert-box warning round'));
	    					$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
	    				}
	    			}else{
	    					$this->Session->setFlash(__('Impossible d\'ajouter une commande'),"default", array('class' => 'alert-box warning round'));
	   				}
				$this->Session->setFlash(__('Produit mis à jour'),"default", array('class' => 'alert-box success radius'));
	    		$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
	    	}else{
				$this->Session->setFlash(__('Impossible de mettre à jour le produit'),"default", array('class' => 'alert-box warning round'));			
			}
		}
		if (!$this->request->data) {
			$this->Product->id = $product['Product']['id'];
			$this->request->data = $this->Product->readAll();

		}
		$this->set(compact('product'));
	}

	public function admin_delete ($id = null) {
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		if (!$id){
			throw new NotFoundException(__('Produit invalide'));
		}
		$product = $this->Product->findById($id);
			
		if ($this->Product->delete($id)) {
			App::uses('File', 'Utility');
	        $file = new File(IMAGES . 'products'. DS . $product['Product']['thumbnail'], 0777);
	        $file->delete();
			$this->Session->setFlash(__('Produit supprimé'),"default", array('class' => 'alert-box success radius'));
	    	$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
		}else{
				$this->Session->setFlash(__('Impossible de supprimer le produit'),"default", array('class' => 'alert-box warning round'));			
				$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
			}
	}

		public function scanshop() {
		$this->Product->locale = Configure::read('Config.language');
			
		$products=$this->Product->find('all',array(	
        ));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
		if ($this->request->is('requested')) {
			return $products;
		} else {
			$this->set(compact('products','user'));
		}
	}

	public function view($id = null) {
		$this->Product->locale = Configure::read('Config.language');
		if (!$id) {
			throw new NotFoundException(__('ID invalide'));
		}
		$product = $this->Product->findById($id);
		if (!$product) {
			throw new NotFoundException(__('Produit invalide'));
		}
		$this->loadModel('Defunt');
    $personnes = $this->Defunt->find('all',array(
        'conditions'=>array('Defunt.user_id'=>$this->Auth->user('id'))
        ));
		$this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
		$this->set(compact('product','user','personnes'));
	}






     //pas mis à jour



	public function valpaiy(){
		 $this->Session->setFlash(__('Paiement accepté'));
		debug($this->Session->Read());
	}




}