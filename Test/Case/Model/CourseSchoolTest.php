<?php
App::uses('CourseSchool', 'Courses.Model');

/**
 * CourseSchool Test Case
 *
 */
class CourseSchoolTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.courses.course_school',
		'plugin.courses.owner',
		'plugin.courses.creator',
		'plugin.courses.modifier'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CourseSchool = ClassRegistry::init('Courses.CourseSchool');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CourseSchool);

		parent::tearDown();
	}

}
