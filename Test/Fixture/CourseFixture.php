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
			'id' => 1,
			'parent_id' => 1,
			'lft' => 1,
			'rght' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'location' => 'Lorem ipsum dolor sit amet',
			'school' => 'Lorem ipsum dolor sit amet',
			'grade' => 'Lorem ipsum dolor sit amet',
			'language' => 'Lorem ipsum dolor sit amet',
			'start' => '2013-02-18 21:49:48',
			'end' => '2013-02-18 21:49:48',
			'is_published' => 1,
			'is_private' => 1,
			'is_persistant' => 1,
			'is_sequential' => 1
		),
	);
}
