<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class MediaTagsController extends AppController {
public $helpers = array('Html', 'Form','Session');
public $components = array('Session','Paginator');
 public $scaffold = 'admin';


	public function delTag($id){
		$this->autoRender=false;
		$this->MediaTag->delete($id);
		return $this->redirect($this->referer());
	}

}