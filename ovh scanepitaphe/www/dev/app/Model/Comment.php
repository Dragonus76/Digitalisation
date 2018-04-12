<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class Comment extends AppModel {
	public $belongsTo = array(
		'FromPost' => array(
			'className' => 'Media',
			'foreignKey' => 'media_id'
		)
	);

	public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'content' => array(
            'rule' => 'notEmpty'
        ),
        'email_auteur' => array(
        	'rule'    => array('email', true),
        	'message' => 'Merci de soumettre une adresse email valide.'
        ),
        'autor_name' => array(
        	'rule' => 'notEmpty'
        )
    );	


}