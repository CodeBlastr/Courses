<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Series Model
 *
 * @property Course $ParentCourse
 */
class CourseSeries extends CoursesAppModel {
	
	public $name = 'CourseSeries';
	
	public $useTable = 'courses';

	public $actsAs = array('Tree');
	
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
	
	public $hasMany = array(
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'conditions' => array('type' => 'course'),
			'fields' => '',
			'order' => ''
		),
		'Lesson' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'conditions' => array('type' => 'lesson'),
			'fields' => '',
			'order' => ''
		)
	);
	
	public $belongsTo = array(
		'Teacher' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id'
		)
	);
	
	public function beforeSave(array $options = array()) {
		parent::beforeSave($options);
		if(!isset($this->data[$this->alias]['type'])) {
			$this->data[$this->alias]['type'] = 'series';
		}
		return true;
	}

}
