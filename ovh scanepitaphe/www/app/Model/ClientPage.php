<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class ClientPage extends AppModel {
	public $recursive = -1; 
    public $actsAs = array(
        'Containable'
    );
	public $belongsTo = array(
		'User','Family','Defunt'
	);
	public $hasMany = array(
		'Post',
		'Media'		
	);
	

	public $validate = array(
		'background' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Charger une photo de fond'
				)
		)
		);

}