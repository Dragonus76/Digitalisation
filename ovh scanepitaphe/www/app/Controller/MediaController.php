<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class MediaController extends AppController {

    public $helper = array('Js','Html','Form','Session','Media'=> array('pathPrefix'=>'img'));
    public $components = array('Paginator', 'Session','RequestHandler');

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('getcover');
    }



public function addtexte() {
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
    $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
   
    $this->set(compact('personnes','user','limit')); 
    if (!empty($this->request->data)) {
        $this->request->data['Media']['user_id']=$this->Auth->user('id');

        $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->Media->save($this->request->data))
                    {
                        $txt = $limit['Limit']['text'];
                        $this->Limit->id = $limit['Limit']['id'];
                        $this->Limit->saveField('text',$txt-1);
                        $this->Session->setFlash(__('Votre texte a bien été ajouté'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'media', 'action' => 'listtext',$this->request->data['Media']['defunt_id']));
                    }
                }
            }
}

public function addtexteind($id = null) {
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
    $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    $this->loadModel('Category');
    $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id)
            ));
    $this->set(compact('personne','user','limit','cats'));  
    if (!empty($this->request->data)) {
        $this->request->data['Media']['user_id']=$this->Auth->user('id');
        $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->Media->save($this->request->data))
                    {
                       
                        $txt = $limit['Limit']['text'];
                        $this->Limit->id = $limit['Limit']['id'];
                        $this->Limit->saveField('text',$txt-1);
                        $this->Session->setFlash(__('Votre texte a bien été ajouté'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'media', 'action' => 'listtext',$personne['Defunt']['id']));
                    }
                }
            }
}
       

    public function listtext($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)
            ));
    if($personne['Defunt']['user_id'] == $this->Auth->user('id')){
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typetext'),
        ));
    }else{
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typetext','Media.user_id'=>$this->Auth->user('id')),
        ));
    }
   
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    $this->set(compact('medias','id','user','personne','limit'));
       } 

    public function edittext($id = null){
    if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }

    $media = $this->Media->findById($id);
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('Defunt');
    $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
    if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    if ($this->request->is(array('post', 'put'))) {
            $this->Media->id = $id;
            if ($this->Media->save($this->request->data)) {
                $this->Session->setFlash(__('Votre texte a bien été mis à jour'),"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'media', 'action' => 'listtext',$media['Media']['defunt_id']));
            }
                    $this->Session->setFlash(__('Impossible de mettre à jour le texte'),"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Media->id = $media['Media']['id'];
            $this->request->data = $this->Media->read();
    }        
    
    $this->loadModel('Category');
    $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$media['Media']['defunt_id'])
            ));
    $this->loadModel('MediaTag');
        $this->Media->recursive = 1;
        $tmp = $this->Media->findById($id);

        $d['tags'] = $tmp['Tag'];
        $this->set($d);
    $this->set(compact('user','personne','media','cats'));        
    }

    public function deletetext($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
    if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    if ($this->Media->delete($id)) {
        $txt = $limit['Limit']['text'];
        $this->Limit->id = $limit['Limit']['id'];
        $this->Limit->saveField('text',$txt+1);
        $this->Session->setFlash(__('Le texte a bien été supprimé'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'media','action'=>'listtext',$media['Media']['defunt_id']));
    }  
    }

    public function listeimage($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)
            ));
    if($personne['Defunt']['user_id'] == $this->Auth->user('id')){
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typeimage'),
        ));
    }else{
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typeimage','Media.user_id'=>$this->Auth->user('id')),
        ));
    }
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    $this->set(compact('medias','id','user','personne','limit'));
       } 

    public function addimage(){
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
        $this->loadModel('Limit');
        $limit = $this->Limit->find('first',array(
            'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
            ));

        $this->set(compact('personnes','user','limit')); 
        if (!empty($this->request->data)) {
            $this->request->data['Media']['user_id']=$this->Auth->user('id');
            $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->request->data['Media']['nomfichier_url']['error'] != 4){
                    if($this->Media->save($this->request->data))
                    {
                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
                                if ($this->request->data['Media']['nomfichier_url']['error'] <= 0){
                                    if ($this->request->data['Media']['nomfichier_url']['size'] <= 6097152){
                                        $ImageNews = $this->request->data['Media']['nomfichier_url']['name'];
                                        $ExtensionPresumee = explode('.', $ImageNews);
                                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                                            $ImageNews = getimagesize($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                                $ImageChoisie = imagecreatefromjpeg($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                                $TailleImageChoisie = getimagesize($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                                $NouvelleLargeur = 1000; //Largeur choisie à 150 px mais modifiable

                                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                                imagedestroy($ImageChoisie);
                                                $ImageNews = $this->request->data['Media']['nomfichier_url']['name'];
                                                $NomImageChoisie = explode('.', $ImageNews);
                                                $NomImageExploitable = $ImageNews;
                                    
                                                $nomdate = date("dmY").date("Hi");
                                                
                                                App::uses('Folder', 'Utility');
                                                App::uses('File', 'Utility');
                                                $dir = new Folder();
                                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'].DS.$nomdate , 0777);

                                                  
                                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id']. DS.$nomdate. DS.$nomdate.'.'.$NomImageChoisie[1], 100);
                                                $LienImageNews = $nomdate. DS.$nomdate.'.'.$NomImageChoisie[1];

                                                $this->Media->saveField('nomfichier',$LienImageNews);
                                                $img = $limit['Limit']['picture'];
                                                $this->Limit->id = $limit['Limit']['id'];
                                                $this->Limit->saveField('picture',$img-1);
                                                $this->Session->setFlash(__('Contenu image ajouté'),"default", array('class' => 'alert-box success radius'));
                                                
                                            }else{
                                                $this->Session->setFlash(__('Le type MIME de l\'image n\'est pas bon'),"default", array('class' => 'alert-box warning round'));
                                            }
                                        }else{
                                            $this->Session->setFlash(__('L\'extension choisie pour l\'image est incorrecte'),"default", array('class' => 'alert-box warning rounds'));
                                        }
                                    }else{
                                        $this->Session->setFlash(__('L\'image est trop lourde'),"default", array('class' => 'alert-box warning round'));
                                    }
                                }else{
                                    $this->Session->setFlash(__('Erreur lors de l\'upload image'),"default", array('class' => 'alert-box warning round'));
                                }
                            }
                        }else{
                                    $this->Session->setFlash(__('Vous devez choisir un fichier image'),"default", array('class' => 'alert-box warning round'));
                                }

             return $this->redirect(array('controller' => 'media', 'action' => 'listeimage',$this->request->data['Media']['defunt_id']));
        }else{
                    $this->Session->setFlash(__('Vérifiez votre saisie'),"default", array('class' => 'alert-box warning round'));

        } 
    }
    }

    public function addimageind($id = null){
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
            $personne=$this->Defunt->find('first',array(
                'conditions'=>array('Defunt.id'=>$value['DefuntUsers']['defunt_id'])));
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
        $this->loadModel('Limit');
        $limit = $this->Limit->find('first',array(
            'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id)
            ));
        $this->loadModel('Album');
        $albs = $this->Album->find('all',array(
            'conditions'=>array('Album.defunt_id'=>$id)
            ));
        $this->set(compact('personne','user','limit','cats','albs')); 

        if (!empty($this->request->data)) {
            $this->request->data['Media']['user_id']=$this->Auth->user('id');
            $this->Media->set($this->request->data);
                if($this->Media->validates()){
    
                    if($this->request->data['Media']['nomfichier_url']['error'] != 4){
                    if($this->Media->save($this->request->data)){

                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
                            
                                if ($this->request->data['Media']['nomfichier_url']['error'] <= 0){
                                    if ($this->request->data['Media']['nomfichier_url']['size'] <= 6097152){
                                        $ImageNews = $this->request->data['Media']['nomfichier_url']['name'];
                                        $ExtensionPresumee = explode('.', $ImageNews);
                                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                                            $ImageNews = getimagesize($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                                $ImageChoisie = imagecreatefromjpeg($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                                $TailleImageChoisie = getimagesize($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                                $NouvelleLargeur = 1000; //Largeur choisie à 150 px mais modifiable

                                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                                imagedestroy($ImageChoisie);
                                                $ImageNews = $this->request->data['Media']['nomfichier_url']['name'];
                                                $NomImageChoisie = explode('.', $ImageNews);
                                                $NomImageExploitable = $ImageNews;
                                                $nomdate = date("dmY").date("Hi");
                                                
                                                App::uses('Folder', 'Utility');
                                                App::uses('File', 'Utility');
                                                $dir = new Folder();
                                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'].DS.$nomdate , 0777);

                                                  
                                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id']. DS.$nomdate. DS.$nomdate.'.'.$NomImageChoisie[1], 100);
                                                $LienImageNews = $nomdate. DS.$nomdate.'.'.$NomImageChoisie[1];

                                                $this->Media->saveField('nomfichier',$LienImageNews);
                                                $img = $limit['Limit']['picture'];
                                                $this->Limit->id = $limit['Limit']['id'];
                                                $this->Limit->saveField('picture',$img-1);
                                                $this->Session->setFlash(__('Contenu image ajouté'),"default", array('class' => 'alert-box success radius'));
                                                
                                            }else{
                                                $this->Session->setFlash(__('Le type MIME de l\'image n\'est pas bon'),"default", array('class' => 'alert-box warning round'));
                                            }
                                        }else{
                                            $this->Session->setFlash(__('L\'extension choisie pour l\'image est incorrecte'),"default", array('class' => 'alert-box warning rounds'));
                                        }
                                    }else{
                                        $this->Session->setFlash(__('L\'image est trop lourde'),"default", array('class' => 'alert-box warning round'));
                                    }
                                }else{
                                    $this->Session->setFlash(__('Erreur lors de l\'upload image'),"default", array('class' => 'alert-box warning round'));
                                }
                            }else{
                                    $this->Session->setFlash(__('Enregistrement impossible'),"default", array('class' => 'alert-box warning round'));
                                }
                        }else{
                                    $this->Session->setFlash(__('Vous devez choisir un fichier image'),"default", array('class' => 'alert-box warning round'));
                                }

             return $this->redirect(array('controller' => 'media', 'action' => 'listeimage',$this->request->data['Media']['defunt_id']));
        }else{
                    $this->Session->setFlash(__('Vérifiez votre saisie'),"default", array('class' => 'alert-box warning round'));

        } 
    }
    }

    public function editimage($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
     $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    if ($this->request->is(array('post', 'put'))) {
            $this->Media->id = $id;
            if ($this->Media->save($this->request->data)) {
                $this->Session->setFlash(__('Votre image a bien été mise à jour'),"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'media', 'action' => 'listeimage',$media['Media']['defunt_id']));
            }
                    $this->Session->setFlash(__('Impossible de mettre à jour l\'image'),"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Media->id = $media['Media']['id'];
            $this->request->data = $this->Media->read();
    }        
   
    $this->loadModel('Category');
    $cats = $this->Category->find('all',array(
        'conditions'=>array('Category.defunt_id'=>$media['Media']['defunt_id'])
            ));
    $this->loadModel('Album');
    $albs = $this->Album->find('all',array(
        'conditions'=>array('Album.defunt_id'=>$media['Media']['defunt_id'])
            ));
    
    $this->loadModel('MediaTag');
        $this->Media->recursive = 1;
        $tmp = $this->Media->findById($id);

        $d['tags'] = $tmp['Tag'];
        $this->set($d);
    $this->set(compact('user','personne','media','cats','albs'));  
    }


    public function deleteimage($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    $fol= explode('/', $media['Media']['nomfichier']);
    if ($this->Media->delete($id)) {
        if($fol[0]!=''){
        App::uses('Folder', 'Utility');
        $dir = new Folder(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$media['Media']['defunt_id'].DS.$fol[0] , 0777);
        $dir->delete();}
        $img = $limit['Limit']['picture'];
        $this->Limit->id = $limit['Limit']['id'];
        $this->Limit->saveField('picture',$img+1);
        $this->Session->setFlash(__('L\'image a bien été supprimée'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'media','action'=>'listeimage',$media['Media']['defunt_id']));
    }  
    }

  


    public function addson(){
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
        $this->loadModel('Limit');
        $limit = $this->Limit->find('first',array(
            'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
            ));

        $this->set(compact('personnes','user','limit')); 
        if (!empty($this->request->data)) {
            $this->request->data['Media']['user_id']=$this->Auth->user('id');
            $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->request->data['Media']['nomfichier_url']['error'] != 4){
                    if($this->Media->save($this->request->data))
                    {
                        
                                if ($this->request->data['Media']['nomfichier_url']['error'] <= 0){
                                    if ($this->request->data['Media']['nomfichier_url']['size'] <= 6097152){
                                        $SonNews = $this->request->data['Media']['nomfichier_url']['name'];
                                        $ExtensionPresumee = explode('.', $SonNews);
                                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                                        if ($ExtensionPresumee == 'mp3'){
                                            $SonNews = $this->request->data['Media']['nomfichier_url']['name'];
                                            $NomSonChoisi = explode('.', $SonNews);
                                            $NomSonExploitable = $SonNews;
                                            
                                            App::uses('Folder', 'Utility');
                                            App::uses('File', 'Utility');
                                            $dir = new Folder();
                                            $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'] , 0777);

                                            move_uploaded_file(
                                            $this->request->data['Media']['nomfichier_url']['tmp_name'],
                                            IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'] . DS . $NomSonExploitable);
                                            $LienSonNews = $NomSonExploitable;

                                            $this->Media->saveField('nomfichier',$LienSonNews);
                                            $son = $limit['Limit']['sound'];
                                            $this->Limit->id = $limit['Limit']['id'];
                                            $this->Limit->saveField('sound',$son-1);
                                            $this->Session->setFlash(__('Contenu sonore ajouté'),"default", array('class' => 'alert-box success radius'));
                                                

                                            }else{
                                            $this->Session->setFlash(__('L\'extension choisie pour le fichier est incorrecte'),"default", array('class' => 'alert-box warning rounds'));
                                            }
                                    }else{
                                        $this->Session->setFlash(__('Le fichier est trop lourd'),"default", array('class' => 'alert-box warning round'));
                                    }
                                }else{
                                    $this->Session->setFlash(__('Erreur lors de l\'upload'),"default", array('class' => 'alert-box warning round'));
                                }
                            }
                        }else{
                                    $this->Session->setFlash(__('Vous devez choisir un fichier sonore'),"default", array('class' => 'alert-box warning round'));
                                }

             return $this->redirect(array('controller' => 'media', 'action' => 'listeson',$this->request->data['Media']['defunt_id']));
        }else{
                    $this->Session->setFlash(__('Vérifiez votre saisie'),"default", array('class' => 'alert-box warning round'));

        } 
    }
}

public function addsonind($id = null){
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
            $personne=$this->Defunt->find('first',array(
                'conditions'=>array('Defunt.id'=>$value['DefuntUsers']['defunt_id'])));
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
        $this->loadModel('Limit');
        $limit = $this->Limit->find('first',array(
            'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id)
            ));
        $this->set(compact('personne','user','limit','cats')); 
        if (!empty($this->request->data)) {
            $this->request->data['Media']['user_id']=$this->Auth->user('id');
            $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->request->data['Media']['nomfichier_url']['error'] != 4){
                    if($this->Media->save($this->request->data))
                    {
                        
                                if ($this->request->data['Media']['nomfichier_url']['error'] <= 0){
                                    if ($this->request->data['Media']['nomfichier_url']['size'] <= 6097152){
                                        $SonNews = $this->request->data['Media']['nomfichier_url']['name'];
                                        $ExtensionPresumee = explode('.', $SonNews);
                                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                                        if ($ExtensionPresumee == 'mp3'){
                                            $SonNews = $this->request->data['Media']['nomfichier_url']['name'];
                                            $NomSonChoisi = explode('.', $SonNews);
                                            $NomSonExploitable = $SonNews;
                                            
                                            App::uses('Folder', 'Utility');
                                            App::uses('File', 'Utility');
                                            $dir = new Folder();
                                            $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'] , 0777);

                                            move_uploaded_file(
                                            $this->request->data['Media']['nomfichier_url']['tmp_name'],
                                            IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'] . DS . $NomSonExploitable);
                                            $LienSonNews = $NomSonExploitable;

                                            $this->Media->saveField('nomfichier',$LienSonNews);
                                            $son = $limit['Limit']['sound'];
                                            $this->Limit->id = $limit['Limit']['id'];
                                            $this->Limit->saveField('sound',$son-1);
                                            $this->Session->setFlash(__('Contenu sonore ajouté'),"default", array('class' => 'alert-box success radius'));
                                                

                                            }else{
                                            $this->Session->setFlash(__('L\'extension choisie pour le fichier est incorrecte'),"default", array('class' => 'alert-box warning rounds'));
                                            }
                                    }else{
                                        $this->Session->setFlash(__('Le fichier est trop lourd'),"default", array('class' => 'alert-box warning round'));
                                    }
                                }else{
                                    $this->Session->setFlash(__('Erreur lors de l\'upload'),"default", array('class' => 'alert-box warning round'));
                                }
                            }
                        }else{
                                    $this->Session->setFlash(__('Vous devez choisir un fichier sonore'),"default", array('class' => 'alert-box warning round'));
                                }

             return $this->redirect(array('controller' => 'media', 'action' => 'listeson',$this->request->data['Media']['defunt_id']));
        }else{
                    $this->Session->setFlash(__('Vérifiez votre saisie'),"default", array('class' => 'alert-box warning round'));

        } 
    }
}


public function listeson($id = null){
if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)
            ));
    if($personne['Defunt']['user_id'] == $this->Auth->user('id')){
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typeson'),
        ));
    }else{
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typeson','Media.user_id'=>$this->Auth->user('id')),
        ));
    }
    
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    $this->set(compact('medias','id','user','personne','limit'));
}



    public function editson($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
     $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    if ($this->request->is(array('post', 'put'))) {
            $this->Media->id = $id;
            if ($this->Media->save($this->request->data)) {
                $this->Session->setFlash(__('Votre contenu sonore a bien été mis à jour'),"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'media', 'action' => 'listeson',$media['Media']['defunt_id']));
            }
                    $this->Session->setFlash(__('Impossible de mettre à jour'),"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Media->id = $media['Media']['id'];
            $this->request->data = $this->Media->read();
    }        
   
    $this->loadModel('Category');
    $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$media['Media']['defunt_id'])
            ));
    
    $this->loadModel('MediaTag');
        $this->Media->recursive = 1;
        $tmp = $this->Media->findById($id);

        $d['tags'] = $tmp['Tag'];
        $this->set($d);
    $this->set(compact('user','personne','media','cats'));  
    }


    public function deleteson($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    if ($this->Media->delete($id)) {
        App::uses('File', 'Utility');
        $file = new File(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$media['Media']['defunt_id'] . DS .$media['Media']['nomfichier'], 0777);
        $file->delete();
        $son = $limit['Limit']['sound'];
        $this->Limit->id = $limit['Limit']['id'];
        $this->Limit->saveField('sound',$son+1);
        $this->Session->setFlash(__('Le contenu sonore a bien été supprimé'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'media','action'=>'listeson',$media['Media']['defunt_id']));
    }  
}

public function addvideo(){
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
    $this->set(compact('personnes','user','limit')); 
    if (!empty($this->request->data)) {
        $this->request->data['Media']['user_id']=$this->Auth->user('id');
        $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->Media->save($this->request->data))
                    {
                        $this->Session->setFlash(__('Votre vidéo a bien été ajoutée'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'users', 'action' => 'account'));
                    }
                }
            }
}

public function addvideoind($id = null) {
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
            $personne=$this->Defunt->find('first',array(
                'conditions'=>array('Defunt.id'=>$value['DefuntUsers']['defunt_id'])));
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
    $this->set(compact('personne','user','limit','cats'));  
    if (!empty($this->request->data)) {
        $this->request->data['Media']['user_id']=$this->Auth->user('id');
        $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->Media->save($this->request->data))
                    {
                        $this->Session->setFlash(__('Votre vidéo a bien été ajoutée'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'media', 'action' => 'listvideo',$personne['Defunt']['id']));
                    }
                }
            }
}
       

    public function listvideo($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)
            ));
    if($personne['Defunt']['user_id'] == $this->Auth->user('id')){
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typevideo'),
        ));
    }else{
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typevideo','Media.user_id'=>$this->Auth->user('id')),
        ));
    }
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->set(compact('medias','id','user','personne'));
       } 

    public function editvideo($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    if ($this->request->is(array('post', 'put'))) {
            $this->Media->id = $id;
            if ($this->Media->save($this->request->data)) {
                $this->Session->setFlash(__('Votre vidéo a bien été mise à jour'),"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'media', 'action' => 'listvideo',$media['Media']['defunt_id']));
            }
                    $this->Session->setFlash(__('Impossible de mettre à jour la vidéo'),"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Media->id = $media['Media']['id'];
            $this->request->data = $this->Media->read();
    }        
    
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$media['Media']['defunt_id'])
            ));
    $this->loadModel('MediaTag');
        $this->Media->recursive = 1;
        $tmp = $this->Media->findById($id);

        $d['tags'] = $tmp['Tag'];
        $this->set($d);
    $this->set(compact('user','personne','media','cats'));        
    }

    public function deletevideo($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    if ($this->Media->delete($id)) {
        
        $this->Session->setFlash(__('La vidéo a bien été supprimée'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'media','action'=>'listvideo',$media['Media']['defunt_id']));
    }  
}


public function addpdf(){
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
        $this->loadModel('Limit');
        $limit = $this->Limit->find('first',array(
            'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
            ));

        $this->set(compact('personnes','user','limit')); 
        if (!empty($this->request->data)) {
            $this->request->data['Media']['user_id']=$this->Auth->user('id');
            $this->Media->set($this->request->data);
                if($this->Media->validates()){
                    if($this->request->data['Media']['nomfichier_url']['error'] != 4){
                    if($this->Media->save($this->request->data))
                    {
        
                                if ($this->request->data['Media']['nomfichier_url']['error'] <= 0){
                                    if ($this->request->data['Media']['nomfichier_url']['size'] <= 6097152){
                                        $PdfNews = $this->request->data['Media']['nomfichier_url']['name'];
                                        $ExtensionPresumee = explode('.', $PdfNews);
                                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                                        if ($ExtensionPresumee == 'pdf'){
                                           
                                                App::uses('Folder', 'Utility');
                                                App::uses('File', 'Utility');
                                                $dir = new Folder();
                                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'].DS.'pdf' , 0777);
                                                $nom = IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'].DS.'pdf';
                                                  
                                                move_uploaded_file ( $this->request->data['Media']['nomfichier_url']['tmp_name'],$nom.'/'.$PdfNews);

                                                $this->Media->saveField('nomfichier',$PdfNews);
                                                $img = $limit['Limit']['pdf'];
                                                $this->Limit->id = $limit['Limit']['id'];
                                                $this->Limit->saveField('pdf',$img-1);
                                                $this->Session->setFlash(__('Contenu pdf ajouté'),"default", array('class' => 'alert-box success radius'));
                                                
                                            
                                        }else{
                                            $this->Session->setFlash(__('L\'extension choisie pour le pdf est incorrecte'),"default", array('class' => 'alert-box warning rounds'));
                                        }
                                    }else{
                                        $this->Session->setFlash(__('Le pdf est trop lourd'),"default", array('class' => 'alert-box warning round'));
                                    }
                                }else{
                                    $this->Session->setFlash(__('Erreur lors de l\'upload du pdf'),"default", array('class' => 'alert-box warning round'));
                                }
                            }
                        }else{
                                    $this->Session->setFlash(__('Vous devez choisir un fichier pdf'),"default", array('class' => 'alert-box warning round'));
                                }

             return $this->redirect(array('controller' => 'media', 'action' => 'listepdf',$this->request->data['Media']['defunt_id']));
        }else{
                    $this->Session->setFlash(__('Vérifiez votre saisie'),"default", array('class' => 'alert-box warning round'));

        } 
    }
    }

public function addpdfind($id = null){
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
            $personne=$this->Defunt->find('first',array(
                'conditions'=>array('Defunt.id'=>$value['DefuntUsers']['defunt_id'])));
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
        $this->loadModel('Limit');
        $limit = $this->Limit->find('first',array(
            'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id)
            ));
        $this->set(compact('personne','user','limit','cats')); 

        if (!empty($this->request->data)) {
            $this->request->data['Media']['user_id']=$this->Auth->user('id');
            $this->Media->set($this->request->data);
                if($this->Media->validates()){
    
                    if($this->request->data['Media']['nomfichier_url']['error'] != 4){
                    if($this->Media->save($this->request->data))
                    {
                            
                                if ($this->request->data['Media']['nomfichier_url']['error'] <= 0){
                                    if ($this->request->data['Media']['nomfichier_url']['size'] <= 6097152){
                                        $PdfNews = $this->request->data['Media']['nomfichier_url']['name'];
                                        $ExtensionPresumee = explode('.', $PdfNews);
                                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                                        if ($ExtensionPresumee == 'pdf'){
                                           
                                                App::uses('Folder', 'Utility');
                                                App::uses('File', 'Utility');
                                                $dir = new Folder();
                                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'].DS.'pdf' , 0777);
                                                $nom = IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'].DS.'pdf';
                                                  
                                                move_uploaded_file ( $this->request->data['Media']['nomfichier_url']['tmp_name'],$nom.'/'.$PdfNews);

                                                $this->Media->saveField('nomfichier',$PdfNews);
                                                $img = $limit['Limit']['pdf'];
                                                $this->Limit->id = $limit['Limit']['id'];
                                                $this->Limit->saveField('pdf',$img-1);
                                                $this->Session->setFlash(__('Contenu pdf ajouté'),"default", array('class' => 'alert-box success radius'));
                                                
                                            
                                        }else{
                                            $this->Session->setFlash(__('L\'extension choisie pour le pdf est incorrecte'),"default", array('class' => 'alert-box warning rounds'));
                                        }
                                    }else{
                                        $this->Session->setFlash(__('Le pdf est trop lourd'),"default", array('class' => 'alert-box warning round'));
                                    }
                                }else{
                                    $this->Session->setFlash(__('Erreur lors de l\'upload du pdf'),"default", array('class' => 'alert-box warning round'));
                                }
                            }
                        }else{
                                    $this->Session->setFlash(__('Vous devez choisir un fichier pdf'),"default", array('class' => 'alert-box warning round'));
                                }

             return $this->redirect(array('controller' => 'media', 'action' => 'listepdf',$this->request->data['Media']['defunt_id']));
        }else{
                    $this->Session->setFlash(__('Vérifiez votre saisie'),"default", array('class' => 'alert-box warning round'));

        } 
    }
    }

    public function editpdf($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    if ($this->request->is(array('post', 'put'))) {
            $this->Media->id = $id;
            if ($this->Media->save($this->request->data)) {
                $this->Session->setFlash(__('Votre pdf a bien été mis à jour'),"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller' => 'media', 'action' => 'listepdf',$media['Media']['defunt_id']));
            }
                    $this->Session->setFlash(__('Impossible de mettre à jour le pdf'),"default", array('class' => 'alert-box warning round'));
            
    }else{
            $this->Media->id = $media['Media']['id'];
            $this->request->data = $this->Media->read();
    }        
    
    $this->loadModel('Category');
    $cats = $this->Category->find('all',array(
        'conditions'=>array('Category.defunt_id'=>$media['Media']['defunt_id'])
            ));

    $this->loadModel('MediaTag');
        $this->Media->recursive = 1;
        $tmp = $this->Media->findById($id);

        $d['tags'] = $tmp['Tag'];
        $this->set($d);
    $this->set(compact('user','personne','media','cats'));  
    }


    public function deletepdf($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $media = $this->Media->findById($id);
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])
            ));
       if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }
    $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));

    if ($this->Media->delete($id)) {
        App::uses('File', 'Utility');
        $file = new File(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$media['Media']['defunt_id'].DS.'pdf'. DS .$media['Media']['nomfichier'], 0777);
        $file->delete();
        $pdf = $limit['Limit']['pdf'];
        $this->Limit->id = $limit['Limit']['id'];
        $this->Limit->saveField('pdf',$pdf+1);
        $this->Session->setFlash(__('Le pdf a bien été supprimé'),"default", array('class' => 'alert-box success radius'));
        return $this->redirect(array('controller'=>'media','action'=>'listepdf',$media['Media']['defunt_id']));
    }  
  
    }


 public function listepdf($id = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)
            ));
    if($personne['Defunt']['user_id'] == $this->Auth->user('id')){
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typepdf'),
        ));
    }else{
        $medias = $this->Media->find('all',array(
        'conditions'=> array('Media.defunt_id'=>$id,'Media.type'=>'typepdf','Media.user_id'=>$this->Auth->user('id')),
        ));
    }
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Limit');
    $limit = $this->Limit->find('first',array(
        'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
        ));
    $this->set(compact('medias','id','user','personne','limit'));
       } 

    public function getcover($id = null){
        if (!$id) {
        return false;
        }
        $cover = $this->Media->find('first',array(
            'conditions'=>array('Media.album_id'=>$id)));
        if ($this->request->is('requested')) {
        return $cover;         
        } else {
            $this->set('cover', $cover);
        }   
    }


    public function addimagealb($id = null,$idd = null){
        if (!$id) {
        throw new NotFoundException(__('Erreur id'));
    }
    if (!$idd) {
        throw new NotFoundException(__('Erreur id'));
    }
       $this->loadModel('Defunt');
    
    $this->loadModel('DefuntUsers');
    $personnebis = $this->DefuntUsers->find('all',array(
        'conditions'=>array('DefuntUsers.defunt_id'=>$id)
        ));

    foreach ($personnebis as $key => $value) {
        if ($value['DefuntUsers']['user_id'] == $this->Auth->user('id')){
            $personne=$this->Defunt->find('first',array(
                'conditions'=>array('Defunt.id'=>$value['DefuntUsers']['defunt_id'])));
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
        $this->loadModel('Limit');
        $limit = $this->Limit->find('first',array(
            'conditions'=>array('Limit.user_id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id)
            ));
        $this->loadModel('Album');
        $albs = $this->Album->findById($idd);
        $this->set(compact('personne','user','limit','cats','albs')); 

        if (!empty($this->request->data)) {
            $this->request->data['Media']['user_id']=$this->Auth->user('id');
            $this->Media->set($this->request->data);
                if($this->Media->validates()){
    
                    if($this->request->data['Media']['nomfichier_url']['error'] != 4){
                    if($this->Media->save($this->request->data)){

                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
                            
                                if ($this->request->data['Media']['nomfichier_url']['error'] <= 0){
                                    if ($this->request->data['Media']['nomfichier_url']['size'] <= 6097152){
                                        $ImageNews = $this->request->data['Media']['nomfichier_url']['name'];
                                        $ExtensionPresumee = explode('.', $ImageNews);
                                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                                            $ImageNews = getimagesize($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                                $ImageChoisie = imagecreatefromjpeg($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                                $TailleImageChoisie = getimagesize($this->request->data['Media']['nomfichier_url']['tmp_name']);
                                                $NouvelleLargeur = 1000; //Largeur choisie à 150 px mais modifiable

                                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                                imagedestroy($ImageChoisie);
                                                $ImageNews = $this->request->data['Media']['nomfichier_url']['name'];
                                                $NomImageChoisie = explode('.', $ImageNews);
                                                $NomImageExploitable = $ImageNews;
                                                $nomdate = date("dmY").date("Hi");
                                                
                                                App::uses('Folder', 'Utility');
                                                App::uses('File', 'Utility');
                                                $dir = new Folder();
                                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id'].DS.$nomdate , 0777);

                                                  
                                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$this->request->data['Media']['defunt_id']. DS.$nomdate. DS.$nomdate.'.'.$NomImageChoisie[1], 100);
                                                $LienImageNews = $nomdate. DS.$nomdate.'.'.$NomImageChoisie[1];

                                                $this->Media->saveField('nomfichier',$LienImageNews);
                                                $img = $limit['Limit']['picture'];
                                                $this->Limit->id = $limit['Limit']['id'];
                                                $this->Limit->saveField('picture',$img-1);
                                                $this->Session->setFlash(__('Contenu image ajouté'),"default", array('class' => 'alert-box success radius'));
                                                
                                            }else{
                                                $this->Session->setFlash(__('Le type MIME de l\'image n\'est pas bon'),"default", array('class' => 'alert-box warning round'));
                                            }
                                        }else{
                                            $this->Session->setFlash(__('L\'extension choisie pour l\'image est incorrecte'),"default", array('class' => 'alert-box warning rounds'));
                                        }
                                    }else{
                                        $this->Session->setFlash(__('L\'image est trop lourde'),"default", array('class' => 'alert-box warning round'));
                                    }
                                }else{
                                    $this->Session->setFlash(__('Erreur lors de l\'upload image'),"default", array('class' => 'alert-box warning round'));
                                }
                            }else{
                                    $this->Session->setFlash(__('Enregistrement impossible'),"default", array('class' => 'alert-box warning round'));
                                }
                        }else{
                                    $this->Session->setFlash(__('Vous devez choisir un fichier image'),"default", array('class' => 'alert-box warning round'));
                                }

             return $this->redirect(array('controller' => 'media', 'action' => 'listeimage',$this->request->data['Media']['defunt_id']));
        }else{
                    $this->Session->setFlash(__('Vérifiez votre saisie'),"default", array('class' => 'alert-box warning round'));

        } 
    }
    }

    public function getbyimage($id = null){
        $img = $this->Media->find('first',array(
            'conditions'=>array('Media.type'=>'typeimage','Media.album_id'=>$id)));
        if ($this->request->is('requested')) {
            return $img;         
            } else {
                $this->set('img', $img);
            }
    }


    public function autcom($id = null){
        if (!$id) {
            throw new NotFoundException(__('Erreur id'));
        }

        $media = $this->Media->findById($id);
        if (!$media) {
            throw new NotFoundException(__('Erreur id'));
        }
        $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$media['Media']['defunt_id'])));
        $this->loadModel('User');
        
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')) {
            if($media['Media']['user_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Vous n\'êtes pas le propriétaire de ce contenu'),"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }
            
        }


        if ($this->request->is(array('post', 'put'))) {
            $this->Media->id = $id;

                $approbation = $this->Media->field('comment');
                $this->set(compact('approbation'));

                if ($approbation == 0) {
                    if ($this->Media->save($this->request->data) ) {
                        $this->Media->save(array('comment' => 1));
                        $this->Session->setFlash(__('Commentaires autorisés'),"default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller' => 'defunts', 'action' => 'editprinc',$personne['Defunt']['id']));
       }
                } 

                if ($approbation == 1){
                    if ($this->Media->save($this->request->data) ) {
                        $this->Media->save(array('comment' => 0));
                        $this->Session->setFlash(__('Commentaires interdits'),"default", array('class' => 'alert-box warning round'));
                        return $this->redirect(array('controller' => 'defunts', 'action' => 'editprinc',$personne['Defunt']['id']));
     }
                }
            



                        $this->Session->setFlash(__('Impossible de changer le statut des commentaires'),"default", array('class' => 'alert-box warning round'));
           
        }

        if (!$this->request->data) {
            $this->request->data = $media;
        }
    }

}