<?php

App::uses('CoursesAppController', 'Courses.Controller');

/**
 * CourseGradebooks Controller
 */
class CourseGradebooksController extends CoursesAppController {

	
	public $name = 'CourseGradebooks';
	public $uses = array('Courses.CourseUser', 'Courses.CourseGrade');

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
					'CourseGrade',
					'CourseGradeDetail' => array(
						'fields' => array('id', 'foreign_key')
					),
					'Task' => array(
						'conditions' => array('Task.parent_id' => null),
						'ChildTask'
					)
				)
			));

			// gimmie a nice grade array
			foreach ( $course['CourseGrade'] as $grade ) {
				$grades[ $grade['student_id'] ][ $grade['course_grade_detail_id'] ] = array(
					'id' => $grade['id'],
					'grade' => $grade['grade']
					);
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

		// need all of My CourseGradeDetails so we can change grades
		$courseGradeDetails = Set::combine($course['CourseGradeDetail'], '{n}.foreign_key', '{n}.id');

		$this->set('courseSelectOptions', array_unique( Set::merge($cleanCourses, $myCourses) ));

		// pass the varz !
		$this->set(compact('course', 'grades', 'courseGradeDetails'));
		$this->set('courseUsers', $this->CourseUser->getCourseUsers($courseId));
	}


	public function modifyGrade() {
		if ( $this->request->isAjax() ) {
			$this->autoRender = $this->layout = false;

			$updated = $this->CourseGrade->save(array(
				'id' => $this->request->data['CourseGrade']['id'],
				'course_grade_detail_id' => $this->request->data['CourseGrade']['course_grade_detail_id'],
				'model' => $this->request->data['CourseGrade']['model'],
				'foreign_key' => $this->request->data['CourseGrade']['foreign_key'],
				'course_id' => $this->request->data['CourseGrade']['course_id'],
				'student_id' => $this->request->data['CourseGrade']['student_id'],
				'grade' => $this->request->data['CourseGrade']['grade'],
			));

			if ( $updated ) {
				$Task = ClassRegistry::init('Tasks.Task');
				// check to see if this task is marked as complete
				$Task->find('first', array(
					'conditions' => array(
						'assignee_id' => $this->request->data['CourseGrade']['student_id'],
						'parent_id' => $this->request->data['CourseGrade']['foreign_key']
					),
					'fields' => array('id')
				));

				// mark this task as complete
				$Task->save(array(
					'Task' => array(
						'id' => $Task->id,
						'parent_id' => $this->request->data['CourseGrade']['foreign_key'],
						'assignee_id' => $this->request->data['CourseGrade']['student_id'],
						'is_completed' => 1,
						'completed_date' => date('Y-m-d h:i:s')
						)
					));
				return $this->CourseGrade->id;
			} else {
				return false;
			}
		} else {
			$this->Session->setFlash('Invalid request');
			$this->redirect($this->referer());
		}
	}

}
