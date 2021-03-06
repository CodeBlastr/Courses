<?php
App::uses('Course', 'Courses.Model');

/**
 * Course Test Case
 *
 */
class CourseTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('courses.course');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Course = ClassRegistry::init('Course');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Course);

		parent::tearDown();
	}

}
