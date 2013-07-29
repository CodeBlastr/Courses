<?php
/**
 * CourseUserFixture
 *
 */
class CourseUserFixture extends CakeTestFixture {

	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Courses.CourseUser');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'user_id' => 1,
			'course_id' => 1
		),
	);
}
