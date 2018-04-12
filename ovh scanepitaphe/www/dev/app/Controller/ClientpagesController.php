<?php
// Website Name: LovinMemory
// Website URI: http://www.lovinmemory.com
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class ClientPagesController extends AppController {

	public $helper = array('Html','Form','Session');
	public $components = array('Session');
    public $scaffold = 'admin';

	public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('view','liste','photo','viewcat','viewtag','album');
    }
	

    public function liste($id = null){
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $pages = $this->ClientPage->find('all',array(
            'conditions'=> array('family_id'=>$id),
            'fields'=> array('ClientPage.id')
            ));
        if (!$pages) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set(compact('pages'));
    }


    public function photo($id = null) {
        $this->layout='page';
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        if($id == 4508032014103542){
            $id=163;
        }
        $this->LoadModel('Defunt');
        $personne = $this->Defunt->findById($id);
        $this->loadModel('Media');
        $medias = $this->Media->find('all',
                array(
                    'conditions' => array('Media.defunt_id' => $id,'Media.type'=>'typeimage'),
                    'order' => array('Media.date' => 'asc')
                ));
        $clientpage = $this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.defunt_id'=>$id)
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id),
            ));
        $this->loadModel('Album');
        $albs = $this->Album->find('all',array(
            'conditions'=>array('Album.defunt_id'=>$id),
            'recursive'=>-1
            ));
        if(!empty($albs)){
        foreach ($albs as $key => $value) {
            $thumb[$key]=$this->Media->find('first',array(
                'conditions'=>array('Media.album_id'=>$value['Album']['id'])
                ));
        }
        }
        
        $password=$this->Session->read('password');
        
        if(empty($medias)){
            $this->Session->setFlash('Page sans contenu ou inexistante',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'pages','action'=>'display','home'));
        }
        if(!empty($medias)){
            $alltags = array();
            foreach ($medias as $key => $value) {
                foreach ($value['Tag'] as $key => $value) {
                    
                array_push($alltags, $value);
            }
            }
            
            $families = $this->Defunt->find('all',array(
                'conditions'=>array('Defunt.family_id'=>$personne['Defunt']['family_id'],'Defunt.id !='=>$id)
                ));
            $this->loadModel('Family');
            $family=$this->Family->findById($personne['Defunt']['family_id']);
            $this->set(compact('families','family')); 
        }

        if(!empty($this->request->data)){
            if($this->request->data['ClientPage']['password'] == $clientpage['ClientPage']['password']){
                $this->Session->write('password','ok');
                $password=$this->Session->read('password');
            }else{
                $this->Session->setFlash('Ce n\'est pas le bon mot de passe',"default", array('class' => 'alert-box warning rounds'));
            }
        }

        $this->set(compact('medias','clientpage','password','cats','personne','alltags','thumb'));  
    }


    public function view($id = null) {
        $this->layout='page';
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        if($id == 4508032014103542){
            $id=163;
        }
        $this->loadModel('User');
        $user=$this->User->find('first',array(
                'conditions'=>array('User.id'=>$this->Auth->user('id')),
                ));
        $this->LoadModel('Defunt');
        $personne = $this->Defunt->findById($id);
        $this->loadModel('Media');
        $this->Media->recursive=0;
        $medias = $this->Media->find('all',
                array(
                    'conditions' => array('Media.defunt_id' => $id),
                    'order' => array('Media.date' => 'asc'),
                    'contain'=>array('Tag')
                ));
        
        $clientpage = $this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.defunt_id'=>$id)
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id),
            ));
        $password=$this->Session->read('password');
        
        if(empty($medias)){
            $this->Session->setFlash('Page sans contenu ou inexistante',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'pages','action'=>'display','home'));
        }
        if(!empty($medias)){
            $img=0;
            foreach ($medias as $key => $value) {
                if($value['Media']['type'] == 'typeimage'){
                    $img=$img+1;
                }
            }
            $families = $this->Defunt->find('all',array(
                'conditions'=>array('Defunt.family_id'=>$personne['Defunt']['family_id'],'Defunt.id !='=>$id)
                ));
            $this->loadModel('Family');
            $family=$this->Family->findById($personne['Defunt']['family_id']);
            $this->set(compact('families','family')); 
        }

        if(!empty($this->request->data)){
            if($this->request->data['ClientPage']['password'] == $clientpage['ClientPage']['password']){
                $this->Session->write('password','ok');
                $password=$this->Session->read('password');
            }else{
                $this->Session->setFlash('Ce n\'est pas le bon mot de passe',"default", array('class' => 'alert-box warning rounds'));
            }
        }

        $this->loadModel('Album');
        $albs = $this->Album->find('all',array(
            'conditions'=>array('Album.defunt_id'=>$id),
            'recursive'=>-1
            ));

       $timeline =array();
        foreach ($medias as $key => $value) {
            array_push($timeline, $value);
        }
        foreach ($albs as $key => $value) {
            array_push($timeline, $value);
        }
        foreach ($timeline as $key => $value) {
            if(!empty($value['Media']['date'])){
                $date[$key]=$value['Media']['date'];
            }elseif(!empty($value['Album']['date'])){
                $date[$key]=$value['Album']['date'];
            }
        }

        function compare($a, $b)
{
    if(!empty($a['Media']['date']) && !empty($b['Media']['date'])){
    return strcmp($a['Media']['date'], $b['Media']['date']);
    }elseif(!empty($a['Media']['date']) && !empty($b['Album']['date'])){
    return strcmp($a['Media']['date'], $b['Album']['date']);
    }elseif(!empty($a['Album']['date']) && !empty($b['Media']['date'])){
    return strcmp($a['Album']['date'], $b['Media']['date']);
    }elseif(!empty($a['Album']['date']) && !empty($b['Album']['date'])){
    return strcmp($a['Album']['date'], $b['Album']['date']);
    }
}
 
        usort($timeline, 'compare');
   
        $this->set(compact('user','timeline','medias','clientpage','password','cats','personne','img'));  
    }

    public function manage($id = null){
        if (!$id){
            throw new NotFoundException(__('Page invalide'));
        }   
        $clientpage=$this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.defunt_id'=>$id)
                ));   
        $this->loadModel('DefuntUsers');
        $def=$this->DefuntUsers->find('all',array(
            'conditions'=>array('DefuntUsers.defunt_id'=>$id))); 
        $this->loadModel('Defunt');
        $personne=$this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)
            ));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $users_id=array();

        foreach ($def as $key => $value) {
            array_push($users_id, $value['DefuntUsers']['user_id']);
        }
        if(in_array($this->Auth->user('id'), $users_id)){
        }else{
            $this->Session->setFlash('Vous n\'avez pas les droits',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'users','action'=>'account'));
        }
        $this->set(compact('user','personne','clientpage'));
    }

    public function backgroundimg($id = null){
        if (!$id){
            throw new NotFoundException(__('Demand invalid'));
        }
        $clientpage=$this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.id'=>$id),
            'contain'=>'Defunt'
            ));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('clientpage','user'));


        if (!empty($this->request->data)) {
                if($this->ClientPage->validates()){
                    $this->ClientPage->id=$clientpage['ClientPage']['id'];
                        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
            if($this->request->data['ClientPage']['backgroundimg']['size'] != 0){
                if ($this->request->data['ClientPage']['backgroundimg']['error'] <= 0){
                    if ($this->request->data['ClientPage']['backgroundimg']['size'] <= 4097152){
                        $ImageNews = $this->request->data['ClientPage']['backgroundimg']['name'];
                        $ExtensionPresumee = explode('.', $ImageNews);
                        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
                        if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
                            $ImageNews = getimagesize($this->request->data['ClientPage']['backgroundimg']['tmp_name']);
                            if($ImageNews['mime'] == $ListeExtension[$ExtensionPresumee]  || $ImageNews['mime'] == $ListeExtensionIE[$ExtensionPresumee]){
                                $ImageChoisie = imagecreatefromjpeg($this->request->data['ClientPage']['backgroundimg']['tmp_name']);
                                $TailleImageChoisie = getimagesize($this->request->data['ClientPage']['backgroundimg']['tmp_name']);
                                $NouvelleLargeur = 1500; //Largeur choisie à 150 px mais modifiable

                                $NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

                                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");

                                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                imagedestroy($ImageChoisie);
                                $ImageNews = $this->request->data['ClientPage']['backgroundimg']['name'];
                                $NomImageChoisie = explode('.', $ImageNews);
                                $NomImageExploitable = 'backgroundimg_'.$clientpage['ClientPage']['defunt_id'];

                                App::uses('Folder', 'Utility');
                                App::uses('File', 'Utility');
                                $dir = new Folder();
                                $dir->create(IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$clientpage['ClientPage']['defunt_id'] , 0777);

                                  
                                imagejpeg($NouvelleImage , IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$clientpage['ClientPage']['defunt_id'] . DS.$NomImageExploitable.'.'.$ExtensionPresumee, 100);
                                $LienImageNews = $NomImageExploitable.'.'.$ExtensionPresumee;

                                $this->ClientPage->saveField('backgroundimg',$LienImageNews);
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

             return $this->redirect(array('controller'=>'clientpages','action'=>'manage',$clientpage['ClientPage']['defunt_id']));
        }else{
                    $this->Session->setFlash('Vérifiez votre saisie',"default", array('class' => 'alert-box warning round'));

        } 
    }
    }

    public function editpass($id = null){
                if (!$id){
            throw new NotFoundException(__('Demand invalid'));
        }
        $clientpage=$this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.id'=>$id),
            'contain'=>'Defunt'
            ));
        $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('clientpage','user'));
        if(!empty($this->request->data)){
            $this->request->data['ClientPage']['id'] = $id;
                if($this->ClientPage->validates()){
                    if($this->ClientPage->save($this->request->data)){
                        $this->Session->setFlash("Modifications sauvegardées","default", array('class' => 'alert-box success radius'));
                        return $this->redirect(array('controller'=>'clientpages','action'=>'manage',$clientpage['ClientPage']['defunt_id']));
                    }else{
                    $this->Session->setFlash('Impossible à mettre à jour',"default", array('class' => 'alert-box warning round'));
                    }
                }else{
                    $this->Session->setFlash('Vérifiez votre saisie',"default", array('class' => 'alert-box warning round'));
                }
        }else{
            $this->ClientPage->id=$clientpage['ClientPage']['id'];
            $this->request->data=$this->ClientPage->read();
        }
    }

    public function viewcat($id = null,$idd) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        if (!$idd) {
            throw new NotFoundException(__('Invalid post'));
        }
        if($id == 4508032014103542){
            $id=163;
        }
        $this->layout='page';
        $this->loadModel('User');
        $user=$this->User->find('first',array(
                'conditions'=>array('User.id'=>$this->Auth->user('id')),
                ));
        $this->LoadModel('Defunt');
        $personne = $this->Defunt->findById($id);
        $this->loadModel('Media');
        $this->Media->recursive=0;
        $medias = $this->Media->find('all',
                array(
                    'conditions' => array('Media.defunt_id' => $id,'Media.category_id'=>$idd),
                    'order' => array('Media.date' => 'asc'),
                    'contain'=>array('Tag')
                ));

        

        $clientpage = $this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.defunt_id'=>$id)
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id),
            ));
        $password=$this->Session->read('password');
        
        if(empty($medias)){
            $this->Session->setFlash('Pas de contenus dans cette catégorie',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'clientpages','action'=>'view',$id));
        }
        if(!empty($medias)){
            $img=0;
            foreach ($medias as $key => $value) {
                if($value['Media']['type'] == 'typeimage'){
                    $img=$img+1;
                }
            }
            $this->LoadModel('Defunt');
            $families = $this->Defunt->find('all',array(
                'conditions'=>array('Defunt.family_id'=>$personne['Defunt']['family_id'],'Defunt.id !='=>$id)
                ));
            $this->loadModel('Family');
            $family=$this->Family->findById($personne['Defunt']['family_id']);
            $this->set(compact('families','family')); 
        }

        if(!empty($this->request->data)){
            if($this->request->data['ClientPage']['password'] == $clientpage['ClientPage']['password']){
                $this->Session->write('password','ok');
                $password=$this->Session->read('password');
            }else{
                $this->Session->setFlash('Ce n\'est pas le bon mot de passe',"default", array('class' => 'alert-box warning rounds'));
            }
        }

        $this->loadModel('Album');
        $albs = $this->Album->find('all',array(
            'conditions'=>array('Album.defunt_id'=>$id,'Album.category_id'=>$idd),
            'recursive'=>-1
            ));

       $timeline =array();
        foreach ($medias as $key => $value) {
            array_push($timeline, $value);
        }
        foreach ($albs as $key => $value) {
            array_push($timeline, $value);
        }
        foreach ($timeline as $key => $value) {
            if(!empty($value['Media']['date'])){
                $date[$key]=$value['Media']['date'];
            }elseif(!empty($value['Album']['date'])){
                $date[$key]=$value['Album']['date'];
            }
        }

        function compare($a, $b)
{
    if(!empty($a['Media']['date']) && !empty($b['Media']['date'])){
    return strcmp($a['Media']['date'], $b['Media']['date']);
    }elseif(!empty($a['Media']['date']) && !empty($b['Album']['date'])){
    return strcmp($a['Media']['date'], $b['Album']['date']);
    }elseif(!empty($a['Album']['date']) && !empty($b['Media']['date'])){
    return strcmp($a['Album']['date'], $b['Media']['date']);
    }elseif(!empty($a['Album']['date']) && !empty($b['Album']['date'])){
    return strcmp($a['Album']['date'], $b['Album']['date']);
    }
}
 
        usort($timeline, 'compare');

        $this->set(compact('user','timeline','medias','clientpage','password','cats','personne','img'));  

    }

    public function viewtag($id = null,$idd) {
        if($id == 4508032014103542){
            $id=163;
        }
        $this->layout='page';
        $this->loadModel('User');
        $user=$this->User->find('first',array(
                'conditions'=>array('User.id'=>$this->Auth->user('id')),
                ));
        $this->LoadModel('Defunt');
        $personne = $this->Defunt->findById($id);
        $this->loadModel('Media');

        $lists=$this->Media->find('all',array(
        'conditions' => array('Media.defunt_id' => $id),
        'order' => array('Media.date' => 'asc'),
        ));
    $medias=array();
    foreach ($lists as $key => $value) {
        foreach ($value['Tag'] as $k => $v) {
            
        if($v['id']==$idd){
            array_push($medias, $value);
        }
    }
    }
        $clientpage = $this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.defunt_id'=>$id)
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id),
            ));
        $password=$this->Session->read('password');
        
        if(empty($medias)){
            $this->Session->setFlash('Pas de contenus dans cette catégorie',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'clientpages','action'=>'view',$id));
        }
        if(!empty($medias)){
            $img=0;
            foreach ($medias as $key => $value) {
                if($value['Media']['type'] == 'typeimage'){
                    $img=$img+1;
                }
            }
            $this->LoadModel('Defunt');
            $families = $this->Defunt->find('all',array(
                'conditions'=>array('Defunt.family_id'=>$personne['Defunt']['family_id'],'Defunt.id !='=>$id)
                ));
            $this->loadModel('Family');
            $family=$this->Family->findById($personne['Defunt']['family_id']);
            $this->set(compact('families','family')); 
        }

        if(!empty($this->request->data)){
            if($this->request->data['ClientPage']['password'] == $clientpage['ClientPage']['password']){
                $this->Session->write('password','ok');
                $password=$this->Session->read('password');
            }else{
                $this->Session->setFlash('Ce n\'est pas le bon mot de passe',"default", array('class' => 'alert-box warning rounds'));
            }
        }
        $this->set(compact('user','medias','clientpage','password','cats','personne','img'));  
    }

     public function album($id = null,$ida = null) {
        $this->layout='page';
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        if($id == 4508032014103542){
            $id=163;
        }
        $this->LoadModel('Defunt');
        $personne = $this->Defunt->findById($id);
        $this->loadModel('Media');
        $medias = $this->Media->find('all',
                array(
                    'conditions' => array('Media.album_id' => $ida,'Media.type'=>'typeimage'),
                    'order' => array('Media.date' => 'asc')
                ));
        $clientpage = $this->ClientPage->find('first',array(
            'conditions'=>array('ClientPage.defunt_id'=>$id)
            ));
        $this->loadModel('Category');
        $cats = $this->Category->find('all',array(
            'conditions'=>array('Category.defunt_id'=>$id),
            ));
       $this->loadModel('Album');
       $album = $this->Album->findById($ida);

        $password=$this->Session->read('password');
        
        if(empty($medias)){
            $this->Session->setFlash('Page sans contenu ou inexistante',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'pages','action'=>'display','home'));
        }
        if(!empty($medias)){
            $alltags = array();
            foreach ($medias as $key => $value) {
                foreach ($value['Tag'] as $key => $value) {
                    
                array_push($alltags, $value);
            }
            }
            
            $families = $this->Defunt->find('all',array(
                'conditions'=>array('Defunt.family_id'=>$personne['Defunt']['family_id'],'Defunt.id !='=>$id)
                ));
            $this->loadModel('Family');
            $family=$this->Family->findById($personne['Defunt']['family_id']);
            $this->set(compact('families','family')); 
        }

        if(!empty($this->request->data)){
            if($this->request->data['ClientPage']['password'] == $clientpage['ClientPage']['password']){
                $this->Session->write('password','ok');
                $password=$this->Session->read('password');
            }else{
                $this->Session->setFlash('Ce n\'est pas le bon mot de passe',"default", array('class' => 'alert-box warning rounds'));
            }
        }

        $this->set(compact('medias','clientpage','password','cats','personne','alltags','album'));  
    }

}