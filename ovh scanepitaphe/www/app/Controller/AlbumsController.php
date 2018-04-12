<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class AlbumsController extends AppController {

	public $helper = array('Html','Form','Session','Js');
	public $components = array('Paginator', 'Session','RequestHandler');
    public $scaffold = 'admin';

	public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('liste','getByPers');
    }

    public function getByPers() {
        $id = $this->request->data['Media']['defunt_id'];
 
        $albums = $this->Album->find('list', array(
            'conditions' => array('Album.defunt_id' => $id),
            'recursive' => -1
            )); 
        $this->set('albums',$albums);
        $this->layout = 'ajax';
    }

    
	
    public function liste($id = null){
    	if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $albs=$this->Album->find('all',array(
    	'conditions'=>array('Album.defunt_id'=>$id),
    	));
    $this->loadModel('Defunt');
    $personne = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$id)
        ));
    $this->loadModel('User');
    $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->set(compact('personne','user','albs')); 
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
    $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id)
            ));
    $this->set(compact('personne','user','cats')); 
    if (!empty($this->request->data)) {
        $this->request->data['Album']['user_id']=$this->Auth->user('id');
        $this->Album->set($this->request->data);
                if($this->Album->validates()){
                    if($this->Album->save($this->request->data))
                    {
                        
                        $this->Session->setFlash(__('Votre album a bien été ajouté'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'albums', 'action' => 'liste',$personne['Defunt']['id']));
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
        return $this->redirect(array('controller' => 'defunts', 'action' => 'listeall',$this->Auth->user('id')));         
    }
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
  
    $this->set(compact('personnes','user')); 
    if (!empty($this->request->data)) {
        $this->request->data['Album']['user_id']=$this->Auth->user('id');
        $this->Album->set($this->request->data);
                if($this->Album->validates()){
                    if($this->Album->save($this->request->data))
                    {
                        
                        $this->Session->setFlash(__('Votre album a bien été ajouté'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'albums', 'action' => 'liste',$this->request->data['Album']['defunt_id']));
                    }
                }
            }
    }


    public function edit($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $alb = $this->Album->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$alb['Album']['defunt_id'])
            ));
    if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($alb['Album']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    
        
    $this->loadModel('Category');
    $cats = $this->Category->find('all',array(
        'conditions'=>array('Category.defunt_id'=>$alb['Album']['defunt_id'])
            ));

    $this->set(compact('user','personne','alb','cats')); 
         
    if ($this->request->is(array('post', 'put'))) {
            $this->Album->id = $id;
            if ($this->Album->save($this->request->data)) {
                $this->Session->setFlash(__('Votre album a bien été mis à jour'),"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'albums', 'action' => 'liste',$alb['Album']['defunt_id']));
            }
                    $this->Session->setFlash(__('Impossible de mettre à jour l\'album'),"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Album->id = $alb['Album']['id'];
            $this->request->data = $this->Album->read();
    }        
      
    }

    public function delete($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $alb = $this->Album->findById($id);
   
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$alb['Album']['defunt_id'])
            ));
    if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($alb['Album']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    if ($this->Album->delete($id)) {
        
        $this->Session->setFlash(__('L\'album a bien été supprimé'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'albums','action'=>'liste',$alb['Album']['defunt_id']));
    }  
    }

    
}