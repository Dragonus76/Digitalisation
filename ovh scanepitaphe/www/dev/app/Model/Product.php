<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class Product extends AppModel {
	public $primaryKey = 'id';

	public $validate = array(
		'name' => array(
		'rule' => 'notEmpty'
		),
		'content' => array(
		'rule' => 'notEmpty'
		),
		'type'=>array(
			'rule'=>'notEmpty'
		),
	);

	//Règle validation de l'upload des images
	public function isUploadedFile($params) {
		$val = array_shift($params);
		if ((isset($val['error']) && $val['error'] == 0) ||
				(!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')
			) {
			return is_uploaded_file($val['tmp_name']);
			}
		return false;
	}
}