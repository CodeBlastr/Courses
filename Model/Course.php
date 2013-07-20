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
	
	public $actsAs = array('Tree');
	
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
		'Lesson' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Student' => array(
			'className' => 'Users.User',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseUser' => array(
			'className' => 'Courses.CourseUser',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Answer' => array(
			'className' => 'Answers.Answer',
			'foreignKey' => 'foreign_key'
		),
		'Task' => array(
			'className' => 'Tasks.Task',
			'foreignKey' => 'foreign_key'
		),
		'Grade' => array(
			'className' => 'Courses.CourseGrade',
			'foreignKey' => 'course_id'
		),
		'Message' => array(
			'className' => 'Messages.Message',
			'foreignKey' => 'foreign_key'
		)
	);
	
	public $belongsTo = array(
		'Series' => array(
			'className' => 'Courses.CourseSeries',
			'foreignKey' => 'parent_id'
		),
		'Teacher' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id'
		)
	);
	
//	Please stop leaving these comment blocks around with no direction on why or when it will be dealt with. 
// public $hasAndBelongsToMany = array(
//		'User' => array(
//			'className' => 'Users.User',
//			'join_table' => 'course_users'
//		)
//	);
    
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
 * before find method
 * 
 * @param array $queryData
 * @return array
 */
	public function beforeFind(array $queryData) {
		$queryData['conditions'][$this->alias.'.type'] = 'course';
		return $queryData;
	}
	
/**
 * before save method
 * 
 * @param array $options
 * @return true
 */
	public function beforeSave(array $options = array()) {
		$this->data[$this->alias]['type'] = 'course';
		return true;
	}
	
}
