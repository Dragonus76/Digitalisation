<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class Album extends AppModel {
	public $recursive = -1; 
    public $actsAs = array(
        'Containable'
    );
	public $belongsTo = array(
		'Defunt',
		'Category'
	);

	public $hasMany = array(
		'Media'
	);

	public $hasOne = array(
		'ClientPage'
	);

	public $validate = array(
	 	'date' => array(
            'empty' => array(
                'rule'      => 'notEmpty',
                'message'   => 'Renseigner la date',
            ))
	 	);
}