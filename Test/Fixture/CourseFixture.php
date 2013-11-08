<?php
/**
 * CourseFixture
 *
 */
class CourseFixture extends CakeTestFixture {

	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Courses.Course');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'parent_id' => null,
			'lft' => 1,
			'rght' => 2,
			'name' => 'Test Course',
			'description' => 'Testing Courses',
			'location' => 'Anywhere',
			'school' => 'Anywhere University',
			'grade' => 0,
			'language' => 'English',
			'start' => '2013-07-10 07:00:00',
			'end' => '2013-12-25 17:00:00',
			'is_published' => 1,
			'is_private' => 0,
			'is_persistant' => 0,
			'is_sequential' => 0
		),
	);
}
