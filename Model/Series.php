<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Series Model
 *
 * @property Course $ParentCourse
 */
class Series extends CoursesAppModel {
	
	public $name = 'Series';
	
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
		'Form' => array(
			'className' => 'Forms.Form',
			'foreignKey' => 'foreign_key'
		),
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
