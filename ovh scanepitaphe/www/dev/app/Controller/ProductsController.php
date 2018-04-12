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
    	$this->_isAuthorized('admin');
    	$this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->Product->create();

			if ($this->Product->save($this->request->data)) {
				$extension=strtolower(pathinfo($this->request->data['Product']['thumbnail_file']['name'],PATHINFO_EXTENSION));
				if(
					!empty($this->request->data['Product']['thumbnail_file']['tmp_name']) &&
					in_array($extension,array('jpg','jpeg','png'))
				){

					move_uploaded_file($this->request->data['Product']['thumbnail_file']['tmp_name'], IMAGES.'products'.DS.$this->Product->id.'.'.$extension
					);
					$this->Product->saveField('thumbnail',$this->Product->id.'.'.$extension);
				}
			$this->Session->setFlash('Votre produit a bien été ajouté',"default", array('class' => 'alert-box success radius'));
            return $this->redirect(array('controller'=>'products', 'action' => 'liste'));
			}
		$this->Session->setFlash('Impossible d\'ajouter le produit',"default", array('class' => 'alert-box warning round'));
                        
		}
	}
	
	public function admin_liste() {
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		$products=$this->Product->find('all',array(
			'order' => array('Product.name' => 'asc'),
        ));
		if ($this->request->is('requested')) {
			return $products;
		} else {
			$this->set(compact('products'));
		}
	}

	public function admin_edit ($id = null) {
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		if (!$id){
			throw new NotFoundException('Produit invalide');
		}
		$product = $this->Product->findById($id);
		if (!$product){
			throw new NotFoundException('Produit invalide');
		}
		if ($this->request->is(array('post','put'))) {
			$this->Product->$id = $id;
			if ($this->Product->save($this->request->data)) {
				$extension=strtolower(pathinfo($this->request->data['Product']['thumbnail_file']['name'],PATHINFO_EXTENSION));
					if(!empty($this->request->data['Product']['thumbnail_file']['tmp_name'])){
						if(in_array($extension,array('jpg','jpeg','png'))){
							move_uploaded_file($this->request->data['Product']['thumbnail_file']['tmp_name'], IMAGES.'products'.DS.$this->request->data['Product']['id'].'.'.$extension
		                	);
							$this->Product->saveField('thumbnail',$this->request->data['Product']['id'].'.'.$extension);
				            }else{
				            $this->Session->setFlash('Le format du fichier image n\'est pas adapté',"default", array('class' => 'alert-box warning round'));
	    					$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
	    				}
	    			}else{
	    					$this->Session->setFlash('Impossible d ajouter une commande',"default", array('class' => 'alert-box warning round'));
	   				}
				$this->Session->setFlash('Produit mis à jour',"default", array('class' => 'alert-box success radius'));
	    		$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
	    	}else{
				$this->Session->setFlash('Impossible de mettre à jour le produit',"default", array('class' => 'alert-box warning round'));			
			}
		}
		if (!$this->request->data) {
			$this->Product->id = $product['Product']['id'];
			$this->request->data = $this->Product->read();

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
			$this->Session->setFlash('Produit supprimé',"default", array('class' => 'alert-box success radius'));
	    	$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
		}else{
				$this->Session->setFlash('Impossible de supprimer le produit',"default", array('class' => 'alert-box warning round'));			
				$this->redirect(array('controller' => 'products', 'action' => 'liste','admin'=>true));
			}
	}

		public function scanshop() {
		$products=$this->Product->find('all',array(
			'order' => array('Product.name' => 'asc'),
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
		if (!$id) {
			throw new NotFoundException(__('Produit invalide'));
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
		 $this->Session->setFlash('Paiement accepté');
		debug($this->Session->Read());
	}




}