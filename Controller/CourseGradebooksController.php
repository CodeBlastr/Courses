<?php

App::uses('CoursesAppController', 'Courses.Controller');

/**
 * CourseGradebooks Controller
 */
class CourseGradebooksController extends CoursesAppController {

	
	public $name = 'CourseGradebooks';
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
		if ( $this->request->is('post') && !empty($this->request->data['Course']['id']) ) {
			$courseId = $this->request->data['Course']['id'];
		}
		if ( $courseId ) {
			$course = $this->CourseUser->Course->find('first', array(
				'conditions' => array(
					'Course.id' => $courseId
					),
				'contain' => array(
					'Answer',
					'CourseGrade',
					'Task' => array(
						'conditions' => array('Task.parent_id' => ''),
						'ChildTask'
					)
				)
			));

			// gimmie a nice grade array
			foreach ( $course['CourseGrade'] as $grade ) {
				$grades[ $grade['student_id'] ][ $grade['foreign_key'] ] = $grade['grade'];
			}
		}

		$myCourses = $this->CourseUser->Course->find('list', array(
			'conditions' => array(
				'Course.creator_id' => $this->Auth->user('id'),
				'Course.type' => 'course'
				),
			'fields' => array('Course.id', 'Course.name')
			));

		$coursesAsStudent = $this->CourseUser->find('all', array(
			'conditions' => array('CourseUser.user_id' => $this->Auth->user('id')),
			'contain' => array('Course'),
			'fields' => array('Course.id', 'Course.name')
		));

		foreach ( $coursesAsStudent as $cas ) {
			$cleanCourses[$cas['Course']['id']] = $cas['Course']['name'];
		}

		$this->set('courseSelectOptions', array_unique( Set::merge($cleanCourses, $myCourses) ));

		// pass the varz !
		$this->set('course', $course);
		$this->set('grades', $grades);
		$this->set('courseUsers', $this->CourseUser->getCourseUsers($courseId));
	}
	
}
