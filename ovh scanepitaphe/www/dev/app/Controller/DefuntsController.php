<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class DefuntsController extends AppController {

	public $helper = array('Session');
	public $components = array('Session');

	 public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('index','view','liste');
    }


    public function pers(){
        $this->loadModel('DefuntUsers');
        $personnes=$this->DefuntUsers->find('all',array(
            'conditions'=>array('DefuntUsers.user_id'=>$this->Auth->user('id'))));
        $pers=array();
        foreach ($personnes as $key => $value) {
            $tmp = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$value['DefuntUsers']['defunt_id'])
        ));
         
            array_push($pers, $tmp);
        }     
        if ($this->request->is('requested')) {
            return $pers;         
            } else {
                $this->set('pers', $pers);
            }       
    }


	

    public function liste($id = null){
    if (!$id) {
        throw new NotFoundException(__('Invalid post'));
    }
    $personnes = $this->Defunt->find('all',array(
        'conditions'=> array('family_id'=>$id),
        'fields'=> array('Defunt.id','Defunt.name','Defunt.firstname','Defunt.client_page_id','Family.name','Defunt.avatar'),
        'contain' => array('Family')
        ));

    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('Family');
    $family=$this->Family->findById($id);
    $this->set(compact('personnes','id','user','family'));
    }

    public function listeall($id = null){
    if (!$id) {
        throw new NotFoundException(__('Invalid post'));
    }
    $personnes = $this->Defunt->find('all',array(
        'conditions'=> array('Defunt.user_id'=>$id),
        'fields'=> array('Defunt.id','Defunt.name','Defunt.firstname','Defunt.client_page_id','Family.name','Defunt.avatar'),
        'contain' => array('Family')
        ));
    $this->loadModel('Family');
        $families=$this->Family->find('all',array(
            'conditions'=> array('Family.user_id'=>$this->Auth->user('id')),
            ));
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->set(compact('personnes','id','user','families'));
    }

    public function edit($id = null) {
    if (!$id) {
        throw new NotFoundException(__('ID invalid'));
    }
    $personne = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$id),
        'contain'=>array('Family')
        ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')){
        $this->Session->setFlash('Vous n\'êtes pas le propriétaire de cette personne',"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    if (!$personne) {
        throw new NotFoundException(__('Defunt invalid'));
    }

    if (!empty($this->request->data)) {
            $this->request->data['Defunt']['id'] = $id;
                if($this->Defunt->validates()){
                    if($this->Defunt->save($this->request->data))
                    {
                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
                if($this->request->data['Defunt']['avatar_url']['size'] != 0){
                if ($this->request->data['Defunt']['avatar_url']['error'] <= 0){
                    if ($this->request->data['Defunt']['avatar_url']['size'] <= 6097152){
                        $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                        $ExtensionPresumee = explode('.', $ImageNews);
                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                            $ImageNews = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                $ImageChoisie = imagecreatefromjpeg($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $TailleImageChoisie = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $NouvelleLargeur = 950; //Largeur choisie à 150 px mais modifiable

                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                imagedestroy($ImageChoisie);
                                $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                                $NomImageChoisie = explode('.', $ImageNews);
                                $NomImageExploitable = 'avatar_defunt_'.$id;

                                App::uses('Folder', 'Utility');
                                App::uses('File', 'Utility');
                                $dir = new Folder();
                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$id , 0777);

                                  
                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$id . DS.$NomImageExploitable.'.'.$ExtensionPresumee, 100);
                                $LienImageNews = $NomImageExploitable.'.'.$ExtensionPresumee;

                                $this->Defunt->saveField('avatar',$LienImageNews);
                                $this->Session->setFlash("Modifications sauvegardées","default", array('class' => 'alert-box success radius'));
                                
                            }else{
                                $this->Session->setFlash('Le type MIME de l\'image n\'est pas bon',"default", array('class' => 'alert-box warning round'));
                            }
                        }else{
                            $this->Session->setFlash('L\'extension choisie pour l\'image est incorrecte',"default", array('class' => 'alert-box warning rounds'));
                        }
                    }else{
                        $this->Session->setFlash('L\'image est trop lourde',"default", array('class' => 'alert-box warning round'));
                    }
                }else{
                    $this->Session->setFlash('Erreur lors de l\'upload image',"default", array('class' => 'alert-box warning round'));
                }
            }
            }
        return $this->redirect(array('controller'=>'Defunts','action'=>'liste',$personne['Defunt']['family_id']));
        }else{
                    $this->Session->setFlash('Vérifiez votre saisie',"default", array('class' => 'alert-box warning round'));

        } 
    }else{
            $this->Defunt->id = $id;
            $this->request->data = $this->Defunt->read();
        }
        $this->loadModel('Family');
        $families = $this->Family->find('all',array(
            'conditions'=>array('Family.user_id'=>$this->Auth->user('id'))));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('personne','user','families'));
    }



    public function add($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Family');
        $famille = $this->Family->find('first',array(
            'conditions'=>array('Family.id'=>$id)));
        $this->set(compact('id','user','famille'));
        if (!empty($this->request->data)) {
                if($this->Defunt->validates()){
                    if($this->Defunt->save($this->request->data))
                    {
                        $this->loadModel('DefuntUsers');
                        $this->DefuntUsers->create(array(
                            'defunt_id'=>$this->Defunt->id,
                            'user_id'=>$this->Auth->user('id')
                            ));
                        $this->DefuntUsers->save();
                        $this->loadModel('ClientPage');
                        $this->ClientPage->create();
                        $this->ClientPage->saveField('defunt_id',$this->Defunt->id);
                         App::uses('Folder', 'Utility');
                        $dir = new Folder();
                        $dir->create(IMAGES.'medias/defunts/defunt_'.$this->Defunt->id,0777);
                        $creslug='http://scanepitaphe.fr/clientpages/view/'.$this->Defunt->id;
                        App::import('Vendor','qrlib/qrlib');  
                        QRcode::png($creslug,'img/medias/defunts/defunt_'.$this->Defunt->id.'/qrcode_'.$this->Defunt->id.'.png');
                        

                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
            if($this->request->data['Defunt']['avatar_url']['size'] != 0){
                if ($this->request->data['Defunt']['avatar_url']['error'] <= 0){
                    if ($this->request->data['Defunt']['avatar_url']['size'] <= 6097152){
                        $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                        $ExtensionPresumee = explode('.', $ImageNews);
                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                            $ImageNews = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                $ImageChoisie = imagecreatefromjpeg($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $TailleImageChoisie = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $NouvelleLargeur = 950; //Largeur choisie à 150 px mais modifiable

                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                imagedestroy($ImageChoisie);
                                $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                                $NomImageChoisie = explode('.', $ImageNews);
                                $idd = $this->Defunt->id;
                                $NomImageExploitable = 'avatar_defunt_'.$idd;

                                App::uses('Folder', 'Utility');
                                App::uses('File', 'Utility');
                                $dir = new Folder();
                                $dir->create(IMAGES.'medias/defunts/defunt_'.$this->Defunt->id,0777);

                                  
                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$idd . DS.$NomImageExploitable.'.'.$ExtensionPresumee, 100);
                                $LienImageNews = $NomImageExploitable.'.'.$ExtensionPresumee;

                                $this->Defunt->saveField('avatar',$LienImageNews);
                                $this->Session->setFlash("Modifications sauvegardées","default", array('class' => 'alert-box success radius'));
                                
                            }else{
                                $this->Session->setFlash('Le type MIME de l\'image n\'est pas bon',"default", array('class' => 'alert-box warning round'));
                            }
                        }else{
                            $this->Session->setFlash('L\'extension choisie pour l\'image est incorrecte',"default", array('class' => 'alert-box warning rounds'));
                        }
                    }else{
                        $this->Session->setFlash('L\'image est trop lourde',"default", array('class' => 'alert-box warning round'));
                    }
                }else{
                    $this->Session->setFlash('Erreur lors de l\'upload image',"default", array('class' => 'alert-box warning round'));
                }
            }

            }
        return $this->redirect(array('controller'=>'families','action'=>'editprinc',$id));
        }else{
                    $this->Session->setFlash('Vérifiez votre saisie',"default", array('class' => 'alert-box warning round'));

        } 
    }
}

public function steptwo($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('id','user'));
        if (!empty($this->request->data)) {
                if($this->Defunt->validates()){
                    if($this->Defunt->save($this->request->data))
                    {
                        $this->loadModel('DefuntUsers');
                        $this->DefuntUsers->create(array(
                            'defunt_id'=>$this->Defunt->id,
                            'user_id'=>$this->Auth->user('id')
                            ));
                        $this->DefuntUsers->save();
                        $this->loadModel('ClientPage');
                        $this->ClientPage->create();
                        $this->ClientPage->saveField('defunt_id',$this->Defunt->id);
                         App::uses('Folder', 'Utility');
                        $dir = new Folder();
                        $dir->create(IMAGES.'medias/defunts/defunt_'.$this->Defunt->id,0777);
                        $creslug='http://scanepitaphe.fr/clientpages/view/'.$this->Defunt->id;
                        App::import('Vendor','qrlib/qrlib');  
                         QRcode::png($creslug,'img/medias/defunts/defunt_'.$this->Defunt->id.'/qrcode_'.$this->Defunt->id.'.png');
                       
                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
                        $this->Session->setFlash("Personne créée","default", array('class' => 'alert-box success radius'));

            if($this->request->data['Defunt']['avatar_url']['size'] != 0){
                if ($this->request->data['Defunt']['avatar_url']['error'] <= 0){
                    if ($this->request->data['Defunt']['avatar_url']['size'] <= 6097152){
                        $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                        $ExtensionPresumee = explode('.', $ImageNews);
                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                            $ImageNews = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                $ImageChoisie = imagecreatefromjpeg($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $TailleImageChoisie = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $NouvelleLargeur = 950; //Largeur choisie à 150 px mais modifiable

                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                imagedestroy($ImageChoisie);
                                $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                                $NomImageChoisie = explode('.', $ImageNews);
                                $id = $this->Defunt->id;
                                $NomImageExploitable = 'avatar_defunt_'.$id;

                                App::uses('Folder', 'Utility');
                                App::uses('File', 'Utility');
                                $dir = new Folder();
                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$id , 0777);

                                  
                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$id . DS.$NomImageExploitable.'.'.$ExtensionPresumee, 100);
                                $LienImageNews = $NomImageExploitable.'.'.$ExtensionPresumee;

                                $this->Defunt->saveField('avatar',$LienImageNews);
                                
                            }else{
                                $this->Session->setFlash('Le type MIME de l\'image n\'est pas bon',"default", array('class' => 'alert-box warning round'));
                            }
                        }else{
                            $this->Session->setFlash('L\'extension choisie pour l\'image est incorrecte',"default", array('class' => 'alert-box warning rounds'));
                        }
                    }else{
                        $this->Session->setFlash('L\'image est trop lourde',"default", array('class' => 'alert-box warning round'));
                    }
                }else{
                    $this->Session->setFlash('Erreur lors de l\'upload image',"default", array('class' => 'alert-box warning round'));
                }
            }

            }
        return $this->redirect(array('controller'=>'categories','action'=>'stepthree',$this->Defunt->id));
        }else{
                    $this->Session->setFlash('Vérifiez votre saisie',"default", array('class' => 'alert-box warning round'));

        } 
    }
}

    public function delete($id = null,$idd = null) {
    
        $personne = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$id),
        'contain'=>array('Family')
        ));
        $this->set(compact('personne'));
        if(!empty($this->request->data)){
        $this->loadModel('User');
        $user = $this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id'))));
            if($personne['Defunt']['user_id'] != $this->Auth->user('id')){
                $this->Session->setFlash('Vous n\'avez pas les droits',"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            }

        if($this->Auth->password($this->request->data['Defunt']['password']) == $user['User']['password']){
                App::uses('Folder', 'Utility');
                $folder = new Folder( IMAGES.'medias/defunts/'.'defunt_'.$id);
                $folder->delete();
                $this->loadModel('DefuntUsers');
                $link = $this->DefuntUsers->find('first',array(
                        'conditions'=>array('DefuntUsers.defunt_id'=>$id)
                    ));
                $this->DefuntUsers->delete($link['DefuntUsers']['id']);

                $this->loadModel('ClientPage');
                $clientpage = $this->ClientPage->find('first',array(
                        'conditions'=>array('ClientPage.defunt_id'=>$id)
                    ));
                $this->ClientPage->delete($clientpage['ClientPage']['id']);
            if ($this->Defunt->delete($id)) {
                $this->loadModel('Media');
                $medias=$this->Media->find('all',array(
                    'conditions'=>array('Media.defunt_id'=>$id)));
                foreach ($medias as $key => $value) {
                    $this->Media->delete($value['Media']['id']);
                }
                $this->loadModel('Album');
                $albs=$this->Album->find('all',array(
                    'conditions'=>array('Album.defunt_id'=>$id)));
                foreach ($albs as $key => $value) {
                    $this->Album->delete($value['Album']['id']);
                }
                $this->loadModel('Category');
                $cats=$this->Category->find('all',array(
                    'conditions'=>array('Category.defunt_id'=>$id)));
                foreach ($cats as $key => $value) {
                    $this->Category->delete($value['Category']['id']);
                }
                $this->loadModel('DefuntUsers');
                $userd=$this->DefuntUsers->find('all',array(
                    'conditions'=>array('DefuntUsers.defunt_id'=>$id)));
                foreach ($userd as $key => $value) {
                    $this->DefuntUsers->delete($value['DefuntUsers']['id']);
                }
                $this->Session->setFlash('Le profil a bien été supprimé ainsi que ses contenus',"default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller'=>'families','action'=>'editprinc',$idd));
            }
        }else{
            $this->Session->setFlash('Erreur de mot de passe. Suppression annulée.',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'users','action'=>'account'));
        }


        }
        
                        
}

public function addall() {
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->loadModel('Family');
        $families=$this->Family->find('all',array(
            'conditions'=> array('Family.user_id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('id','user','families'));
        if (!empty($this->request->data)) {
                if($this->Defunt->validates()){
                    if($this->Defunt->save($this->request->data))
                    {
                        $this->loadModel('DefuntUsers');
                        $this->DefuntUsers->create(array(
                            'defunt_id'=>$this->Defunt->id,
                            'user_id'=>$this->Auth->user('id')
                            ));
                        $this->DefuntUsers->save();
                        
                        $this->loadModel('ClientPage');
                        $this->ClientPage->create();
                        $this->ClientPage->saveField('defunt_id',$this->Defunt->id);
                        App::uses('Folder', 'Utility');
                        $dir = new Folder();
                        $dir->create(IMAGES.'medias/defunts/defunt_'.$this->Defunt->id,0777);
                        $creslug='http://scanepitaphe.fr/clientpages/view/'.$this->Defunt->id;
                        App::import('Vendor','qrlib/qrlib');  
                         QRcode::png($creslug,'img/medias/defunts/defunt_'.$this->Defunt->id.'/qrcode_'.$this->Defunt->id.'.png');
                       
                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
            if($this->request->data['Defunt']['avatar_url']['size'] != 0){
                if ($this->request->data['Defunt']['avatar_url']['error'] <= 0){
                    if ($this->request->data['Defunt']['avatar_url']['size'] <= 2097152){
                        $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                        $ExtensionPresumee = explode('.', $ImageNews);
                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                            $ImageNews = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                $ImageChoisie = imagecreatefromjpeg($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $TailleImageChoisie = getimagesize($this->request->data['Defunt']['avatar_url']['tmp_name']);
                                $NouvelleLargeur = 950; //Largeur choisie à 150 px mais modifiable

                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                imagedestroy($ImageChoisie);
                                $ImageNews = $this->request->data['Defunt']['avatar_url']['name'];
                                $NomImageChoisie = explode('.', $ImageNews);
                                $id = $this->Defunt->id;
                                $NomImageExploitable = 'avatar_defunt_'.$id;

                                App::uses('Folder', 'Utility');
                                App::uses('File', 'Utility');
                                $dir = new Folder();
                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$id , 0777);

                                  
                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$id . DS.$NomImageExploitable.'.'.$ExtensionPresumee, 100);
                                $LienImageNews = $NomImageExploitable.'.'.$ExtensionPresumee;

                                $this->Defunt->saveField('avatar',$LienImageNews);
                                $this->Session->setFlash("Modifications sauvegardées","default", array('class' => 'alert-box success radius'));
                                
                            }else{
                                $this->Session->setFlash('Le type MIME de l\'image n\'est pas bon',"default", array('class' => 'alert-box warning round'));
                            }
                        }else{
                            $this->Session->setFlash('L\'extension choisie pour l\'image est incorrecte',"default", array('class' => 'alert-box warning rounds'));
                        }
                    }else{
                        $this->Session->setFlash('L\'image est trop lourde',"default", array('class' => 'alert-box warning round'));
                    }
                }else{
                    $this->Session->setFlash('Erreur lors de l\'upload image',"default", array('class' => 'alert-box warning round'));
                }
            }

            }
        return $this->redirect(array('controller'=>'defunts','action'=>'listeall',$this->Auth->user('id')));
        }else{
                    $this->Session->setFlash('Vérifiez votre saisie',"default", array('class' => 'alert-box warning round'));

        } 
    }
} 

    public function getbyfamily($id = null){
        $personne = $this->Defunt->find('first',array(
            'conditions'=>array('Defunt.family_id'=>$id)
            ));
        if ($this->request->is('requested')) {
            return $personne;         
            } else {
                $this->set('personne', $personne);
            } 
    }

    public function getallbyfamily($id = null){
        $personnes = $this->Defunt->find('all',array(
            'conditions'=>array('Defunt.family_id'=>$id)
            ));
        if ($this->request->is('requested')) {
            return $personnes;         
            } else {
                $this->set('personnes', $personnes);
            } 
    }

    public function editprinc($id = null) {
    if (!$id) {
        throw new NotFoundException(__('ID invalid'));
    }
    $personne = $this->Defunt->find('first',array(
        'conditions'=>array('Defunt.id'=>$id),
        'contain'=>array('Family')
        ));
        if($personne['Defunt']['user_id'] != $this->Auth->user('id')){
        $this->Session->setFlash('Vous n\'êtes pas le propriétaire de cette personne',"default", array('class' => 'alert-box warning round'));
        return $this->redirect(array('controller' => 'pages', 'action' => 'display','home'));
            
        }
    if (!$personne) {
        throw new NotFoundException(__('Defunt invalid'));
    }

    
        $this->Defunt->id = $id;
        $this->request->data = $this->Defunt->read();
        
        $this->loadModel('Family');
        $families = $this->Family->find('all',array(
            'conditions'=>array('Family.user_id'=>$this->Auth->user('id'))));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('personne','user','families'));
    }


}