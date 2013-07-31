<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Series Model
 *
 * @property Course $ParentCourse
 */
class CourseSeries extends CoursesAppModel {
	
	public $name = 'CourseSeries';
	
	public $useTable = 'courses';

	public $actsAs = array('Tree');
	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	
	public $hasMany = array(
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'conditions' => array('type' => 'course'),
			'fields' => '',
			'order' => ''
		),
		'Lesson' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'conditions' => array('type' => 'lesson'),
			'fields' => '',
			'order' => ''
		)
	);
	
	public $belongsTo = array(
		'Teacher' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id'
		)
	);
	
	public function beforeSave(array $options = array()) {
		parent::beforeSave($options);
		if(!isset($this->data[$this->alias]['type'])) {
			$this->data[$this->alias]['type'] = 'series';
		}
		return true;
	}

/**
 * 
 * @param string $userId
 * @param string $seriesId
 * @return boolean
 */
	public function isUserEnrolled($userId, $seriesId) {
		// find all course IDs in this series
		$seriesCourses = $this->find('all', array(
			'conditions' => array('parent_id' => $seriesId),
			'fields' => array('id')
		));
		// find this user's enrolled courses
		$userCourses = $this->Course->CourseUser->find('all', array(
			'conditions' => array('CourseUser.user_id' => $userId),
			'contain' => array(
				'Course' => array(
					'fields' => array('id')
				)
			)
		));

		// compare and return
		$seriesCourses = Set::extract('/CourseSeries/id', $seriesCourses);
		$userCourses = Set::extract('/Course/id', $userCourses);

		$collision = array_intersect($userCourses, $seriesCourses);
//debug($seriesCourses);
//debug($userCourses);
//debug($collision);
//break;
		return ( count($collision) == count($seriesCourses) );
	}

}
