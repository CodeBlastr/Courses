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
	public function view ( $courseId = null ) {
		if ( $courseId ) {
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
		}

		$myCourses = $this->CourseUser->Course->find('list', array(
			'conditions' => array(
				'Course.creator_id' => $this->Auth->user('id')
				),
			'fields' => array('Course.id', 'Course.name')
			));

		$coursesAsStudent = $this->CourseUser->find('all', array(
			'conditions' => array('CourseUser.user_id' => $this->Auth->user('id')),
			'contain' => array('Course'),
			'fields' => array('Course.id', 'Course.name')
		));

		foreach ( $coursesAsStudent as $course ) {
			$cleanCourses[$course['Course']['id']] = $course['Course']['name'];
		}
		
		$this->set('courseSelectOptions', array_unique( Set::merge($cleanCourses, $myCourses) ));

		// pass the varz !
		$this->set('course', $course);
		$this->set('grades', $grades);
		$this->set('courseUsers', $this->CourseUser->getCourseUsers($courseId));
	}
	
}
