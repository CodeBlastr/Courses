<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Lesson Model
 *
 * @property Course $ParentCourse
 */
class CourseLesson extends CoursesAppModel {
	
	public $name = 'CourseLesson';
	
	public $alias = 'Lesson';
	
	public $useTable = 'courses';
	
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
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'foreign_key',
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
	);
	
	public function beforeSave(array $options = array()) {
		parent::beforeSave($options);
		$this->data[$this->alias]['type'] = 'lesson';
		return true;
	}
	
}
