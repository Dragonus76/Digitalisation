<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel {
    public $recursive = -1; 
    public $actsAs = array(
        'Containable'
    );
	public $validate = array(
		'username' => array(
            'length' => array(
                'rule'      => array('minLength', 5),
                'message'   => 'Doit contenir au moins 5 caractères',
            ),
            'alphanum' => array(
                'rule'      => 'alphanumeric',
                'message'   => 'Doit seulement contenir des chiffres et/ou des lettres. Pas d\'espace',
            ),
            'unique' => array(
                'rule'      => 'isUnique',
                'message'   => 'Déjà pris',
            ),
        ),
        'phone' => array(
        	'num' =>array(
        		'rule' => 'numeric',
        		'message' => 'Votre numéro ne doit contenir que des chiffres')        	
        	),
        'email' => array(
            'email' => array(
                'rule'      => 'email',
                'message'   => 'Adresse email invalide',
            ),
            'unique' => array(
                'rule'      => 'isUnique',
                'message'   => 'Déjà utilisée',
            ),
        ),
        'captcha' => array(
            'empty' => array(
                'rule'      => 'notEmpty',
                'message'   => 'Captcha requis',
            ),
        ),
        'password' => array(
            'empty' => array(
                'rule'      => 'notEmpty',
                'message'   => 'Mot de passe requis',
            ),
        ),
        'password_confirm' => array(
            'compare'    => array(
                'rule'      => 'identicalFields',
                'message'   => 'Les deux mots de passe ne sont pas identiques',
                'required'  => false,
            ),
            'length' => array(
                'rule'      => array('between', 6, 20),
                'message'   => 'Utiliser entre 6 et 20 caractères',
            ),
            'empty' => array(
                'rule'      => 'notEmpty',
                'message'   => 'Requis',
            ),
        ),
		'zip_code' => array(
			'length' => array(
				'rule' => array('maxLength', 5),
				'message' => 'Votre code postal doit contenir 5 chiffres'
				),
			'type' => array(
				'rule'=>'numeric',
				'message'=>'Votre code postal doit contenir uniquement des chiffres')
			),


		);

    public function identicalFields($check, $limit){
        $field = key($check);
        return $check[$field] == $this->data['User']['password'];
    }



	public $hasMany = array(
		'Defunt',
        'Family',
		'ClientPage'
	);
}