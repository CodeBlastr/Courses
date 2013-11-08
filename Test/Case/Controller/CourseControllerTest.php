<?php
App::uses('CoursesController', 'Courses.Controller');

/**
 * TestCoursesController *
 */
class TestCoursesController extends CoursesController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * CoursesController Test Case
 *
 */
class CoursesControllerTestCase extends ControllerTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
			'plugin.Courses.Course', 
			'plugin.Courses.CourseGradeDetail', 
			'plugin.Media.Media', 			
			'plugin.Media.MediaAttachment',
			'plugin.Ratings.Rating',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Courses = new TestCoursesController();
		$this->Courses->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Courses);

		parent::tearDown();
	}

/**
 * course grade settings method
 * Testing to for proper course grade detail 
 * data format and proper course settings
 */
	public function testCourseGradeSettings($id = 1) {
		debug('test working');
		debug($this->Courses->Course->find('all'));
	}
}
