<?php
App::uses('CourseGrade', 'Model');

/**
 * CourseUser Test Case
 *
 */
class CourseGradeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.Courses.CourseGrade',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CourseGrade = ClassRegistry::init('CourseGrade');
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
