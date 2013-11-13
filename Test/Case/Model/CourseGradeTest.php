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
		'plugin.Courses.CourseGradeDetail',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CourseGrade = ClassRegistry::init('Courses.CourseGrade');
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
 	 * Course Update Grading Method
 	 */
 	public function testupdateCourseGrade() {
 		$this->CourseGrade->studentId = 1;
 		$detail = $this->CourseGrade->GradeDetail->find('all');
 		$result = $this->CourseGrade->updateCourseGrade($detail[0]['GradeDetail']['course_id']);
 	}

}
