<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Course Model
 *
 * @property Course $ParentCourse
 * @property Course $ChildCourse
 */
class Course extends CoursesAppModel {
	public $name = 'Course';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lesson' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Student' => array(
			'className' => 'Users.User',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseUser' => array(
			'className' => 'Courses.CourseUser',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Form' => array(
			'className' => 'Forms.Form',
			'foreignKey' => 'foreign_key'
		),
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'foreign_key'
		),
		'Task' => array(
			'className' => 'Tasks.Task',
			'foreignKey' => 'foreign_key'
		),
		'Grade' => array(
			'className' => 'Courses.Grade',
			'foreignKey' => 'course_id'
		)
	);
	
	public $belongsTo = array(
		'Series' => array(
			'className' => 'Courses.Series',
			'foreignKey' => 'parent_id'
		)
	);
	
//	public $hasAndBelongsToMany = array(
//		'User' => array(
//			'className' => 'Users.User',
//			'join_table' => 'course_users'
//		)
//	);
	
	public function beforeFind(array $queryData) {
		$queryData['conditions'][$this->alias.'.type'] = 'course';
		return $queryData;
	}
	
	public function beforeSave(array $options = array()) {
		$this->data[$this->alias]['type'] = 'course';
		return true;
	}
	
}
