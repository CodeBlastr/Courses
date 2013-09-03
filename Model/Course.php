<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Course Model
 *
 * @property Course $ParentCourse
 * @property Course $ChildCourse
 */
class Course extends CoursesAppModel {
	
	public $name = 'Course';
	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


/**
 * Behavior list
 * @var array 
 */
	public $actsAs = array(
		'Tree',
		'Users.UserGroupable' => array(
			'hasMany' => 'CourseUser'
		),
		'Courses.Gradeable',
	);


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CourseLesson' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => array('CourseLesson.type' => 'lesson'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseUser' => array(
			'className' => 'Courses.CourseUser',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Task' => array(
			'className' => 'Tasks.Task',
			'foreignKey' => 'foreign_key',
			'sort' => 'created',
		),
		'CourseGrade' => array(
			'className' => 'Courses.CourseGrade',
			'foreignKey' => 'foreign_key',
			'conditions' => array('model' => 'Course'),
		),
		'AssignmentGrade' => array(
			'className' => 'Courses.CourseGrade',
			'foreignKey' => 'course_id',
			'conditions' => array('model NOT' => 'Course'),
		),
		'Message' => array(
			'className' => 'Messages.Message',
			'foreignKey' => 'foreign_key'
		)
	);
	
	public $belongsTo = array(
		'CourseSeries' => array(
			'className' => 'Courses.CourseSeries',
			'foreignKey' => 'parent_id',
			'conditions' => array('CourseSeries.type' => 'series'),
		),
		'Teacher' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id'
		)
	);


    
	public function __construct($id = null, $table = null, $ds = null) {
		if (in_array('Categories', CakePlugin::loaded())) {
			$this->hasAndBelongsToMany['Category'] = array(
	            'className' => 'Categories.Category',
	       		'joinTable' => 'categorized',
	            'foreignKey' => 'foreign_key',
	            'associationForeignKey' => 'category_id',
	    		'conditions' => 'Categorized.model = "Course"',
	    		// 'unique' => true,
	            );
			$this->actsAs['Categories.Categorizable'] = array('modelAlias' => 'Course');
		}
		if (in_array('Subscribers', CakePlugin::loaded())) {
			$this->actsAs['Subscribers.Subscribable'] = array('modelAlias' => 'Course');
		}
		if (in_array('Ratings', CakePlugin::loaded())) {
			$this->actsAs[] = 'Ratings.Ratable';
		}
		if(CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
			
			// $this->hasMany['Media'] = array(
				// 'className' => 'Media.Media',
				// 'foreignKey' => 'foreign_key',
				// 'dependent' => false, // Incase Media is attached to more that one model
				// 'conditions' => '',
				// 'fields' => '',
				// 'order' => '',
				// 'limit' => '',
				// 'offset' => '',
				// 'exclusive' => '',
				// 'finderQuery' => '',
				// 'counterQuery' => ''
			// );
		}
		
		parent::__construct($id, $table, $ds);
	}


/**
 * before save method
 * 
 * @param array $options
 * @return true
 */
	public function beforeSave(array $options = array()) {
		parent::beforeSave($options);
		
		if(!isset($this->data[$this->alias]['type'])) {
			$this->data[$this->alias]['type'] = 'course';
		}
		
		return true;
	}


/**
 * after save call back
 * @param boolean $created
 */
	public function afterSave($created) {
		parent::afterSave($created);
	
		if ( $created ) {	
			// we say in the model when people get subscribed
			if (in_array('Subscribers', CakePlugin::loaded())) {
				$this->subscribe(CakeSession::read('Auth.User.id'));
			}
		}
	}


/**
 *
 * @param int $userId
 * @param string $courseId
 * @return boolean
 */
	public function canUserTakeCourse($userId, $courseId) {
		// get all Course Completion data for this user
		$completion = $this->CourseUser->find('all', array(
			'conditions' => array('CourseUser.user_id' => $userId)
		));
		// get the course's information
		$course = $this->find('first', array(
			'conditions' => array('Course.id' => $courseId),
			'contain' => array(
				'CourseSeries' => array(
					'fields' => array('CourseSeries.id', 'CourseSeries.is_sequential'),
					'Course' => array(
						'fields' => array('Course.order'),
					)
				),
			)
		));

		$completedCourses = array();
		foreach ( $completion as $mightBeCompleted ) {
			if ( $mightBeCompleted['CourseUser']['is_complete'] == true ) {
				$completedCourses[] = $mightBeCompleted['CourseUser']['course_id'];
			}
		}

		$canTakeCourse = true;
		if ( $course['CourseSeries']['is_sequential'] == 1 && $course['Course']['order'] !== 0 ) {
			for ( $index = 0; $index < $course['Course']['order']; $index++ ) {
				if ( in_array($course['CourseSeries']['Course'][$index]['id'], $completedCourses) ) {
					$canTakeCourse = true;
				} else {
					$canTakeCourse = false;
					break;
				}
			}
		}

		return $canTakeCourse;
	}

}
