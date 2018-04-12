<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
App::uses('AppController','Controller');
class FamiliesController extends AppController {
    public $helper = array('Html','Form','Session','QrCode');
    public $components = array('Session');
    public $scaffold = 'admin';

    public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('add','liste','edit');
    }


    public function add(){
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('user')); 

    	if (!empty($this->request->data)) {

                $id = $this->Auth->user('id');
                if($this->Family->validates()){

                    $this->Family->create(array(
                        'user_id' => $id,
                        'name' => $this->request->data['Family']['name'],
                        'description' => $this->request->data['Family']['description'],
                    ));
                    $this->Family->save();
                    
                    $this->Session->setFlash('Votre famille a été créée',"default", array('class' => 'alert-box success radius'));
                    return $this->redirect(array('controller'=>'users','action' => 'account'));
               }else{
                    $this->Session->setFlash('Merci de corriger vos erreurs',"default", array('class' => 'alert-box warning round'));
               }
            }
        
    }

    public function edit($id = null){
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('user')); 
        if($this->request->is('put') || $this->request->is('post')){
            if($this->Family->save($this->request->data)){
                $this->Session->setFlash("Les informations ont été modifiées","default", array('class' => 'alert-box success radius'));
                $this->redirect(array('controller'=>'users','action'=>'account'));
            } 
        }elseif($id){
            $this->Family->id = $id;
            $this->request->data = $this->Family->read();
        }
        $fam=$this->Family->findById($id);
        if($fam['Family']['user_id'] != $this->Auth->user('id')){
        $this->Session->setFlash('Vous n\'êtes pas le propriétaire de cette famille',"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    }

    public function stepone(){
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                $id = $this->Auth->user('id');
                $this->Family->create();
                if($this->Family->validates()){
                    $this->Family->create(array(
                        'user_id' => $id,
                        'name' => $this->request->data['Family']['name'],
                        'description' => $this->request->data['Family']['description'],
                    ));
                    $this->Family->save();
                    $this->Session->setFlash('Votre première famille a été créée',"default", array('class' => 'alert-box success radius'));
                    
                    return $this->redirect(array('controller'=>'defunts','action' => 'steptwo',$this->Family->id));
               }else{
                    $this->Session->setFlash('Merci de corriger vos erreurs',"default", array('class' => 'alert-box warning round'));
               }
            }
        }
    }

    public function liste(){
        $families=$this->Family->find('all',array(
            'conditions'=>array('Family.user_id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('families','user'));
    }

    public function delete($id = null){
        $family = $this->Family->findById($id);
        $this->set(compact('family'));
        if(!empty($this->request->data)){
            $this->loadModel('User');
            $user = $this->User->find('first',array(
                'conditions'=>array('User.id'=>$this->Auth->user('id'))));
            if($family['Family']['user_id'] != $this->Auth->user('id')){
                $this->Session->setFlash('Vous n\'êtes pas le propriétaire de cette famille',"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            if($this->Auth->password($this->request->data['Family']['password']) == $user['User']['password']){
               if ($this->Family->delete($id)) {
                    $this->Session->setFlash('La famille a bien été supprimée',"default", array('class' => 'alert-box success radius'));
                    return $this->redirect(array('controller'=>'users','action'=>'account'));
                }   
            }else{
                $this->Session->setFlash('Erreur de mot de passe. Suppression annulée.',"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller'=>'users','action'=>'account'));
            }
        }
        
    
    }

    public function editprinc($id = null){
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('user')); 
        if($this->request->is('put') || $this->request->is('post')){
            if($this->Family->save($this->request->data)){
                $this->Session->setFlash("Les informations ont été modifiées","default", array('class' => 'alert-box success radius'));
                $this->redirect(array('controller'=>'users','action'=>'account'));
            } 
        }elseif($id){
            $this->Family->id = $id;
            $this->request->data = $this->Family->read();
        }
        $fam=$this->Family->findById($id);
        if($fam['Family']['user_id'] != $this->Auth->user('id')){
        $this->Session->setFlash('Vous n\'êtes pas le propriétaire de cette famille',"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    }


}