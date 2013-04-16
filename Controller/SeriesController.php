<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Series Controller
 *
 * @property Series $Series
 */
class SeriesController extends CoursesAppController {

	public $name = 'Series';
	public $uses = 'Courses.Series';

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Series->recursive = 0;
		$this->paginate = array(
			'conditions' => array('Series.parent_id !=' => null)
		);
		$this->set('series', $this->paginate());
	}

/**
 * view method
 *
 * @todo contain[] Course!
 * 
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Series->id = $id;
		if (!$this->Series->exists()) {
			throw new NotFoundException(__('Invalid series'));
		}
		$series =  $this->Series->find('first', array(
			'conditions' => array('id' => $id),
			'contain' => array('Form', 'Media')
		));
		$this->set(compact('series'));
		$this->set('title_for_layout', $series['Series']['name'] . ' | ' . __SYSTEM_SITE_NAME);
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if ( !empty($this->request->data) ) {
			$this->Series->create();
			if ($this->Series->saveAll($this->request->data)) {
				if ( $this->request->is('ajax') ) {
					return new CakeResponse(array('body' => $this->Series->id));
				} else {
					$this->Session->setFlash(__('The series has been created'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				if ( $this->request->is('ajax') ) {
					return false;
				} else {
					$this->Session->setFlash(__('The series could not be created. Please, try again.'));
				}
			}
		}
		$parentCourses = $this->Series->Course->find('list', array(
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
		$this->Series->id = $id;
		if (!$this->Series->exists()) {
			throw new NotFoundException(__('Invalid series'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Series->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The series has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The series could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Series->read(null, $id);
		}
		$parentCourses = $this->Series->Course->find('list');
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
		$this->Series->id = $id;
		if (!$this->Series->exists()) {
			throw new NotFoundException(__('Invalid series'));
		}
		if ($this->Series->delete()) {
			$this->Session->setFlash(__('Series deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Series was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
