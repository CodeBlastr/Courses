<?php

App::uses('CoursesAppController', 'Courses.Controller');

/**
 * GradeBooks Controller
 */
class GradeBooksController extends CoursesAppController {

	
	public $name = 'GradeBooks';
	public $uses = 'Courses.CourseUser';

	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->helpers[] = 'Number';
	}
	
	
	/**
	 * 
	 * @param int $courseId
	 */
	public function view ( $courseId ) {
		$course = $this->CourseUser->Course->find('first', array(
			'condtions' => array(
				'Course.id' => $courseId
				),
			'contain' => array(
				'Form',
				'Grade',
				'Task' => array(
					'conditions' => array('Task.parent_id' => ''),
					'ChildTask'
				)
			)
		));

		// gimmie a nice grade array
		foreach ( $course['Grade'] as $grade ) {
			$grades[ $grade['student_id'] ][ $grade['foreign_key'] ] = $grade['grade'];
		}
		
		// pass the varz !
		$this->set('course', $course);
		$this->set('grades', $grades);
		$this->set('courseUsers', $this->CourseUser->getCourseUsers($courseId));
	}
	
}