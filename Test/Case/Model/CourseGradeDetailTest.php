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
		'plugin.Courses.CourseGradeDetail',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CourseGradeDetail = ClassRegistry::init('Courses.CourseGradeDetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CourseGradeDetail);
		parent::tearDown();
	}
	
/**
 * data serialization test
 */
 	public function testDataSave() {
 		$before = $this->CourseGradeDetail->find('first');
 		$this->assertTrue(is_array($before['CourseGradeDetail']['data']));
 	}

}
