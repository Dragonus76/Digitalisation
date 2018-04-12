<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class Order extends AppModel {
	// public $primaryKey = 'reference';

	public $hasMany = array(
		'pageclientof' => array(
			'className' => 'ClientPage',
			'foreignKey' => 'order_id',
			'dependent' => false //je ne veux pas que mes produits soient effacés si j'efface une commande
		)
	);

	public $belongsTo = array(
		'User' 
	);


public $validate = array(
	'accord' => array(
                'required' => array(
                    'rule'     => array('notEmpty'),
                    'message'  => 'Vous devez accepter les CGV et CGU'
                )),
	
		'paiement' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Choisir un moyen de paiement'
				)
		),
		'dname' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Un nom est requis'
				)
		),
        'dfirstname' => array(
            'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Un prénom est requis'
				)
        ),
        'dstreet' => array(
           'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Une rue est requise'
				)
        ),
       	'dzipcode' => array(
           'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Un code postal est requis'
				)
        ),
        'dcity' => array(
           'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Une ville est requise'
				)
        ),
        'livraison' => array(
           'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Un choix de livraison est requise'
				)
        ),
		);
}