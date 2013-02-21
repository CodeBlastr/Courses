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

}
