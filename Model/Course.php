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

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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

	public $hasOne = array(
		'UserGroup' => array(
			'className' => 'Users.UserGroup',
			'foreignKey' => 'foreign_key'
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

		if(CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
			
			$this->hasMany['Media'] = array(
				'className' => 'Media.Media',
				'foreignKey' => 'foreign_key',
				'dependent' => false, // Incase Media is attached to more that one model
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			);
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
			// create a UserGroup for this Course
			$data = $this->UserGroup->create(array(
				'title' => $this->data['Course']['name'],
				'model' => 'Course',
				'foreign_key' => $this->id,
				'owner_id' => CakeSession::read('Auth.User.id')
			));
			$this->UserGroup->save($data);
			
			// we say in the model when people get subscribed
			if (in_array('Subscribers', CakePlugin::loaded())) {
				$this->subscribe(CakeSession::read('Auth.User.id'));
			}
		}
	}
	
}
