<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Lessons Controller
 *
 * @property Lesson $Lesson
 */
class LessonsController extends CoursesAppController {

	public $name = 'Lessons';
	public $uses = 'Courses.Lesson';

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lesson->recursive = 0;
		$this->paginate = array(
			'conditions' => array('Lesson.parent_id !=' => null)
		);
		$this->set('lessons', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Lesson->id = $id;
		if (!$this->Lesson->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		$this->set('lessons', $this->Lesson->read(null, $id));
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if ( !empty($this->request->data) ) {
			$this->Lesson->create();
			if ($this->Lesson->saveAll($this->request->data)) {
				if ( $this->request->is('ajax') ) {
					return new CakeResponse(array('body' => $this->Lesson->id));
				} else {
					$this->Session->setFlash(__('The lesson has been created'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				if ( $this->request->is('ajax') ) {
					return false;
				} else {
					$this->Session->setFlash(__('The lesson could not be created. Please, try again.'));
				}
			}
		}
		$parentCourses = $this->Lesson->Course->find('list', array(
			'conditions' => array('creator_id' => $this->userId)
			));
		$this->set(compact('parentCourses'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Lesson->id = $id;
		if (!$this->Lesson->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lesson->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The lesson has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lesson could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Lesson->read(null, $id);
		}
		$parentCourses = $this->Lesson->Course->find('list');
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
		$this->Lesson->id = $id;
		if (!$this->Lesson->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		if ($this->Lesson->delete()) {
			$this->Session->setFlash(__('Lesson deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lesson was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
