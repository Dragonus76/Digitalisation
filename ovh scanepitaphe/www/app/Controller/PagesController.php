<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {
	public $scaffold = 'admin';
	 public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->allow('display');
    }
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$this->Page->locale = Configure::read('Config.language');
		$abouts=$this->Page->findById(1);
		$contacts=$this->Page->findById(4);
		$faqs=$this->Page->findById(2);
		$cheques=$this->Page->findById(5);
		$cgus=$this->Page->findById(6);
		$mlegals=$this->Page->findById(7);
		$annonce=$this->Page->findById(8);
		$videoaccueil=$this->Page->findById(10);

		$cgvs=$this->Page->findById(3);
		$pags=$this->Page->find('all', array('conditions' => array("NOT" => array(
        'Page.id' => array('5', '8', '10')
    ))));
		$this->set(compact('abouts','contacts','faqs','cheques','cgus','mlegals','annonce','videoaccueil','cgvs','pags'));


		// fin ajout perso
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		if($page=='home'){
		$this->layout = 'home';
		$this->loadModel('User');
        $user=$this->User->find('first',array(
            'conditions'=>array('User.id'=>$this->Auth->user('id')),
            ));
        $this->set(compact('user'));
		}
		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function admin_edit($id = null) {
		$this->Page->locale = Configure::read('Config.languages');
		$this->_isAuthorized('admin');
		$this->layout = 'admin';
		if (!$id){
			throw new NotFoundException(__('Page invalide'));
		}
		$page = $this->Page->findById($id);
		if (!$page){
			throw new NotFoundException(__('Page invalide'));
		}
		if ($this->request->is(array('post','put'))) {

			$this->Page->$id = $id;
			if ($this->Page->save($this->request->data, true, array('title'=>$this->request->data['Page']['title']['fra'])
				)) {

        $this->Session->setFlash(__('Page mise à jour'),"default", array('class' => 'alert-box success radius'));
				
				return $this->redirect(array('controller' => 'dashboards', 'action' => 'index','admin'=>true));
			}
        $this->Session->setFlash(__('Impossible de mettre à jour la page'),"default", array('class' => 'alert-box warning round'));

	
		}
		if (!$this->request->data) {
			$this->Page->id = $id;
			$this->request->data = $this->Page->readAll();
			
		}
		$this->set(compact('page'));
	}
}
