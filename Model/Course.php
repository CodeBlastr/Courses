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
			'className' => 'User.Users',
			'foreignKey' => 'student_id',
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
		)
	);
}
