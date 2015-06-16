<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Series Controller
 *
 * @property Series $Series
 */
class AppCourseSeriesController extends CoursesAppController {

	public $name = 'CourseSeries';
	public $uses = 'Courses.CourseSeries';

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseSeries->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'CourseSeries.type' => 'series',
				'OR' => array(
					'CourseSeries.creator_id' => $this->Auth->user('id'),
					'CourseSeries.is_private' => 0,
					) 
				)
		);
		$this->set('page_title', 'All Series being offered');
		$this->set('series', $this->paginate());
	}
	
	
	public function my() {
		$this->CourseSeries->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CourseSeries.type' => 'series',
			'CourseSeries.creator_id' => $this->Auth->user('id'),
			)
		);
		$this->view = 'index';
		$this->set('page_title', 'Series you are teaching');
		$this->set('series', $this->paginate());
	}
	
	public function taking() {
		$this->CourseSeries->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CourseSeries.type' => 'series',
			)
		);
		$this->paginate['contain'] = array('CourseUser', array('conditions' => array('user_id' => $this->Auth->user('id'))));
		$this->view = 'index';
		$this->set('page_title', 'Series you are taking');
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
		$this->set('series', $this->CourseSeries->find('first', array(
			'conditions' => array('CourseSeries.id' => $id),
			'contain' => array(
				'Course' => array(
					'order' => array('Course.order' => 'asc')
				),
				'Teacher'
			)
		)));

		$this->set( 'isEnrolled', $this->CourseSeries->isUserEnrolled($this->userId, $this->viewVars['series']['CourseSeries']['id']) );
		$this->set( 'isOwner', ($this->userId == $this->viewVars['series']['CourseSeries']['creator_id']) );

		$this->set('title_for_layout', $this->viewVars['series']['CourseSeries']['name'] . ' < Series | ' . __SYSTEM_SITE_NAME);
	}


	public function register($id = null) {
		$this->CourseSeries->id = $id;
		if ( !$this->CourseSeries->exists() ) {
			throw new NotFoundException(__('Invalid series'));
		}
		// find all courses in this series
		$seriesCourses = $this->CourseSeries->Course->find('all', array(
			'conditions' => array(
				'parent_id' => $this->CourseSeries->id
			),
			'fields' => array('id')
		));
		// add this user to course_users
		$newRegistrations = array();
		foreach ( $seriesCourses as $seriesCourse ) {
			$newRegistrations[] = array(
				'CourseUser' => array(
					'user_id' => $this->userId,
					'course_id' => $seriesCourse['Course']['id']
				)
			);
		}

		if ( $this->CourseSeries->Course->CourseUser->saveMany($newRegistrations) ) {
			$this->Session->setFlash(__('Registration Successful.'));
			$this->redirect(array('action' => 'view', $this->CourseSeries->id));
		}
	}

	public function unregister($id = null) {
		$this->CourseSeries->id = $id;
		if ( !$this->CourseSeries->exists() ) {
			throw new NotFoundException(__('Invalid series'));
		}
		// find all courses in this series
		$seriesCourses = $this->CourseSeries->Course->find('all', array(
			'conditions' => array(
				'parent_id' => $this->CourseSeries->id
			),
			'fields' => array('id')
		));
		$seriesCourses = Set::extract('/Course/id', $seriesCourses);
		// remove this user from course_users
		$unregistered = $this->CourseSeries->Course->CourseUser->deleteAll(array(
			'CourseUser.user_id' => $this->userId,
			'CourseUser.course_id' => $seriesCourses
		), true, true);
		if ( $unregistered ) {
			$this->Session->setFlash(__('You are no longer registered for this series.'));
			$this->redirect(array('action' => 'view', $this->CourseSeries->id));
		}
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
					$this->redirect(array('action' => 'edit', $this->CourseSeries->id));
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
		if (!$this->CourseSeries->exists() || $id == null) {
			$this->Session->setFlash(__('The series could not be saved. Please, try again.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if(isset($this->request->data['Course'])) {
				//Remove all children first
				$children = $this->CourseSeries->find('all', array(
					'conditions' => array('parent_id' => $this->request->data['CourseSeries']['id'])
				));
				
				if(!empty($children)) {
					for($i = 0 ; $i < count($children) ; $i++ ) {
						$children[$i]['CourseSeries']['parent_id'] = '';
						$children[$i]['CourseSeries']['order'] = 0;
					}
					
					//save the children removing them from the series
					$this->CourseSeries->saveAll($children);
				}
				
				foreach($this->request->data['Course'] as $k => $course) {
					$course['parent_id'] = $this->request->data['CourseSeries']['id'];
					$this->request->data['Course'][$k] = $course;
				}

			}
			if ($this->CourseSeries->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The series has been saved'));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The series could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseSeries->read(null, $id);
		}
		$availablecourses = $this->CourseSeries->Course->find('all', array(
			'conditions' => array('Course.creator_id' => $this->userId,
				'Course.parent_id' => NULL, //Not attached to a Series Yet
				'Course.type' => 'course'
			),
			'fields' => array('Course.id', 'Course.parent_id', 'Course.name'),
			));
		$courses = $this->CourseSeries->Course->find('all', array(
				'conditions' => array(
									'Course.creator_id' => $this->userId,
									'Course.parent_id' => $id,
								),
				'fields' => array('Course.id', 'Course.parent_id', 'Course.name', 'Course.order'),
				'order' => array('Course.order ASC'),
			));
		$this->set(compact('courses', 'availablecourses'));
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

if (!isset($refuseInit)) {
	class CourseSeriesController extends AppCourseSeriesController {}
}
