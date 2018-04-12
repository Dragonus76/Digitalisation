<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
App::uses('AppController','Controller');
class UsersController extends AppController {
        public $helper = array('Html','Form','Session','QrCode');
    public $components = array('Session');
    public $scaffold = 'admin';

    public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('register','login','activate','index','forgot','password','registerinvit');
    }
    
    public function register(){
    //Vérifier si utilisateur déjà connecté
        if($this->Auth->user('id')) {
            $this->Session->setFlash('Vous êtes déjà enregistré',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller' => 'users','action' => 'account'));
        }
    //Si pas déjà connecté alors lancer la procedure d'enregistrement
        else{
            //Test si l'utilisateur a saisie les champs pour s'enregistrer et si oui envoi à la base
            
            if (!empty($this->request->data)) {
                if($this->request->data['User']['captcha'] == 7){
                $this->User->create($this->request->data);
                if($this->User->validates()){
                    $token = md5(time() . ' - ' . uniqid());
                    $this->User->create(array(
                        'role' => 'auteur',
                        'username' => $this->request->data['User']['username'],
                        'password' => $this->Auth->password($this->request->data['User']['password']),
                        'email' => $this->request->data['User']['email'],
                        'token' => $token,
                        'active'=>0
                    ));
                    
                     if($this->User->save()){
                        $id = $this->User->id;
                  
                     $this->loadModel('Limit');
                    $lim = $this->requestAction('options/limits/');
                    
                     $this->Limit->create(array(
                        'user_id'=>$id,
                        'text'=>$lim['Option']['content'],
                        'picture'=>$lim['Option']['content'],
                        'sound'=>$lim['Option']['content'],
                        'limittext'=>$lim['Option']['content'],
                        'limitpdf'=>$lim['Option']['content'],
                        'pdf'=>$lim['Option']['content'],
                        'limitpicture'=>$lim['Option']['content'],
                        'limitsound'=>$lim['Option']['content']));
                     $this->Limit->save();
                     }
                     
                     //Les enregistrements sont dans la base

                     
                     // Envoi du mail d activation
                    App::uses('CakeEmail', 'Network/Email');
                    $CakeEmail = new CakeEmail('default');
                    $CakeEmail->to($this->request->data['User']['email']);
                    $CakeEmail->subject('Votre inscription Scanepitaphe');
                    $CakeEmail->viewVars(
                        $this->request->data['User'] +
                        array(
                            'token' => $token,
                            'id' => $this->User->id,
      
                        )
                    );
                    $CakeEmail->emailFormat('text');
                    $CakeEmail->template('inscription');
                    $CakeEmail->send();
                     // fin envoi du mail activation

                    
                    $this->Session->setFlash('Inscription réussie. Vous allez recevoir un email d\'activation. Rendez-vous dans votre boite email',"default", array('class' => 'alert-box success radius'));
                    return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
                    
                }else{
                    $this->Session->setFlash('Merci de corriger vos erreurs',"default", array('class' => 'alert-box warning round'));
                }
            
        }else{
                    $this->Session->setFlash('Erreur de captcha',"default", array('class' => 'alert-box warning round'));

        }
        }
    }
    } 


    public function login(){
	    if (!empty($this->request->data)) {
	        if ($this->Auth->login()) {
                $id = $this->Auth->user('id');
                $user=$this->User->findById($id);
                $this->Session->write('current_user',$user);
                $this->Session->setFlash("Vous êtes connecté","default", array('class' => 'alert-box success radius'));
                if ($this->Auth->user('role') == 'auteur') {
                    $this->redirect(array('controller' => 'users', 'action' => 'account'));
                }elseif ($this->Auth->user('role') == 'fournisseur') {
                    $this->redirect(array('controller' => 'orders', 'action' => 'fournisseurindex'));
                }elseif ($this->Auth->user('role') == 'admin') {
                    $this->redirect(array('controller' => 'dashboards', 'action' => 'index','admin'=>true));
                }
            }else{
	            $this->Session->setFlash("Identifiants incorrects","default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller' => 'users','action' => 'login'));
	        }
	    }
    }

    public function forgot(){
        if (!empty($this->request->data)) {
            
            $user = $this->User->findByEmail($this->request->data['User']['email'], array('id'));
            if(empty($user)){
                $this->Session->setFlash("Cet email n'est associé a aucun compte","default", array('class' => 'alert-box warning round'));
            }else{
                $token = md5(uniqid().time());
                $this->User->id = $user['User']['id'];
                $this->User->saveField('token', $token);

                App::uses('CakeEmail', 'Network/Email');
                $cakeMail = new CakeEmail('default');
                $cakeMail->to($this->request->data['User']['email']);
                $cakeMail->subject('Scanepitaphe.fr : Régénération de mot de passe');
                $cakeMail->template('password');
                $cakeMail->viewVars(array('token' => $token, 'id' => $user['User']['id']));
                $cakeMail->emailFormat('text');
                $cakeMail->send();

                $this->Session->setFlash("Un email vous a été envoyé avec les instructions pour regénérer votre mot de passe","default", array('class' => 'alert-box success radius'));
            }
        }
    }

    public function password($user_id, $token){
        if (!$user_id) {
            throw new NotFoundException(__('Invalide'));
        }
        if (!$token) {
            throw new NotFoundException(__('Invalide'));
        }
        $user = $this->User->find('first', array(
            'fields'     => array('id'),
            'conditions' => array('id' => $user_id, 'token' => $token)
        ));
        if (empty($user)) {
            $this->Session->setFlash('Ce lien ne semble pas bon',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller'=>'users','action' => 'forgot'));
        }
        if(!empty($this->request->data)){
            $this->User->create($this->request->data);
            if($this->User->validates()){
                $this->User->create();
                $this->User->save(array(
                    'id' => $user['User']['id'],
                    'token' => '',
                    'active' => 1,
                    'password' => $this->Auth->password($this->request->data['User']['password'])
                ));
                $this->Session->setFlash("Votre mot de passe a bien été modifié","default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller'=>'users','action' => 'login'));
            }
        }
    }

    public function account(){    
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            'contain'=>array('Family')
            ));
        $this->set(compact('user'));     
        
    }


    //Pas encore repris

    public function admin_login(){
    $this->layout = 'admin';

    if(!empty($this->request->data)) {
        if($this->Auth->login()) {
            $id = $this->Auth->user('id');
            $user=$this->User->findById($id);
            if($user['User']['role'] == 'admin'){
                //$this->redirect($this->Auth->redirect());
                $this->redirect('/admin/dashboards'); //Example
            }else{
                // In case a user tries to login thru admin_login
                // You should log them in anyway and send them to where they belond
                $this->redirect(array('controller' => 'users', 'action' => 'account','admin'=>false)); 
            }
        } else {
            $this->Session->setFlash(__('Erreur dans le login ou le mot de passe.'));
        }
    }
}

    public function logout(){
        $this->Auth->logout();
        $this->Session->delete('current_user');
        return $this->redirect('/');
    }


    public function activate($user_id, $token){
        if (!$user_id) {
            throw new NotFoundException(__('Invalide'));
        }
        if (!$token) {
            throw new NotFoundException(__('Invalide'));
        }

        $user = $this->User->find('first', array(
            'fields'     => array('id'),
            'conditions' => array('id' => $user_id, 'token' => $token)
        ));
        if (empty($user)) {
            $this->Session->setFlash('Lien de validation incorrect');
            return $this->redirect('/');
        }
        $this->Session->setFlash('Votre compte a bien été validé');
        $this->User->save(array(
            'id'     => $user['User']['id'],
            'active' => 1,
            'token'  => ''
        ));
        return $this->redirect(array('action' => 'login'));
    }

   public function edit(){
    $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));

        if (!empty($this->request->data)) {
            $this->request->data['User']['id'] = $this->Auth->user('id');
            $this->User->create($this->request->data);
            if($this->User->validates()){
                $this->User->create();
                $this->User->save($this->request->data, true, array('country','firstname','phone','name','birthdate','street','zip_code','city'));


                $user = $this->User->read();
                $this->Auth->login($user['User']);

                $this->Session->setFlash("Vos informations ont bien été modifiées","default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('action' => 'account'));
            }
        }else{
            $this->User->id = $this->Auth->user('id');
            $this->request->data = $this->User->read();
        }
         $this->set(compact('user'));
    }


    public function delete(){
    if(!empty($this->request->data)){
        
        $user = $this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id'))));
            if($this->Auth->password($this->request->data['User']['password']) == $user['User']['password'] && $this->Auth->password($this->request->data['User']['password2']) == $user['User']['password']){
                $this->loadModel('Family');
                $families = $this->Family->find('all',array(
                    'conditions'=>array('Family.user_id'=>$this->Auth->user('id'))));
                $this->loadModel('Defunt');
                $this->loadModel('ClientPage');
                $this->loadModel('Media');
                $this->loadModel('Category');
                $this->loadModel('Limit');
                $limit = $this->Limit->find('all',array(
                    'conditions'=>array('Limit.user_id'=>$this->Auth->user('id'))));
                if(!empty($families)){
                    foreach ($families as $key => $value) {
                        $defunts[$key]=$this->Defunt->find('all',array(
                            'conditions'=>array('Defunt.family_id'=>$value['Family']['id'])));
                    }
                }
                if(!empty($defunts)){
                    foreach ($defunts as $key => $value) {
                        foreach ($value as $k => $def) {
                           $clientpages[$k]=$this->ClientPage->find('all',array(
                            'conditions'=>array('ClientPage.defunt_id'=>$def['Defunt']['id'])));
                        }  
                    }
                }
                if(!empty($defunts)){
                    foreach ($defunts as $key => $value) {
                        foreach ($value as $k => $def) {
                           $medias[$k]=$this->Media->find('all',array(
                            'conditions'=>array('Media.defunt_id'=>$def['Defunt']['id'])));
                        }    
                    }
                }
                if(!empty($defunts)){
                    foreach ($defunts as $key => $value) {
                        foreach ($value as $k => $def) {
                           $categories[$k]=$this->Category->find('all',array(
                            'conditions'=>array('Category.defunt_id'=>$def['Defunt']['id'])));
                        }    
                    }
                }
                if(!empty($defunts)){
                    foreach ($defunts as $key => $value) {
                        foreach ($value as $k => $def) {
                           $dir[$k]=IMAGES . 'medias'. DS .'defunts'. DS .'defunt_'.$def['Defunt']['id'];
                        }    
                    }
                }
                $user = $this->User->findById($this->Auth->user('id'));
                if ($this->User->delete($this->Auth->user('id'))) {
                    if(!empty($families)){
                        foreach ($families as $key => $value) {
                            $this->Family->delete($value['Family']['id']);
                        }
                    }
                    if(!empty($limit)){
                        foreach ($limit as $key => $value) {
                            $this->Limit->delete($value['Limit']['id']);
                        }
                    }
                    if(!empty($dir)){
                        foreach ($dir as $key => $value) {
                            App::uses('Folder', 'Utility');
                            $dir = new Folder($value, 0777);
                            $dir->delete();
                        }
                    }
                    if(!empty($defunts)){
                        foreach ($defunts as $key => $value) {
                            foreach ($value as $k => $def) {
                               $this->Defunt->delete($def['Defunt']['id']);
                            }    
                        }
                    }
                    if(!empty($clientpages)){
                        foreach ($clientpages as $key => $value) {
                            foreach ($value as $k => $def) {
                               $this->ClientPage->delete($def['ClientPage']['id']);
                            }    
                        }
                    }
                    if(!empty($medias)){
                        foreach ($medias as $key => $value) {
                            foreach ($value as $k => $def) {
                               $this->Media->delete($def['Media']['id']);
                            }    
                        }   
                    }
                    if(!empty($categories)){
                        foreach ($categories as $key => $value) {
                            foreach ($value as $k => $def) {
                               $this->Category->delete($def['Category']['id']);
                            }    
                        }
                    }
                    
                    $this->Session->setFlash('Le compte et ses contenus ont bien été supprimés',"default", array('class' => 'alert-box success radius'));
                    $this->Auth->logout();
                    $this->Session->delete('current_user');
                    return $this->redirect('/');
                }  
            }else{
                $this->Session->setFlash('Erreur de mot de passe. Suppression annulée.',"default", array('class' => 'alert-box warning round'));
                return $this->redirect(array('controller'=>'users','action'=>'account'));
            }
        
        }
    
    }

    public function info(){
         $this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
    $this->set(compact('user'));
    }

        public function invite(){
        if(!empty($this->request->data)){
            $user=$this->User->findByEmail($this->request->data['User']['email']);
            $userc=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
            if(!empty($user)){
                $this->loadModel('DefuntUsers');
                $this->DefuntUsers->create(array(
                            'defunt_id'=>$this->request->data['User']['defunt_id'],
                            'user_id'=>$user['User']['id']
                            ));
                if($this->DefuntUsers->save()){
                    $this->Session->setFlash("Invitation envoyée","default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller'=>'clientpages', 'action' => 'manage',$this->request->data['User']['defunt_id']));
                }
            }else{
                $this->loadModel('Defunt');
                $personne = $this->Defunt->find('first',array(
                    'conditions'=>array('Defunt.id'=>$this->request->data['User']['defunt_id'])
                    ));
                App::uses('CakeEmail', 'Network/Email');
                $CakeMail = new CakeEmail('default');
                $CakeMail->to($this->request->data['User']['email']);
                $CakeMail->subject('Invitation à rejoindre Scanepitaphe');
                $CakeMail->template('invitation');
                $CakeMail->viewVars(array('user'=>$userc,'personne'=>$personne,'email'=>$this->request->data['User']['email']));
                $CakeMail->emailFormat('text');
                $CakeMail->send();
                $this->Session->setFlash("Invitation envoyée","default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller'=>'defunts', 'action' => 'editprinc',$this->request->data['User']['defunt_id']));
                
            }
        }
    }

    public function pageinvite($id = null){
        if (!$id) {
            throw new NotFoundException(__('Invalide'));
        }
        $this->loadModel('DefuntUsers');
        $users = $this->DefuntUsers->find('all',array(
            'conditions'=>array('DefuntUsers.defunt_id'=>$id)));
        $this->loadModel('Defunt');
        $personne = $this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$id)));
        $this->set(compact('users','personne'));
    }

    public function delinvite($id = null,$idd = null){
        if (!$id) {
            throw new NotFoundException(__('Invalide'));
        }
        if (!$idd) {
            throw new NotFoundException(__('Invalide'));
        }
        $this->loadModel('DefuntUsers');
        $invit = $this->DefuntUsers->find('first',array(
            'conditions'=>array('DefuntUsers.user_id'=>$id,'DefuntUsers.defunt_id'=>$idd)));
        $this->loadModel('Defunt');
        $personne = $this->Defunt->find('first',array(
            'conditions'=>array('Defunt.id'=>$idd)));

        if ($personne['Defunt']['user_id']==$this->Auth->user('id')) {
            $this->DefuntUsers->delete($invit['DefuntUsers']['id']);
            $this->Session->setFlash("Co-auteur supprimé","default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller'=>'defunts', 'action' => 'editprinc',$personne['Defunt']['id']));
                
        }else{
            $this->Session->setFlash("Vous n'avez pas les droits","default", array('class' => 'alert-box success radius'));
                return $this->redirect(array('controller'=>'defunts', 'action' => 'editprinc',$personne['Defunt']['id']));
                
        }
    }

    public function getuserbyid($id = null){
        $user = $this->User->find('first',array(
            'conditions'=>array('User.id'=>$id)));
        if ($this->request->is('requested')) {
            return $user;         
            } else {
                $this->set('user', $user);
            } 
    }


    public function registerinvit($email,$idd){
        if (!$email) {
            throw new NotFoundException(__('Invalide'));
        }
        if (!$idd) {
            throw new NotFoundException(__('Invalide'));
        }
        $this->set(compact('email'));
    //Vérifier si utilisateur déjà connecté
        if($this->Auth->user('id')) {
            $this->Session->setFlash('Vous êtes déjà enregistré',"default", array('class' => 'alert-box warning round'));
            return $this->redirect(array('controller' => 'users','action' => 'account'));
        }
    //Si pas déjà connecté alors lancer la procedure d'enregistrement
        else{
            //Test si l'utilisateur a saisie les champs pour s'enregistrer et si oui envoi à la base
            
            if (!empty($this->request->data)) {
                if($this->request->data['User']['captcha'] == 7){
                $this->User->create($this->request->data);
                if($this->User->validates()){
                    $token = md5(time() . ' - ' . uniqid());
                    $this->User->create(array(
                        'role' => 'auteur',
                        'username' => $this->request->data['User']['username'],
                        'password' => $this->Auth->password($this->request->data['User']['password']),
                        'email' => $this->request->data['User']['email'],
                        'token' => $token,
                        'active'=>0
                    ));
                    
                     if($this->User->save()){
                        $id = $this->User->id;
                  
                        $this->loadModel('Limit');
                        $lim = $this->requestAction('options/limits/');
                        
                        $this->Limit->create(array(
                            'user_id'=>$id,
                            'text'=>$lim['Option']['content'],
                            'picture'=>$lim['Option']['content'],
                            'sound'=>$lim['Option']['content'],
                            'limittext'=>$lim['Option']['content'],
                            'limitpdf'=>$lim['Option']['content'],
                            'pdf'=>$lim['Option']['content'],
                            'limitpicture'=>$lim['Option']['content'],
                            'limitsound'=>$lim['Option']['content']));
                        $this->Limit->save();

                        $this->loadModel('DefuntUsers');
                        $this->DefuntUsers->create(array(
                                'defunt_id'=>$idd,
                                'user_id'=>$id
                        ));
                        $this->DefuntUsers->save();
                     }
                     
                     //Les enregistrements sont dans la base

                     
                     // Envoi du mail d activation
                    App::uses('CakeEmail', 'Network/Email');
                    $CakeEmail = new CakeEmail('default');
                    $CakeEmail->to($this->request->data['User']['email']);
                    $CakeEmail->subject('Votre inscription Scanepitaphe');
                    $CakeEmail->viewVars(
                        $this->request->data['User'] +
                        array(
                            'token' => $token,
                            'id' => $this->User->id,
      
                        )
                    );
                    $CakeEmail->emailFormat('text');
                    $CakeEmail->template('inscription');
                    $CakeEmail->send();
                     // fin envoi du mail activation

                    
                    $this->Session->setFlash('Inscription réussie. Vous allez recevoir un email d\'activation. Rendez-vous dans votre boite email',"default", array('class' => 'alert-box success radius'));
                    return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
                    
                }else{
                    $this->Session->setFlash('Merci de corriger vos erreurs',"default", array('class' => 'alert-box warning round'));
                }
            
        }else{
                    $this->Session->setFlash('Erreur de captcha',"default", array('class' => 'alert-box warning round'));

        }
        }
    }
    } 

    
}

