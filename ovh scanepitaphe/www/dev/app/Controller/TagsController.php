<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class TagsController extends AppController {
    public $helper = array('Html','Form','Session');
    public $components = array('Paginator');



	public function index(){
    $this->Paginator->settings = array(
        'limit' => 10,
        'order' => array('Tag.name' => 'asc')
    );
    $tags=$this->Paginator->paginate('Tag');
    $this->set('tags', $tags);
}

	public function add() {
    if ($this->request->is('post')) {
        $this->Tag->create();
        if ($this->Tag->save($this->request->data)) {
            $this->Session->SetFlash('Tag ajouté',"default",array('class' => 'alert-box success radius'));
        return $this->redirect(array('action' => 'index'));
    }
        $this->Session->setFlash('Impossible d\'ajouter un tag',"default",array('class' => 'alert-box warning round'));
    }
}



	public function delete ($id = null) {
        if (!$id){
            throw new NotFoundException(__('Tag invalide'));
        }
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Tag->delete($id)) {
                $this->loadModel('TagsPost');
                $data = $this->TagsPost->find('all',array(
                    'conditions' => array('TagsPost.Category_id' =>$id)
                )); 
                foreach ($data as $key => $value) {
                    $this->TagsPost->delete($value['TagsPost']['Category_id']);
                }
                
            $this->Session->setFlash('Le tag a été supprimé.',"default",array('class' => 'alert-box success radius'));
        return $this->redirect(array('action' => 'index'));
        }
    }

public function edit ($id = null) {
        if (!$id){
            throw new NotFoundException(__('Tag invalide'));
        }
        $tag = $this->Tag->findById($id);
        if (!$tag){
            throw new NotFoundException(__('Tag invalide'));
        }
      
        if ($this->request->is(array('post','put'))) {
            $this->Tag->$id = $id;
            if ($this->Tag->save($this->request->data)) {
           
            return $this->redirect(array('action' => 'index'));
    }
            $this->Session->setFlash('Impossible de mettre à jour le tag',"default",array('class' => 'alert-box warning round'));
        }
        if (!$this->request->data) {
            

            $this->request->data = $tag;

            
        }
        $this->set(compact('tag'));
    }



}