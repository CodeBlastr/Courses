<?php
App::uses('CourseUser', 'Model');

/**
 * CourseUser Test Case
 *
 */
class CourseUserTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.course_user', 'app.user', 'app.course');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CourseUser = ClassRegistry::init('CourseUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CourseUser);

		parent::tearDown();
	}

}
