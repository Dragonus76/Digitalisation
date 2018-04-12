<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class DeliveriesController extends AppController {
	public $helper = array('Html','Form','Session');
	public $components = array('Session');
	public $scaffold = 'admin';

	 public function beforeFilter(){
	    parent::beforeFilter();

	    $this->Auth->allow();
    }

    public function admin_add(){
    	$this->_isAuthorized('admin');
    	$this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->Delivery->create();

			if ($this->Delivery->save($this->request->data)) {
				$this->Session->setFlash('Votre mode de livraison a bien été ajouté',"default", array('class' => 'alert-box success radius'));
	            return $this->redirect(array('controller'=>'deliveries', 'action' => 'liste'));
			}
			$this->Session->setFlash('Impossible d\'ajouter le mode de livraison',"default", array('class' => 'alert-box warning round'));                
		}
    }

    public function admin_liste() {
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		$deliveries=$this->Delivery->find('all',array(
			'order' => array('Delivery.name' => 'asc'),
        ));
		if ($this->request->is('requested')) {
			return $deliveries;
		} else {
			$this->set(compact('deliveries'));
		}
	}

public function admin_edit ($id = null) {
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		if (!$id){
			throw new NotFoundException('Mode de livraison invalide');
		}
		$delivery = $this->Delivery->findById($id);
		if (!$delivery){
			throw new NotFoundException('Mode de livraison invalide');
		}
		if ($this->request->is(array('post','put'))) {
			$this->Delivery->$id = $id;
			if ($this->Delivery->save($this->request->data)) {
				
				$this->Session->setFlash('Mode de livraison mis à jour',"default", array('class' => 'alert-box success radius'));
	    		$this->redirect(array('controller' => 'deliveries', 'action' => 'liste','admin'=>true));
	    	}else{
				$this->Session->setFlash('Impossible de mettre à jour le mode de livraison',"default", array('class' => 'alert-box warning round'));			
			}
		}
		if (!$this->request->data) {
			$this->Delivery->id = $delivery['Delivery']['id'];
			$this->request->data = $this->Delivery->read();

		}
		$this->set(compact('delivery'));
	}

	public function admin_delete ($id = null) {
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		if (!$id){
			throw new NotFoundException(__('Mode de livraison invalide'));
		}
		$delivery = $this->Delivery->findById($id);
			
		if ($this->Delivery->delete($id)) {
			$this->Session->setFlash('Mode de livraison supprimé',"default", array('class' => 'alert-box success radius'));
	    	$this->redirect(array('controller' => 'deliveries', 'action' => 'liste','admin'=>true));
		}else{
				$this->Session->setFlash('Impossible de supprimer le mode de livraison',"default", array('class' => 'alert-box warning round'));			
				$this->redirect(array('controller' => 'deliveries', 'action' => 'liste','admin'=>true));
			}
	}


}