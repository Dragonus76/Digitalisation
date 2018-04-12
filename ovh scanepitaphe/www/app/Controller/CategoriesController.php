<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class CategoriesController extends AppController {

	public $helper = array('Html','Form','Session','Js');
	public $components = array('Paginator', 'Session','RequestHandler');
    public $scaffold = 'admin';

	public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('liste','getByPers','getByPersa');
    }

    public function getByPersa() {
        $id = $this->request->data['Album']['defunt_id'];
 
        $categories = $this->Category->find('list', array(
            'conditions' => array('Category.defunt_id' => $id),
            'recursive' => -1
            )); 
        $this->set('categories',$categories);
        $this->layout = 'ajax';
    }

    public function getByPers() {
        $id = $this->request->data['Media']['defunt_id'];
 
        $categories = $this->Category->find('list', array(
            'conditions' => array('Category.defunt_id' => $id),
            'recursive' => -1
            )); 
        $this->set('categories',$categories);
        $this->layout = 'ajax';
    }
	
    public function liste($id = null){
    	if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $cats=$this->Category->find('all',array(
    	'conditions'=>array('Category.defunt_id'=>$id),
    	));
    $this->loadModel('Defunt');
    $personne = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$id)
        ));
    $this->loadModel('User');
    $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->set(compact('personne','user','cats')); 
    }

    public function add($id = null){
    if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $this->loadModel('Defunt');
    $personne = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$id)
        ));
    $this->loadModel('DefuntUsers');
    $personnebis = $this->DefuntUsers->find('all',array(
        'conditions'=>array('DefuntUsers.defunt_id'=>$id)
        ));

    foreach ($personnebis as $key => $value) {
        if ($value['DefuntUsers']['user_id'] == $this->Auth->user('id')){
            $rght = 1;
        }
    }
    if($rght != 1){
        $this->Session->setFlash(__('Vous n\'avez pas les droits'),"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'users', 'action' => 'account'));         
    }
    $this->loadModel('User');
    $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->set(compact('personne','user')); 
    if (!empty($this->request->data)) {
        $this->request->data['Category']['user_id']=$this->Auth->user('id');
                if($this->Category->validates()){
                    if($this->Category->save($this->request->data))
                    {
                        
                        $this->Session->setFlash(__('Votre catégorie a bien été ajoutée'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'categories', 'action' => 'liste',$personne['Defunt']['id']));
                    }
                }
            }
    }

    public function addall(){
    $this->loadModel('Defunt');
    $personnes=array();
    $this->loadModel('DefuntUsers');
    $personnesbis = $this->DefuntUsers->find('all',array(
        'conditions'=>array('DefuntUsers.user_id'=>$this->Auth->user('id'))
        ));

    foreach ($personnesbis as $key => $value) {
        $per = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$value['DefuntUsers']['defunt_id'])
        ));
        array_push($personnes, $per);
    }
    if(empty($personnes)){
        $this->Session->setFlash(__('Vous devez commencer par ajouter une personne'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller' => 'users', 'action' => 'account'));         
    }
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
  
    $this->set(compact('personnes','user')); 
    if (!empty($this->request->data)) {
        $this->request->data['Category']['user_id']=$this->Auth->user('id');
                if($this->Category->validates()){
                    if($this->Category->save($this->request->data))
                    {
                        
                        $this->Session->setFlash(__('Votre catégorie a bien été ajoutée'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'categories', 'action' => 'liste',$this->request->data['Category']['defunt_id']));
                    }
                }
            }
    }


    public function edit($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $cat = $this->Category->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$cat['Category']['defunt_id'])
            ));
    if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($cat['Category']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }

    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    
        
    $this->set(compact('user','personne','cat'));


    if ($this->request->is(array('post', 'put'))) {
            $this->Category->id = $id;
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('Votre catégorie a bien été mise à jour'),"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'categories', 'action' => 'liste',$cat['Category']['defunt_id']));
            }
                    $this->Session->setFlash(__('Impossible de mettre à jour la catégorie'),"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Category->id = $cat['Category']['id'];
            $this->request->data = $this->Category->read();
    }        
            
    }

    public function delete($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $cat = $this->Category->findById($id);
    $this->loadModel('Defunt');
    $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$cat['Category']['defunt_id'])
            ));
    if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($cat['Category']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }

    
    if ($this->Category->delete($id)) {
        
        $this->Session->setFlash(__('La catégorie a bien été supprimée'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'categories','action'=>'liste',$cat['Category']['defunt_id']));
    }  
    }

    
}