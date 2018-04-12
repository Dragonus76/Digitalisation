<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class CommentsController extends AppController {

	public $helper = array('Html','Form','Session');
	public $components = array('Session');

	 public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('add','edit','delete','approuver','getcomments','getucomments');
    }
	
	public function index($id = null) {
		  if (!$id) {
        return false;
        }
        $comments = $this->Comment->find('all',array(
            'conditions'=>array('Comment.media_id'=>$id),
            'order' => array('Comment.created' => 'asc'),));
        if ($this->request->is('requested')) {
        return $comments;         
        } else {
            $this->set('comments', $comments);
        }  
	}

    public function add($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->loadModel('Media');
        $media=$this->Media->find('first',array(
            'conditions'=>array('Media.id'=>$this->request->data['Comment']['media_id'])));
        $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)));
        $this->loadModel('User');
        $userc=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$personne['Defunt']['user_id'])));
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        if ($this->request->is('post')) {
            $this->Comment->create();
            $this->Comment->set($this->request->data);
                if($this->Comment->validates()){
                    if ($this->Comment->save($this->request->data)) {
                        App::uses('CakeEmail', 'Network/Email');
            $CakeEmail = new CakeEmail('default');
            $CakeEmail->to($userc['User']['email']);
            $CakeEmail->from(array('contact@scanepitaphe.fr' => 'Scanepitaphe (no reply)'));
            $CakeEmail->subject('Nouveau commentaire : '.$media['Media']['name']);
            $CakeEmail->viewVars(array('user'=>$userc,'media'=>$media)
              
            );
            $CakeEmail->emailFormat('text');
            $CakeEmail->template('commentaire');
            $CakeEmail->send();
                        $this->Session->setFlash(__('Commentaire ajouté. En attente de modération.'));
                        return $this->redirect(array('controller'=>'clientpages','action'=>'view',$id));
                    }else{
                    $this->Session->setFlash(__('Unable to add your comment.'));
                    }
                }
        }
    }
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $comment = $this->Comment->findById($id);
        if (!$comment) {
            throw new NotFoundException(__('Invalid post'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Comment->id = $id;
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('Your comment has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to update your comment.'));
        }

        if (!$this->request->data) {
            $this->request->data = $comment;
        }
    }



    public function approuver($id = null){
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $comment = $this->Comment->findById($id);
        if (!$comment) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->loadModel('Media');
        $media=$this->Media->find('first',array(
            'conditions'=>array('Media.id'=>$comment['Comment']['media_id'])));
        $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])));
        $this->loadModel('User');
        $userc=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$personne['Defunt']['user_id'])));
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        if($user['User']['id'] != $userc['User']['id']){
            $this->Session->setFlash('Vous n\'avez pas les droits',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller' => 'media', 'action' => 'listvideo',$personne['Defunt']['id']));
        }


        if ($this->request->is(array('post', 'put'))) {
            $this->Comment->id = $id;

                $approbation = $this->Comment->field('approved');
                $this->set(compact('approbation'));

                if ($approbation == 0) {
                    if ($this->Comment->save($this->request->data) ) {
                        $this->Comment->save(array('approved' => 1));
                        $this->Session->setFlash('Commentaire approuvé',"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'media', 'action' => 'listvideo',$personne['Defunt']['id']));
       }
                } 

                if ($approbation == 1){
                    if ($this->Comment->save($this->request->data) ) {
                        $this->Comment->save(array('approved' => 0));
                        $this->Session->setFlash('Commentaire désapprouvé',"default", array('class' => 'alert-box warning round'));
                        return $this->redirect(array('controller' => 'media', 'action' => 'listvideo',$personne['Defunt']['id']));
     }
                }
            



                        $this->Session->setFlash('Impossible de changer le statut du commentaire',"default", array('class' => 'alert-box warning round'));
           
        }

        if (!$this->request->data) {
            $this->request->data = $comment;
        }
    }/*end action aprouver*/

     public function deleteb($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        $comment = $this->Comment->findById($id);
        if (!$comment) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->loadModel('Media');
        $media=$this->Media->find('first',array(
            'conditions'=>array('Media.id'=>$comment['Comment']['media_id'])));
        $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])));
        $this->loadModel('User');
        $userc=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$personne['Defunt']['user_id'])));
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        if($user['User']['id'] != $userc['User']['id']){
            $this->Session->setFlash('Vous n\'avez pas les droits',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller' => 'clientpages', 'action' => 'view',$personne['Defunt']['id']));
        }
        if ($this->Comment->delete($id)) {
            $this->Session->setFlash(
                __('Le commentaire avec id : %s a été supprimé.', h($id))
            );
                
                return $this->redirect(array('controller' => 'clientpages', 'action' => 'view',$personne['Defunt']['id']));

        }
    }

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        $comment = $this->Comment->findById($id);
        if (!$comment) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->loadModel('Media');
        $media=$this->Media->find('first',array(
            'conditions'=>array('Media.id'=>$comment['Comment']['media_id'])));
        $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])));
        $this->loadModel('User');
        $userc=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$personne['Defunt']['user_id'])));
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        if($user['User']['id'] != $userc['User']['id']){
            $this->Session->setFlash('Vous n\'avez pas les droits',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller' => 'media', 'action' => 'listvideo',$personne['Defunt']['id']));
        }
        if ($this->Comment->delete($id)) {
            $this->Session->setFlash(
                __('Le commentaire avec id : %s a été supprimé.', h($id))
            );
                
                return $this->redirect(array('controller' => 'media', 'action' => 'listvideo',$personne['Defunt']['id']));

        }
    }

    public function getcomments($id = null){
        if (!$id) {
        return false;
        }
        $comments = $this->Comment->find('all',array(
            'conditions'=>array('Comment.media_id'=>$id,'Comment.approved'=>1),
            'order' => array('Comment.created' => 'asc'),));
        if ($this->request->is('requested')) {
        return $comments;         
        } else {
            $this->set('comments', $comments);
        }    
    }

    public function getucomments($id = null){
        if (!$id) {
        return false;
        }
        $comment = $this->Comment->findById($id);
        if (!$comment) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->loadModel('Media');
        $media=$this->Media->find('first',array(
            'conditions'=>array('Media.id'=>$comment['Comment']['media_id'])));
        $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])));
        $this->loadModel('User');
        $userc=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$personne['Defunt']['user_id'])));
        if ($this->request->is('requested')) {
        return $userc;         
        } else {
            $this->set('userc', $userc);
        }    
    }



}