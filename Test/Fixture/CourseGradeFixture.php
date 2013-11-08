<?php
/**
 * CourseUserFixture
 *
 */
class CourseGrade extends CakeTestFixture {

	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Courses.CourseGrade');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'course_grade_detail_id' => '1',
			'model' => 'Course',
			'foreign_key' => '1',
			'course_id' => '1',
			'student_id' => '1',
			'grade' => null,
			'total' => null,
			'notes' => null,
			'dropped' => '',
			'data' => '',
			'creator_id' => '1',
			'created' => '2013-08-29 09:24:48',
		),
		array(
				'id' => '1',
				'course_grade_detail_id' => '1',
				'model' => 'Task',
				'foreign_key' => '2',
				'course_id' => '1',
				'student_id' => '1',
				'grade' => '.80',
				'total' => 50,
				'notes' => null,
				'dropped' => '',
				'data' => array(
					'type' => 'Homework'
				),
				'creator_id' => '1',
				'created' => '2013-08-29 09:24:48',
		),
		array(
				'id' => '1',
				'course_grade_detail_id' => '1',
				'model' => 'Task',
				'foreign_key' => '2',
				'course_id' => '1',
				'student_id' => '1',
				'grade' => .95,
				'total' => 40,
				'notes' => null,
				'dropped' => '',
				'data' => array(
					'type' => 'Tutorial'
				),
				'creator_id' => '1',
				'created' => '2013-08-29 09:24:48',
		),
	);
}
