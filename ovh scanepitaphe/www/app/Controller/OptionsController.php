<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class OptionsController extends AppController {

    public $helper = array('Html','Form','Session');
    public $components = array('Session','Paginator');
    public $scaffold = 'admin';
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('webtitle','webdesc','webword','limits');
    }

    public function webtitle(){
        $id=3;
        $title = $this->Option->findById($id);
    if ($this->request->is('requested')) {
        return $title;         
        } else {
            $this->set('title', $title);
        }       
    }
	
    public function admin_liste(){
        $this->_isAuthorized('admin');
        $options=$this->Option->find('all');
        $this->set('options', $options);
    }

    public function limits(){
        $id=11;
        $lim = $this->Option->findById($id);
    if ($this->request->is('requested')) {
        return $lim;         
        } else {
            $this->set('lim', $lim);
        }       
    }

    public function webdesc(){
        $id=9;
        $descr = $this->Option->findById($id);
    if ($this->request->is('requested')) {
        return $descr;         
        } else {
            $this->set('descr', $descr);
        }       
    }

    public function webword(){
        $id=10;
        $word = $this->Option->findById($id);
    if ($this->request->is('requested')) {
        return $word;         
        } else {
            $this->set('word', $word);
        }       
    }

    public function txtintro(){
        $id=7;
        $txtintro = $this->Option->findById($id);


    if ($this->request->is('requested')) {
        return $txtintro;         
        } else {
            $this->set('txtintro', $txtintro);
        }       
    }



    public function admin_edit ($id = null) {
        $this->_isAuthorized('admin');
        $this->layout = 'admin';
        if (!$id){
            throw new NotFoundException(__('Choix invalide'));
        }
        $fiche = $this->Option->findById($id);
        if (!$fiche){
            throw new NotFoundException(__('Choix invalide'));
        }
       
        if ($this->request->is(array('post','put'))) {
            $this->Option->$id = $id;
            if ($this->Option->save($this->request->data)) {
    
            return $this->redirect(array('action' => 'admin_liste'));
    }
            $this->Session->setFlash(__('Impossible de mettre à jour'),"default",array('class' => 'alert-box warning round'));
        }
        if (!$this->request->data) {
            $this->request->data = $fiche;
           
        }
        $this->set(compact('fiche'));
    }

    public function admin_add() {
    $this->layout = 'admin';
    if ($this->request->is('post')) {
        $this->Menu->create();
        if ($this->Menu->save($this->request->data)) {
          $id=$this->Menu->id;
  
 
            $this->Session->SetFlash(__('Menu ajouté'),"default",array('class' => 'alert-box success radius'));

        return $this->redirect(array('action' => 'admin_liste'));
    }
        $this->Session->setFlash(__('Impossible d\'ajouter menu'),"default",array('class' => 'alert-box warning round'));
    }
}

    public function admin_delete ($id = null) {
        $this->_isAuthorized('admin');
        if (!$id){
            throw new NotFoundException(__('Menu invalide'));
        }
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Menu->delete($id)) {
              
            $this->Session->setFlash(__('Le menu avec l\'id : %s a été supprimé.'), h($id),"default",array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller' => 'dashboards', 'action' => 'index','admin'=>true));
        }
    }

    public function view($id=null){
    $this->Option->recursive = 1;
    if (!$id){
                throw new NotFoundException(__('Option invalide'));
            }
        $options = $this->Option->findById($id);

        if($id==6){
            $this->layout = 'contact';
        }

        if (!$options) {
                throw new NotFoundException(__('Option invalide'));
            }
        $this->set(compact('options'));
    }

}