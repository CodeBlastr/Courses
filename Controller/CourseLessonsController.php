<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Lessons Controller
 *
 * @property Lesson $Lesson
 */
class CourseLessonsController extends CoursesAppController {

	public $name = 'CourseLessons';
	public $uses = 'Courses.CourseLesson';
	public $components = array('Template');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseLesson->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CourseLesson.parent_id !=' => null)
		);
		$this->set('lessons', $this->paginate());
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
		$this->CourseLesson->id = $id;
		if (!$this->CourseLesson->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		$lesson =  $this->CourseLesson->find('first', array(
<<<<<<< HEAD
			'conditions' => array('Lesson.id' => $id),
			'contain' => array('Form', 'Media', 'Course')
=======
			'conditions' => array('CourseLesson.id' => $id),
			'contain' => array('Media', 'Course')
>>>>>>> b73b70609c12fd9730fc97d7b47a6e34758dc666
		));

		$this->set(compact('lesson'));
		$this->set('title_for_layout', $lesson['CourseLesson']['name'] . ' < ' . $lesson['Course']['name'] . ' | ' . __SYSTEM_SITE_NAME);
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if ( !empty($this->request->data) ) {
			$this->CourseLesson->create();
			if ($this->CourseLesson->saveAll($this->request->data)) {
				if ( $this->request->is('ajax') ) {
					return new CakeResponse(array('body' => $this->CourseLesson->id));
				} else {
					$this->Session->setFlash(__('The lesson has been created'));
					$this->redirect(array('action' => 'view', $this->CourseLesson->id));
				}
			} else {
				if ( $this->request->is('ajax') ) {
					return false;
				} else {
					$this->Session->setFlash(__('The lesson could not be created. Please, try again.'));
				}
			}
		}
		$parentCourses = $this->CourseLesson->Course->find('list', array(
			'conditions' => array('creator_id' => $this->userId, 'type' => 'course'),
			'order' => array('name' => 'ASC')
			));
		$this->set(compact('parentCourses'));

		$this->set('title_for_layout', 'Create a Lesson | ' . __SYSTEM_SITE_NAME);
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CourseLesson->id = $id;
		if (!$this->CourseLesson->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseLesson->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The lesson has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lesson could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseLesson->read(null, $id);
		}
		$parentCourses = $this->CourseLesson->Course->find('list');
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
		$this->CourseLesson->id = $id;
		if (!$this->CourseLesson->exists()) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		if ($this->CourseLesson->delete()) {
			$this->Session->setFlash(__('Lesson deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lesson was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function watch ($id = null) {
		$this->CourseLesson->id = $id;
		if ( !$this->CourseLesson->exists() ) {
			throw new NotFoundException(__('Invalid lesson'));
		}
		$lesson =  $this->CourseLesson->find('first', array(
			'conditions' => array('CourseLesson.id' => $id),
			'contain' => array('Form', 'Media', 'Course')
		));
		$this->set(compact('lesson'));
		$this->set('title_for_layout', $lesson['CourseLesson']['name'] . ' < ' . $lesson['Course']['name'] . ' | ' . __SYSTEM_SITE_NAME);
	}

}
