<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Course Grade Detail Model - Used to store grading details for each grade given.
 *
 * @property Course $ParentCourse
 */
class CourseGradeDetail extends CoursesAppModel {
	
	public $name = 'CourseGradeDetail';
	
	public $useTable = 'course_grade_details';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Teacher' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public $hasMany = array(
		'GradeAnswers' => array(
			'className' => 'Courses.CourseGrade',
			'foreignKey' => 'course_grade_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
}
