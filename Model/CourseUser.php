<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * CourseUser Model
 *
 * @property User $User
 * @property Course $Course
 */
class CourseUser extends CoursesAppModel {
	public $name = 'CourseUser';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'user_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
