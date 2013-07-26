<?php
App::uses('CoursesAppController', 'Courses.Controller');
/**
 * Courses Controller
 *
 * @property Course $Course
 */
class _CoursesController extends CoursesAppController {

	public $name = 'Courses';
	public $uses = array('Courses.Course', 'Courses.CourseSeries');
	public $components = array('RequestHandler');
	public $helpers = array('Calendar');

/**
 * index method
 *
 * @return void
 */
	public function index($categoryId = null) {
		$this->set('page_title_for_layout', 'Courses');
		if (!empty($categoryId)) {
			$this->paginate['conditions']['Course.id'] = $this->_categoryIndex($categoryId);
		}
		$this->paginate['conditions']['Course.type'] = 'course';
		$this->Course->recursive = 0;
		$this->paginate['contain'][] = 'Category';
		$this->paginate['contain'][] = 'CourseSeries';
		$this->paginate['contain'][] = 'Teacher';
		$this->paginate['order']['Course.start'] = 'ASC';
		$this->set('courses', $this->paginate());
		if(CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->Course->Category->find('list'));
		}
		
	}
	
	public function _categoryIndex($categoryId = null) {
		$ids = Set::extract('/Categorized/foreign_key', $this->Course->Category->Categorized->find('all', array(
			'conditions' => array(
				'Categorized.category_id' => $categoryId,
				'Categorized.model' => 'Course'
				),
			'fields' => array(
				'Categorized.foreign_key',
				),
			)));
		$this->set('page_title_for_layout', __('%s Courses', $this->Course->Category->field('Category.name', array('Category.id' => $categoryId))));
		return $ids;
	}


	public function dashboard() {
		
		$this->set('title_for_layout', 'Courses Dashboard' . ' | ' . __SYSTEM_SITE_NAME);

		$this->set('upcomingCourses', $this->Course->find('all', array(
			'conditions' => array(
				'Course.start > NOW()',
				'Course.type' => 'course',
				'Course.is_published' => 1
			),
			'order' => array('Course.start' => 'ASC')
		)));
		// teachers
		$this->set('seriesAsTeacher', $seriesAsTeacher = $this->Course->Series->find('all', array(
			'conditions' => array(
				'Series.creator_id' => $this->Auth->user('id'),
				'Series.is_published' => 1
			),
			'contain' => array('Course'),
			'order' => array('Series.end' => 'ASC')
		)));
		
		$this->set('coursesAsTeacher', $coursesAsTeacher = $this->Course->find('all', array(
			'conditions' => array(
				'Course.creator_id' => $this->Auth->user('id'),
				'Course.parent_id' => null,
				'Course.is_published' => 1
			),
			'order' => array('Course.end' => 'ASC')
		)));
		
		$this->set('teaches', $teaches = !empty($seriesAsTeacher) || !empty($coursesAsTeacher) ? true : false);
		
		// students
		$this->set('coursesAsStudent', $this->Course->CourseUser->find('all', array(
			'conditions' => array('CourseUser.user_id' => $this->Auth->user('id')),
			'contain' => array('Course')
		)));

		// get an array of all Course.id this user is related to
		$courseIdsAsTeacher = array_unique(
				Set::merge(
						Set::extract('/Course/id', $this->viewVars['seriesAsTeacher']),
						Set::extract('/Course/id', $this->viewVars['coursesAsTeacher'])
						)
				);
		$courseIdsAsStudent = Set::merge(
				Set::extract('/Course/id', $this->viewVars['coursesAsStudent'])
				);
		$allCourseIds = array_unique( Set::merge($courseIdsAsTeacher, $courseIdsAsStudent ) );
		
		$this->set(compact('courseIdsAsTeacher', 'courseIdsAsStudent', 'allCourseIds'));

		// all tasks
		$this->set('tasks', $this->Course->Task->find('all', array(
			'conditions' => array(
				'Task.model' => 'Course',
				'OR' => array(
					'Task.parent_id' => '',
					'Task.parent_id' => null
				),
				'OR' => array(
					'Task.start_date > NOW()',
					'Task.due_date > NOW()'
				),
				'Task.foreign_key' => $allCourseIds,
			),
			'fields' => array('id', 'name', 'model', 'foreign_key', 'start_date', 'due_date'),
			'order' => array('Task.start_date' => 'ASC'),
			'limit' => 5
		)));
		
		if(CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->Course->Category->find('list'));
		}
		
	}
	
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		
		$course = $this->Course->find('first', array(
			'conditions' => array('Course.id' => $this->Course->id),
			'contain' => array(
				'CourseLesson',
				'CourseGrade',
				'Task' => array(
					'conditions' => array('Task.parent_id' => null),
					'ChildTask'
				),
				'CourseSeries' => array(
					'fields' => array('CourseSeries.id', 'CourseSeries.name', 'CourseSeries.is_sequential')
				),
				'Teacher' => array(
					'fields' => array('Teacher.id', 'Teacher.full_name')
				)
			)
		));
		
		$courseUsers = $this->Course->CourseUser->find('all', array(
			'conditions' => array('CourseUser.course_id' => $this->Course->id),
			'contain' => array('User'),
			'order' => array('User.last_name ASC')
		));
		$courseUsers = Set::combine($courseUsers, '{n}.User.id', '{n}');
		
		if ( $course['Course']['creator_id'] == $this->Session->read('Auth.User.id') ) {
			$this->view = 'teacher_view';
			$isOwner = true;
		} elseif ( !isset($courseUsers[$this->Session->read('Auth.User.id')]) ) {
			$this->view = 'guest_view';
			$isOwner = false;
		} else {
			$this->view = 'registered_view';
			$isOwner = false;
		}

		$this->set('isOwner', $isOwner);
		$this->set('courseUsers', $courseUsers);
		$this->set('course', $course);
		$this->set('title_for_layout', $course['Course']['name'] . ' | ' . __SYSTEM_SITE_NAME);
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			//$this->Course->create();
			$this->request->data['Course']['creator_id'] = $this->Auth->user('id');
			
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been created'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be created. Please, try again.'));
			}
		}
		$this->set('series', $this->Course->Series->find('list'));
		
		if (in_array('Categories', CakePlugin::loaded())) {
			$this->set('categories', $this->Course->Category->find('list'));
		}
		$this->render('add');
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
			$this->Course->contain(array('Category'));
			$this->request->data = $this->Course->read(null, $id);
		}
		$parentCourses = $this->Course->Lesson->find('list');
		$this->set('series', $this->Course->CourseSeries->find('list', array('conditions' => array('CourseSeries.creator_id' => $this->Auth->user('id')))));
		$this->set(compact('parentCourses'));
		if (in_array('Categories', CakePlugin::loaded())) {
			$this->set('categories', $this->Course->Category->find('list'));
		}
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
	
/**
 * register method
 * 
 * @param string $id
 */
	public function register($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		// add this user to course_users
		$newRegistration = $this->Course->CourseUser->create();
		$newRegistration['CourseUser']['user_id'] = $this->Auth->user('id');
		$newRegistration['CourseUser']['course_id'] = $this->Course->id;
		if ( $this->Course->CourseUser->save($newRegistration) ) {
			$this->Session->setFlash(__('Registration Successful.'));
			$this->redirect(array('action' => 'view', $this->Course->id));
		}
	}
	
	public function unregister($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		// remove this user to course_users
		$unregistered = $this->Course->CourseUser->deleteAll(array(
			'CourseUser.user_id' => $this->Auth->user('id'),
			'CourseUser.course_id' => $this->Course->id
		));
		if ( $unregistered ) {
			$this->Session->setFlash(__('You are no longer registered for this course.'));
			$this->redirect(array('action' => 'view', $this->Course->id));
		}
	}
	
	public function gradebook($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The gradebook has been saved'));
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->request->data = $this->Course->read(null, $id);
		}
		$parentCourses = $this->Course->Lesson->find('list');
		$this->set(compact('parentCourses'));
	}
	
	/**
	 * select what type of thing to assign
	 * 
	 * @param type $param
	 */
	public function assign($param = null, $foreignKey = null) {
//		if ( !empty($param) ) {
//			$function = '_assign_' . $param;
//			return $this->{$function};
//		}
		if ( $this->request->is('post') ) {
			$this->request->data['Task']['model'] = 'Course';
			$this->request->data['Task']['foreign_key'] = $foreignKey;
			if ( $this->Course->Task->save($this->request->data) ) {
				$this->Session->setFlash(__('The assignment has been saved.'));
				$this->redirect(array('action' => 'view', $foreignKey));
			}
		}
	}
	
	protected function _assign_quiz() {
		
	}

	public function editAssignment($id) {
		if ( $id ) {
			$this->request->data = $this->Course->Task->find('first', array(
				'conditions' => array('Task.id' => $id),
				'contain' => array('ChildTask')
			));

			$courseUsers = $this->Course->CourseUser->find('all', array(
				'conditions' => array('CourseUser.course_id' => $this->request->data['Task']['foreign_key']),
				'contain' => array('User'),
				'order' => array('User.last_name ASC')
			));
			$this->set('courseUsers', Set::combine($courseUsers, '{n}.User.id', '{n}'));

			// get my Courses to attach to
			$this->set('parentCourses', $this->Course->find('list', array(
				'conditions' => array('creator_id' => $this->userId)
			)));

			$this->view = 'teacher_assignment';
		}
	}
	
	/**
	 * View a task
	 * 
	 * @param string $id The Task ID
	 */
	public function assignment($id, $completed = null) {
		if ( $id ) {
			
			$task = $this->Course->Task->find('first', array(
				'conditions' => array('Task.id' => $id),
				//'contain' => 'Course'
			));
			
			if ( $completed === 'completed' ) {
				// create a child task of this task, assigned to current user, marked complete
				$completedAssignment = $this->Course->Task->create();
				$completedAssignment['Task']['parent_id'] = $id;
				$completedAssignment['Task']['model'] = $task['Task']['model'];
				$completedAssignment['Task']['foreign_key'] = $task['Task']['foreign_key'];
				$completedAssignment['Task']['is_completed'] = '1';
				$completedAssignment['Task']['assignee_id'] = $this->Auth->user('id');
				$completedAssignment['Task']['completed_date'] = date("Y-m-d");
				// save & redirect
				if ( $this->Course->Task->save($completedAssignment) ) {
					$this->Session->setFlash(__('The assignment has been saved.'));
					$this->redirect(array('action' => 'view', $task['Task']['foreign_key']));
				}
			}
			
			$this->set(compact('task'));
			$this->set('title_for_layout', $task['Task']['name'] . ' | ' . __SYSTEM_SITE_NAME);
		} else {
			$this->Session->setFlash(__('Assignment ID not specified.'));
			$this->redirect($this->referer());
		}
	}
	
	/**
	 * 
	 * @param integer $courseId The ID of the Course that these messages belong to
	 */
	public function message($courseId) {
		// find the current messages
//		$this->paginate = array(
//			'conditions' => array(
//				'Message.model' => 'Course',
//				'Message.foreign_key' => $courseId,
//				),
//			'fields' => array(
//				'id',
//				'title',
//				'created',
//				'body',
//				),
//			'contain' => array(
//				'Sender' => array(
//					'fields' => array(
//						'full_name',
//						),
//					),
//				),
//			'order' => array(
//				'Message.created' => 'desc',
//				),
//			);
//		$this->set('messages', $this->paginate('Message'));
		
		// set the foreign_key
		$this->request->data['Message']['foreign_key'] = !empty($courseId) ? $courseId : null;
		
		// setup the array of possible recipients
		$users = $this->Course->CourseUser->find('all', array(
			'conditions' => array('CourseUser.course_id' => $courseId),
			'contain' => array('User' => array('fields' => array('id', 'last_name', 'first_name')))
		));
		$users = Set::combine($users, '{n}.User.id', '{n}');
		foreach ( $users as &$user ) {
			$user = $user['User']['last_name'] . ', ' . $user['User']['first_name'];
		}
		$this->set(compact('users'));
	}
	
	
	/**
	 * @todo I'd like to move the finding and combining to the Model.  Separate functions foreach event Model possibly.
	 */
	public function calendar($type = 'teacher', $courseId) {
		
		// get all Tasks for the requested course
		$tasks = $this->Course->Task->find('all', array(
			'conditions' => array(
				'model' => 'Course',
				'foreign_key' => $courseId
			)
		));

		foreach ( $tasks as $task ) {
			$events[] = array(
				'id' => $task['Task']['id'],
				'title' => $task['Task']['name'],
				'allDay' => false,
				'start' => date('c', strtotime($task['Task']['start_date'])),
				'end' => date('c', strtotime($task['Task']['due_date'])),
				'url' => '/courses/courses/assignment/'.$task['Task']['id'],
				'className' => 'task',
				'color' => '#afca30'
			);
		}

		header("Content-type: application/json");
	    if ( $events === null ) {
	    	return '{}';
		} else {
			return json_encode($events);
		}
	    exit;
	}
}

if (!isset($refuseInit)) {
	class CoursesController extends _CoursesController {}
}
