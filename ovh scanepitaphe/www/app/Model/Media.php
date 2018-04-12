<?php
// Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
// Author: Benjamin Guimond
// Author URI: http://push-infographiste.fr
// Version: 1
// Tags: online memorials, biography, e-commerce, individual webpage

// License: CC BY-NC-ND 4.0
// License URI: http://creativecommons.org/licenses/by-nc-nd/4.0/ 
class Media extends AppModel {
	public $actsAs = array('Containable');

	public $belongsTo = array(
		'ClientPage',
		'Defunt',
		'Category',
		'Album',
		'User'
	);

	public $hasAndBelongsToMany = array('Tag'); 

	public $hasMany = array(
		'MediaTag'
	);

	public $validate = array(

		'defunt_id' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Vous n\'avez pas défini de personne'
			)
		),
		'name' => array(
			'rule' => 'notEmpty'
		),
	    'content' => array(
	        'rule' => 'notEmpty',
	        'message' => 'Vous n\'avez pas rempli ce champ'
	    ),
	    'date' => array(
	        'rule' => 'notEmpty'
	    ),	
	    'adressevideo' => array(
	        'rule' => 'notEmpty'
	    )    

	);

	public function beforeSave($options = array()){

		if (isset($this->data[$this->alias]['adressevideo'])) {
			
			$adresse=$this->data[$this->alias]['adressevideo'];
			trim ($adresse);
			$verif = null;
			$verif = strstr($adresse, 'iframe');
			if (!empty($verif)) {
			}else{
				$verif = strstr($adresse, 'watch') ;

					if (!empty($verif)) {
						$recup = strrchr($verif, '=');
						$recup = ltrim($recup," = ");
						$recup = '/'.$recup;
						trim ($recup);						
						$nouvelleadresse ='<iframe width="560" height="315" src="//www.youtube.com/embed'.$recup.'" frameborder="0" allowfullscreen></iframe>';	

						$this->data[$this->alias]['adressevideo'] = $nouvelleadresse;
					}else{
						$recup= strrchr($adresse, '/');
						$nouvelleadresse ='<iframe width="560" height="315" src="//www.youtube.com/embed'.$recup.'" frameborder="0" allowfullscreen></iframe>';	
						$this->data[$this->alias]['adressevideo'] = $nouvelleadresse;
					}
			}
		}
	}	

	public function afterSave($created, $options = array()){
		if(!empty($this->data['Media']['tags'])){
			$tags = explode(',',$this->data['Media']['tags']); 
			foreach($tags as $tag){
				$tag = trim($tag);
				if(!empty($tag)){
					$d = $this->Tag->findByTitle($tag);
					if(!empty($d)){
						$this->Tag->id = $d['Tag']['id']; 
					}else{
						$this->Tag->create(); 
						$this->Tag->save(array(
							'title' => $tag
						)); 
					}
					$this->MediaTag->create(); 
					$this->MediaTag->save(array(
						'media_id' => $this->id,
						'tag_id' => $this->Tag->id
					)); 
				}
			}
		}
	 	return true; 
	}
}