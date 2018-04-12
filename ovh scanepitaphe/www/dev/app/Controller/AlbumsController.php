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
	    $this->Auth->allow('liste');
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
        throw new NotFoundException(__('Invalid post'));
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
        throw new NotFoundException(__('Invalid post'));
    }
    $this->loadModel('Defunt');
    $personne = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$id)
        ));
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
        $this->Album->set($this->request->data);
                if($this->Album->validates()){
                    if($this->Album->save($this->request->data))
                    {
                        
                        $this->Session->setFlash('Votre album a bien été ajouté',"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'albums', 'action' => 'liste',$personne['Defunt']['id']));
                    }
                }
            }
    }

    public function addall(){
    $this->loadModel('Defunt');
    $personnes = $this->Defunt->find('all',array(
        'conditions'=>array('Defunt.user_id'=>$this->Auth->user('id'))
        ));
    if(empty($personnes)){
        $this->Session->setFlash('Vous devez commencer par ajouter une personne',"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller' => 'defunts', 'action' => 'listeall',$this->Auth->user('id')));         
    }
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
  
    $this->set(compact('personnes','user')); 
    if (!empty($this->request->data)) {
        $this->Album->set($this->request->data);
                if($this->Album->validates()){
                    if($this->Album->save($this->request->data))
                    {
                        
                        $this->Session->setFlash('Votre album a bien été ajouté',"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'albums', 'action' => 'liste',$this->request->data['Album']['defunt_id']));
                    }
                }
            }
    }


    public function edit($id = null){
    $alb = $this->Album->findById($id);
    if ($this->request->is(array('post', 'put'))) {
            $this->Album->id = $id;
            if ($this->Album->save($this->request->data)) {
                $this->Session->setFlash('Votre album a bien été mis à jour',"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'albums', 'action' => 'liste',$alb['Album']['defunt_id']));
            }
                    $this->Session->setFlash('Impossible de mettre à jour l\'album',"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Album->id = $alb['Album']['id'];
            $this->request->data = $this->Album->read();
    }        
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$alb['Album']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')){
        $this->Session->setFlash('Vous n\'êtes pas le propriétaire de cet album',"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    $this->loadModel('Category');
    $cats = $this->Category->find('all',array(
        'conditions'=>array('Category.defunt_id'=>$alb['Album']['defunt_id'])
            ));

    $this->set(compact('user','personne','alb','cats'));        
    }

    public function delete($id = null){
    $alb = $this->Album->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$alb['Album']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')){
        $this->Session->setFlash('Vous n\'êtes pas le propriétaire de cette catégorie',"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    if ($this->Album->delete($id)) {
        
        $this->Session->setFlash('L\'album a bien été supprimé',"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'albums','action'=>'liste',$alb['Album']['defunt_id']));
    }  
    }

    
}