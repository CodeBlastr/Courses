<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Grade Model
 *
 * @property Course $ParentCourse
 */
class Grade extends CoursesAppModel {
	
	public $name = 'Grade';
	
	public $useTable = 'course_grades';
	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Student' => array(
			'className' => 'Users.User',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Form' => array(
			'className' => 'Forms.Form',
			'foreignKey' => 'form_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * 
 * @param type $results
 * @param boolean $primary
 * @return type
 */
	public function afterFind($results, $primary = false) {
		parent::afterFind($results, $primary);
		foreach ( $results as &$result ) {
			// parse out the settings of an actual (parent) course
			if ( empty($result['Course']['parent_id']) ) {
				$result['Course']['settings'] = json_decode($result['Course']['settings']);
			}
		}
		
		return $results;
	}
	
/**
 * 
 * @param array $options
 * @return boolean
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		// save Course.settings as json if necessarry
		if ( !empty($this->data['Course']['settings']) ) {
			if ( is_array($this->data['Course']['settings']) ) {
				$this->data['Course']['settings'] = json_encode($this->data['Course']['settings']);
			}
		}
		
		return true;
	}
	

/**
 * Callback from FormAnswer->record()
 *
 * saves an empty grade for the teacher to grade later
 */
	public function afterFormAnswerRecord ( $form, $data ) {
			$grade['Grade']['form_id'] = $data['Form']['id'];
			$grade['Grade']['student_id'] = CakeSession::read('Auth.User.id');
			$grade['Grade']['course_id'] = $form['Form']['foreign_key'];

			if ( $this->save($grade) ) {
				return true;
			} else {
				//break('Grade did not initialize.');
				throw new Exception('Grade did not initialize.');
			}
	}
	
}
