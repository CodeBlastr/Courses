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
		)
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
			'foreignKey' => 'foreign_key'
		),
		'CourseGrade' => array(
			'className' => 'Courses.CourseGrade',
			'foreignKey' => 'course_id'
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
		
		$this->data[$this->alias]['type'] = 'course';
		return true;
	}

	
	public function userRemoved($userId, $courseId) {
//		$data['UserGroup']['user_id'] = $userId;
//		$data['UserGroup']['model'] = 'Course';
//		$data['UserGroup']['foreign_key'] = $courseId;
//		$this->removeUserFromUserGroup($data);
	}


/**
 * 
 * @param boolean $created
 */
//	public function afterSave($created) {
//		parent::afterSave($created);
//		if ( $created ) {
//			// create a UserGroup for this Course
//			$data = $this->UserGroup->create(array(
//				'title' => $this->data['Course']['name'],
//				'model' => 'Course',
//				'foreign_key' => $this->id,
//				'owner_id' => CakeSession::read('Auth.User.id')
//			));
//			$this->UserGroup->save($data);
//		}
//	}
	
}
