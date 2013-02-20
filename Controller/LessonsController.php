<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Courses Controller
 *
 * @property Course $Course
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
			throw new NotFoundException(__('Invalid Lesson'));
		}
		$this->set('course', $this->Course->read(null, $id));
	}

/**
 * add method
 * 
 * @param string $type (series|course|lesson)
 * @return void
 */
	public function add($type = 'course') {
		if ($this->request->is('post')) {
			$this->Course->create();
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been created'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be created. Please, try again.'));
			}
		}
		$parentCourses = $this->Course->Lesson->find('list');
		$this->set(compact('parentCourses'));
		$this->render('add_'.$type);
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Course->read(null, $id);
		}
		$parentCourses = $this->Course->Lesson->find('list');
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
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->Course->delete()) {
			$this->Session->setFlash(__('Course deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
