<?php

App::uses('CoursesAppController', 'Courses.Controller');

/**
 * CourseGradebooks Controller
 */
class CourseGradebooksController extends CoursesAppController {

	
	public $name = 'CourseGradebooks';
	public $uses = array('Courses.CourseUser', 'Courses.CourseGrade', 'Courses.Course');

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
		
		$this->Course->Task->bindModel(array(
			'hasOne' => array(
				'TaskGradeDetail' => array(
					'className' => 'Courses.CourseGradeDetail',
					'foreignKey' => 'foreign_key',
					'conditions' => array('model' => 'Task', 'course_id' => $courseId)
				)
			)
		));
		
		if ( $courseId ) {
			$this->request->data = $this->Course->find('first', array(
				'conditions' => array('Course.id' => $courseId),
				'contain' => array(
					'CourseGrade',
					'AssignmentGrade',
					'CourseUser' => array('User'),
					'Task' => array('TaskGradeDetail')
				)
			));
			
			//Loop Through Users and Attach Proper Grades
			foreach($this->request->data['CourseUser'] as $index => $value) {
				$this->request->data['CourseUser'][$index]['Grades'] = array();
				$this->request->data['CourseUser'][$index]['CourseGrade'] = '';
				foreach($this->request->data['AssignmentGrade'] as $grade) {
					if($value['user_id'] == $grade['student_id']) {
						$this->request->data['CourseUser'][$index]['Grades'][] = $grade;
					}
				}
				
				foreach($this->request->data['CourseGrade'] as $grade) {
					if($value['user_id'] == $grade['student_id']) {
						$this->request->data['CourseUser'][$index]['CourseGrade'] = $grade;
					}
				}
			}
			
		}

		// need all of My CourseGradeDetails so we can change grades
		$courseGradeDetails = Set::combine($course['CourseGradeDetail'], '{n}.foreign_key', '{n}.id');
		$this->set('courseSelectOptions', $this->Course->find('list', array(
				'conditions' => array(
						'Course.creator_id' => $this->userId,
						'Course.type' => 'course'
				))));
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
