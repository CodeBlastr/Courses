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
	public $fixtures = array(
		'plugin.Courses.CourseUser',
		);

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
	
/**
 * save test
 */
 	public function testSave() {
 		$before = $this->CourseUser->find('count');
 		$data['CourseUser']['user_id'] = 1;
		$data['CourseUser']['course_id'] = 2;
 		debug($this->CourseUser->save($data));
 		$after = $this->CourseUser->find('count');
		$this->assertTrue($after > $before);
 	}

}
