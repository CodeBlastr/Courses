<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Grade Model
 *
 * @property Course $ParentCourse
 */
class CourseGradeAnswer extends CoursesAppModel {
	
	public $name = 'CourseGradeAnswer';
	
	public $useTable = 'course_grade_answers';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Courses.CourseGradeDetail',
			'foreignKey' => 'course_grade_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Student' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		
		$this->data['CourseGradeAnswer']['value'] = serialize($this->data['CourseGradeAnswer']['value']);
		
		return true;
	}
	
	public function afterFind($results, $primary = false) {
		
		if(is_array($results['CourseGradeAnswer'])) {
			foreach ($results['CourseGradeAnswer'] as $key => $value) {
				if($key == 'value') {
					$results['CourseGradeAnswer'][$key] = unserialize($value);
				}
			}
		}else {
			$results['CourseGradeAnswer']['value'] = unserialize($results['CourseGradeAnswer']['value']);
		}
		
		return $results;
	}
	
}
