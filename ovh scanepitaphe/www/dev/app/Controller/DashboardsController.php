<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
App::uses('AppController','Controller');
class DashboardsController extends AppController {
        public $helper = array('Html','Form','Session');
    public $components = array('Session');
    public $scaffold = 'admin';

    public function beforeFilter(){
	    parent::beforeFilter();
	    $this->Auth->deny('index');

    }

     

    public function admin_index(){
        $this->_isAuthorized('admin');
    	$this->layout = 'admin';

    	$this->loadModel('Products');
    	$products=$this->Products->find('all');

        $this->loadModel('Pages');
        $pages=$this->Pages->find('all');

    	$this->set(compact('products', 'pages'));
	 }

    public function admin_lispage(){
        $this->_isAuthorized('admin');
        $this->layout = 'admin';

        $this->loadModel('Pages');
        $pages=$this->Pages->find('all');

        $this->set(compact('pages'));
     }

     public function admin_lisopt(){
        $this->_isAuthorized('admin');
        $this->layout = 'admin';

        $this->loadModel('Option');
        $options=$this->Option->find('all');

        $this->set(compact('options'));
     }

}