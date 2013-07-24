<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Series Controller
 *
 * @property Series $Series
 */
class CourseSeriesController extends CoursesAppController {

	public $name = 'CourseSeries';
	public $uses = 'Courses.CourseSeries';

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Series->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CourseSeries.parent_id' => null)
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
		$this->CourseSeries->id = $id;
		if (!$this->CourseSeries->exists()) {
			throw new NotFoundException(__('Invalid series'));
		}
		$series =  $this->CourseSeries->find('first', array(
			'conditions' => array('id' => $id),
			'contain' => array(
				'Course' => array(
					'order' => array('Course.order' => 'asc')
				)
			)
		));
		$this->set(compact('series'));
		$this->set('title_for_layout', $series['CourseSeries']['name'] . ' < Series | ' . __SYSTEM_SITE_NAME);
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if ( !empty($this->request->data) ) {
			$this->CourseSeries->create();
			if ($this->CourseSeries->saveAll($this->request->data)) {
				if ( $this->request->is('ajax') ) {
					return new CakeResponse(array('body' => $this->CourseSeries->id));
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
		$courses = $this->CourseSeries->Course->find('list', array( 'conditions' => array('creator_id' => $this->userId) ));
		$this->set(compact('courses'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CourseSeries->id = $id;
		if (!$this->CourseSeries->exists()) {
			throw new NotFoundException(__('Invalid series'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseSeries->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The series has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The series could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseSeries->read(null, $id);
		}
		$courses = $this->CourseSeries->Course->find('all', array(
			'conditions' => array('creator_id' => $this->userId),
			'fields' => array('Course.id', 'Course.parent_id', 'Course.name'),
			'group' => 'Course.parent_id'
			));
		$this->set(compact('courses'));
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
		$this->CourseSeries->id = $id;
		if (!$this->CourseSeries->exists()) {
			throw new NotFoundException(__('Invalid series'));
		}
		if ($this->CourseSeries->delete()) {
			$this->Session->setFlash(__('Series deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Series was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
