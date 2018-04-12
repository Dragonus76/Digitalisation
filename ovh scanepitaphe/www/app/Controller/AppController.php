<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $helpers = array('Html','Form','Image');

	public $components = array(
        'Session',
        'Cookie',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'scope' => array('User.active' => 1)
                )
            ),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home')
        )
    );

  

    public function beforeFilter() {
        $this->Auth->allow('index', 'view');
        $this->Session->write('User.language',Configure::read('Config.language'));
        if(isset($this->params['language'])){
            if(in_array($this->params['language'], Configure::read('Config.languages'))) {
                 $this->Session->write('User.language',$this->params['language']);
            }                      
        }
        Configure::write('Config.language',$this->Session->read('User.language'));

        }

    protected function _isAuthorized($role_required) {
          if ($this->Auth->user('role') != $role_required) {
                 $this->Session->setFlash(__('Vous n\'avez pas les droits'));
                 $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home','admin'=>false));
            }
   }

    

}
