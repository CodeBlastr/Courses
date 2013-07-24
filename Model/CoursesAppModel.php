<?php
App::uses('AppModel', 'Model');
class CoursesAppModel extends AppModel {
	
/**
 * Constructor
 *
 * Added media.attachable here so its available to all children Models
 * 
 * @return void
 */ 
	public function __construct($id = false, $table = null, $ds = null) {
		if(CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
			
			$this->hasMany['Media'] = array(
				'className' => 'Media.Media',
				'foreignKey' => 'foreign_key',
				'dependent' => false, // hmm... maybe should be true?
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			);
		}
		parent::__construct($id, $table, $ds); 
	}
	
}