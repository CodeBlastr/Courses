<?php
/**
 * CourseUserFixture
 *
 */
class CourseGradeFixture extends CakeTestFixture {

	
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
			'course_id' => '',
			'student_id' => '1',
			'grade' => null,
			'total' => null,
			'notes' => null,
			'type' => '',
			'dropped' => '',
			'data' => '',
			'creator_id' => '1',
			'created' => '2013-08-29 09:24:48',
		),
		array(
			'id' => '2',
			'course_grade_detail_id' => '1',
			'model' => 'Task',
			'foreign_key' => '2',
			'course_id' => '1',
			'student_id' => '1',
			'points_earned' => 40,
			'grade' => '.80',
			'total' => 50,
			'notes' => null,
			'type' => 'Homework',
			'dropped' => '',
			'data' => null,
			'creator_id' => '1',
			'created' => '2013-08-29 09:24:48',
		),
		array(
				'id' => '4',
				'course_grade_detail_id' => '1',
				'model' => 'Task',
				'foreign_key' => '2',
				'course_id' => '1',
				'student_id' => '1',
				'grade' => '.60',
				'points_earned' => 30,
				'total' => 50,
				'notes' => null,
				'type' => 'Homework',
				'dropped' => '',
				'data' => null,
				'creator_id' => '1',
				'created' => '2013-08-29 09:24:48',
		),
		array(
				'id' => '5',
				'course_grade_detail_id' => '1',
				'model' => 'Task',
				'foreign_key' => '2',
				'course_id' => '1',
				'student_id' => '1',
				'points_earned' => 5,
				'grade' => '.50',
				'total' => 10,
				'notes' => null,
				'type' => 'Homework',
				'dropped' => '',
				'data' => null,
				'creator_id' => '1',
				'created' => '2013-08-29 09:24:48',
		),
		array(
				'id' => '6',
				'course_grade_detail_id' => '1',
				'model' => 'Task',
				'foreign_key' => '2',
				'course_id' => '1',
				'student_id' => '1',
				'grade' => '.60',
				'points_earned' => 12,
				'total' => 20,
				'notes' => null,
				'type' => 'Homework',
				'dropped' => '',
				'data' => null,
				'creator_id' => '1',
				'created' => '2013-08-29 09:24:48',
		),
		array(
				'id' => '7',
				'course_grade_detail_id' => '1',
				'model' => 'Task',
				'foreign_key' => '2',
				'course_id' => '1',
				'student_id' => '1',
				'grade' => '.42',
				'total' => 10,
				'points_earned' => 4.2,
				'notes' => null,
				'type' => 'Homework',
				'dropped' => '',
				'data' => null,
				'creator_id' => '1',
				'created' => '2013-08-29 09:24:48',
		),
		array(
			'id' => '3',
			'course_grade_detail_id' => '1',
			'model' => 'Task',
			'foreign_key' => '2',
			'course_id' => '1',
			'student_id' => '1',
			'grade' => .95,
			'points_earned' => 38,
			'total' => 40,
			'type' => 'Tutorial',
			'notes' => null,
			'dropped' => '',
			'data' => null,
			'creator_id' => '1',
			'created' => '2013-08-29 09:24:48',
		),
	);
}
