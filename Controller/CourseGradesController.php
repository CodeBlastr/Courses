<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Grades Controller
 *
 * @property Grade $Grade
 */
class CourseGradesController extends CoursesAppController {

	public $name = 'CourseGrades';
	public $uses = array('Courses.CourseGrade');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseGrade->recursive = 0;
		$this->set('grades', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CourseGrade->id = $id;
		if (!$this->CourseGrade->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		$this->set('grades', $this->CourseGrade->read(null, $id));
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CourseGrade->create();
			if ($this->CourseGrade->save($this->request->data)) {
				$this->Session->setFlash(__('The Grade has been created'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Grade could not be created. Please, try again.'));
			}
		}
		$parentCourses = $this->CourseGrade->Course->find('list');
		$this->set(compact('parentCourses'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CourseGrade->id = $id;
		if (!$this->CourseGrade->exists()) {
			throw new NotFoundException(__('Invalid Grade'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseGrade->save($this->request->data)) {
				$this->Session->setFlash(__('The Grade has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Grade could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseGrade->read(null, $id);
		}
		$parentCourses = $this->CourseGrade->Course->find('list');
		$this->set(compact('parentCourses'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CourseGrade->id = $id;
		if (!$this->CourseGrade->exists()) {
			throw new NotFoundException(__('Invalid Grade'));
		}
		if ($this->CourseGrade->delete()) {
			$this->Session->setFlash(__('Grade deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Grade was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
/**
 * 
 * @param int $id
 */
	public function setup($id = null) {
		if ( !$this->CourseGrade->Course->exists() ) {
			//throw new NotFoundException(__('Invalid Course'));
		}
		if ( $this->request->is('post') || $this->request->is('put') ) {
			if ($this->CourseGrade->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The Course\'s Gradebook has been saved'));
				$this->redirect(array('controller' => 'courses', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Course\'s GradeBook could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseGrade->Course->read(null, $id);
		}
		if ( empty($id) ) {
			$courses = $this->CourseGrade->Course->find('list', array(
				'conditions' => array(
					'parent_id' => null,
					'creator_id' => $this->Auth->user('id')
				)
			));
			$this->set(compact('courses'));
		}
	}
	
	public function grade($formId, $userId) {
		if ( $this->request->is('post') || $this->request->is('put') ) {
			if ($this->CourseGrade->save($this->request->data)) {
				$this->Session->setFlash(__('Grade Saved.'));
				$this->redirect(array('controller' => 'courses', 'action' => 'view', $this->request->data['CourseGrade']['course_id']));
			} else {
				$this->Session->setFlash(__('Grade could not be saved.'));
			}
		}
		$this->request->data = $this->CourseGrade->find('first', array(
			'conditions' => array( 'CourseGrade.foreign_key' => $formId ),
			'contain' => array(
				'Form' => array(
					'FormInput' => array(
						'FormAnswer' => array(
							'conditions' => array( 'FormAnswer.user_id' => $userId )
						)
					)
				)
			)
		));

	}
	
	/**
	 * Custom Function for Answers Plugin.
	 * Allows inserting Grading Options into form
	 */
	 
	public function answerkey($answerid = null) {
		if(!CakePlugin::loaded('Answers')) {
			throw new MethodNotAllowedException('Answers Plugin is not installed');
		}
		
		$this->loadModel('Answers.Answer');
		
		if($this->request->isPost() && !empty($this->request->data)) {
			$data = array();	
			$data['Answer']['id'] = $this->request->data['Answer']['id'];
			unset($this->request->data['Answer']['id']);
			foreach ($this->request->data['Answer'] as $inputid => $correct) {
				$data['Answer']['data'][$inputid] = $correct;
			}
			$data['Answer']['data'] = json_encode($data['Answer']['data']);
			$this->Answer->save($data, true, array('data'));
			$this->Session->setFlash('Answer Key Saved');
			$this->redirect('/answers/answers/index');
		}
		
		if(!empty($answerid)) {
			$answer = $this->Answer->findById($answerid);
			if(!empty($answer['Answer']['data'])) {
				$answers = $answer['Answer']['data'];
			}
			
		}else{
			$this->Session->setFlash('No Form Id');
			$this->redirect($this->referer());
		}
		
		$this->set('answers_json', $answers);
	 	$this->set('answer', $answer);
	}
		
	
}
