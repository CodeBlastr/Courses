<?php
App::uses('AppModel', 'Model');
class CoursesAppModel extends AppModel {
	
	/**
	 * Added here so its available to all children Models
	 */
	 
	 public function __construct($id = false, $table = null, $ds = null) {
		if(CakePlugin::loaded('Media')) {
			$this->actsAs = array('Media.MediaAttachable');
		}
		parent::__construct();
	 }
	
}