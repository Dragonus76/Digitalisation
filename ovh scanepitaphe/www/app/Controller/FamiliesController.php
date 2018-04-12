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
                    $this->loadModel('FamilyUsers');
                        $this->FamilyUsers->create(array(
                            'family_id'=>$this->Family->id,
                            'user_id'=>$this->Auth->user('id')
                            ));
                        $this->FamilyUsers->save();
                    $this->Session->setFlash(__('Votre famille a été créée'),"default", array('class' => 'alert-box success radius'));
                    return $this->redirect(array('controller'=>'users','action' => 'account'));
               }else{
                    $this->Session->setFlash(__('Merci de corriger vos erreurs'),"default", array('class' => 'alert-box warning round'));
               }
            }
        
    }

    public function edit($id = null){
        if (!$id) {
            throw new NotFoundException(__('Erreur id'));
        }
        $fam=$this->Family->findById($id);
        if($fam['Family']['user_id'] != $this->Auth->user('id')){
        $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de cette famille'),"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('user')); 
        if($this->request->is('put') || $this->request->is('post')){
            if($this->Family->save($this->request->data)){
                $this->Session->setFlash(__('Les informations ont été modifiées'),"default", array('class' => 'alert-box success radius'));
                $this->redirect(array('controller'=>'users','action'=>'account'));
            } 
        }elseif($id){
            $this->Family->id = $id;
            $this->request->data = $this->Family->read();
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
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
        $family = $this->Family->findById($id);
        $this->set(compact('family'));
        if(!empty($this->request->data)){
            $this->loadModel('User');
            $user = $this->User->find('first',array(
                'conditions'=>array('User.id'=>$this->Auth->user('id'))));
            if($family['Family']['user_id'] != $this->Auth->user('id')){
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de cette famille'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            if($this->Auth->password($this->request->data['Family']['password']) == $user['User']['password']){
               if ($this->Family->delete($id)) {
                    $this->loadModel('Defunt');
                    $defs = $this->Defunt->find('all',array(
                        'conditions'=>array('Defunt.family_id'=>$id)));
                    foreach ($defs as $key => $value) {
                        $idd = $value['Defunt']['id'];
                        App::uses('Folder', 'Utility');
                        $folder = new Folder( IMAGES.'medias/defunts/'.'defunt_'.$idd);
                        $folder->delete();
                        $this->loadModel('DefuntUsers');
                        $link = $this->DefuntUsers->find('first',array(
                                'conditions'=>array('DefuntUsers.defunt_id'=>$idd)
                            ));
                        $this->DefuntUsers->delete($link['DefuntUsers']['id']);

                        $this->loadModel('ClientPage');
                        $clientpage = $this->ClientPage->find('first',array(
                                'conditions'=>array('ClientPage.defunt_id'=>$idd)
                            ));
                        $this->ClientPage->delete($clientpage['ClientPage']['id']);
                    if ($this->Defunt->delete($idd)) {
                        $this->loadModel('Media');
                        $medias=$this->Media->find('all',array(
                            'conditions'=>array('Media.defunt_id'=>$idd)));
                        foreach ($medias as $key => $value) {
                            $this->Media->delete($value['Media']['id']);
                        }
                        $this->loadModel('Album');
                        $albs=$this->Album->find('all',array(
                            'conditions'=>array('Album.defunt_id'=>$idd)));
                        foreach ($albs as $key => $value) {
                            $this->Album->delete($value['Album']['id']);
                        }
                        $this->loadModel('Category');
                        $cats=$this->Category->find('all',array(
                            'conditions'=>array('Category.defunt_id'=>$idd)));
                        foreach ($cats as $key => $value) {
                            $this->Category->delete($value['Category']['id']);
                        }
                        $this->loadModel('DefuntUsers');
                        $userd=$this->DefuntUsers->find('all',array(
                            'conditions'=>array('DefuntUsers.defunt_id'=>$idd)));
                        foreach ($userd as $key => $value) {
                            $this->DefuntUsers->delete($value['DefuntUsers']['id']);
                        }
                    }
                    }
                    $this->loadModel('FamilyUsers');
                    $link = $this->FamilyUsers->find('all',array(
                        'conditions'=>array('family_id'=>$id)
                        ));
                     foreach ($link as $key => $value) {
                         $this->FamilyUsers->delete($value['FamilyUsers']['id']);
                     }
                        
                    $this->Session->setFlash(__('La famille a bien été supprimée'),"default", array('class' => 'alert-box success radius'));
                    return $this->redirect(array('controller'=>'users','action'=>'account'));
                }   
            }else{
                $this->Session->setFlash(__('Erreur de mot de passe. Suppression annulée.'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller'=>'users','action'=>'account'));
            }
        }
        
    
    }

    public function editprinc($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('user')); 
        if($this->request->is('put') || $this->request->is('post')){
            if($this->Family->save($this->request->data)){
                $this->Session->setFlash(__('Les informations ont été modifiées'),"default", array('class' => 'alert-box success radius'));
                $this->redirect(array('controller'=>'users','action'=>'account'));
            } 
        }elseif($id){
            $this->Family->id = $id;
            $this->request->data = $this->Family->read();
        }
        $fam=$this->Family->findById($id);
        $this->loadModel('FamilyUsers');
        $famuser = $this->FamilyUsers->find('all',array(
            'conditions'=>array('FamilyUsers.family_id'=>$id)));
        foreach ($famuser as $key => $value) {
            if($value['FamilyUsers']['user_id'] == $this->Auth->user('id')){
                $right=1;
            }
        }
        if($right != 1){
        $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de cette famille'),"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    }

    public function getbyid($id = null){
        $family = $this->Family->find('first',array(
            'conditions'=>array('Family.id'=>$id)
            ));
        if ($this->request->is('requested')) {
            return $family;         
            } else {
                $this->set('family', $family);
            } 
    }

}