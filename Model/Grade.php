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
		)
	);
	public $hasAndBelongsToMany = array(
		'Student' => array(
			'className' => 'Courses.CourseUsers',
			'foreignKey' => 'student_id',
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
	
}
