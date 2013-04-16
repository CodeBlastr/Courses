<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Grades Controller
 *
 * @property Grade $Grade
 */
class GradesController extends CoursesAppController {

	public $name = 'Grades';
	public $uses = array('Courses.Grade');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Grade->recursive = 0;
		$this->set('grades', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Grade->id = $id;
		if (!$this->Grade->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		$this->set('grades', $this->Grade->read(null, $id));
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Grade->create();
			if ($this->Grade->save($this->request->data)) {
				$this->Session->setFlash(__('The Grade has been created'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Grade could not be created. Please, try again.'));
			}
		}
		$parentCourses = $this->Grade->Course->find('list');
		$this->set(compact('parentCourses'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Grade->id = $id;
		if (!$this->Grade->exists()) {
			throw new NotFoundException(__('Invalid Grade'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Grade->save($this->request->data)) {
				$this->Session->setFlash(__('The Grade has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Grade could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Grade->read(null, $id);
		}
		$parentCourses = $this->Grade->Course->find('list');
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
		$this->Grade->id = $id;
		if (!$this->Grade->exists()) {
			throw new NotFoundException(__('Invalid Grade'));
		}
		if ($this->Grade->delete()) {
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
	public function setup() {
		if ( !$this->Grade->Course->exists() ) {
			//throw new NotFoundException(__('Invalid Course'));
		}
		if ( $this->request->is('post') || $this->request->is('put') ) {
			if ($this->Grade->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The Course\'s Gradebook has been saved'));
				$this->redirect(array('controller' => 'courses', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Course\'s GradeBook could not be saved. Please, try again.'));
			}
		} else {
			//$this->request->data = $this->Grade->Course->read(null, $id);
		}
		$courses = $this->Grade->Course->find('list', array(
			'conditions' => array(
				'parent_id' => null,
				'creator_id' => $this->Auth->user('id')
			)
		));
		$this->set(compact('courses'));
	}
	
	public function grade($formId, $userId) {
		if ( $this->request->is('post') || $this->request->is('put') ) {
			if ($this->Grade->save($this->request->data)) {
				$this->Session->setFlash(__('Grade Saved.'));
				$this->redirect(array('controller' => 'courses', 'action' => 'view', $this->request->data['Grade']['course_id']));
			} else {
				$this->Session->setFlash(__('Grade could not be saved.'));
			}
		}
		$this->request->data = $this->Grade->find('first', array(
			'conditions' => array( 'Grade.form_id' => $formId ),
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
	
}
