<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * CourseSchools Controller
 *
 * @property CourseSchool $CourseSchool
 * @property PaginatorComponent $Paginator
 */
class CourseSchoolsController extends CoursesAppController {

	public $name = 'CourseSchools';

	public $uses = array('Courses.CourseSchool');
	
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseSchool->recursive = 0;
		$this->set('courseSchools', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CourseSchool->exists($id)) {
			throw new NotFoundException(__('Invalid school'));
		}
		$options = array('conditions' => array('CourseSchool.' . $this->CourseSchool->primaryKey => $id));
		$this->set('courseSchool', $this->CourseSchool->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CourseSchool->create();
			if ($this->CourseSchool->save($this->request->data)) {
				$this->Session->setFlash(__('The school has been saved.'), 'flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The school could not be saved. Please, try again.'), 'flash_danger');
			}
		}
		$this->set('users', $this->CourseSchool->Owner->find('list'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CourseSchool->exists($id)) {
			throw new NotFoundException(__('Invalid school'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CourseSchool->save($this->request->data)) {
				$this->Session->setFlash(__('The school has been saved.'), 'flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The school could not be saved. Please, try again.'), 'flash_danger');
			}
		} else {
			$options = array('conditions' => array('CourseSchool.' . $this->CourseSchool->primaryKey => $id));
			$this->request->data = $this->CourseSchool->find('first', $options);
			$this->set('users', $this->CourseSchool->Owner->find('list'));
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CourseSchool->id = $id;
		if (!$this->CourseSchool->exists()) {
			throw new NotFoundException(__('Invalid school'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CourseSchool->delete()) {
			$this->Session->setFlash(__('The school has been deleted.'), 'flash_success');
		} else {
			$this->Session->setFlash(__('The school could not be deleted. Please, try again.'), 'flash_danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
